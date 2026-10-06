---
title: Certbot — Automatische Let's Encrypt TLS-Zertifikate einrichten
description: Vollständiger Einsteiger-Leitfaden zur Installation von Certbot, Ausstellung kostenloser SSL/TLS-Zertifikate, HTTP-01 vs DNS-01 Challenges und automatischer Verlängerung.
category: linux-packages
order: 40
tags: [certbot, letsencrypt, ssl, tls, sicherheit, nginx, caddy, apache]
updated: 2026-10-06
related: [security/tls-letsencrypt, selfhosting/nginx-reverse-proxy-tls, dns/a-aaaa-records, domains/choosing-tld]
---

## Was ist Certbot und ACME?

Im modernen Internet gilt unverschlüsseltes HTTP als veraltet und unsicher. Browser kennzeichnen unverschlüsselte Seiten als "Nicht sicher", moderne Web-APIs verweigern den Dienst und Suchmaschinen stufen ungesicherte Webseiten im Ranking ab.

**Certbot** ist ein freies Kommandozeilenwerkzeug der Electronic Frontier Foundation (EFF). Es kommuniziert über das standardisierte **ACME-Protokoll** (Automated Certificate Management Environment) mit der kostenlosen Zertifizierungsstelle **Let's Encrypt**, um den Domainbesitz automatisch zu validieren, kryptografisch signierte X.509-SSL/TLS-Zertifikate auszustellen und diese vor Ablauf selbstständig zu erneuern.

```text
[ Dein Server (Certbot) ] ──(1. Zertifikatsanfrage für example.com)──► [ Let's Encrypt CA ]
            │                                                                  │
            │◄───(2. ACME-Challenge: Datei auf Port 80 bereitstellen)──────────┤
            │                                                                  │
            ├────(3. Stellt Token unter /.well-known/acme-challenge/ bereit)──►│
            │                                                                  │
            │◄───(4. Validiert! Stellt signiertes 90-Tage TLS-Zertifikat aus)──┘
```

---

## 1. Installation: Snap vs. APT

Die EFF empfiehlt offiziell die Installation über **Snap**, da Snap-Pakete unabhängig von Distributionszyklen stets auf dem neuesten Stand des ACME-Protokolls und moderner Verschlüsselungsstandards gehalten werden.

### Option A: Empfohlene Installation via Snap
```bash
sudo apt update
sudo apt install -y snapd
sudo snap install core
sudo snap refresh core
sudo snap install --classic certbot
sudo ln -s /snap/bin/certbot /usr/bin/certbot
```

#### Die Befehle im Detail:
- `snap install core`: Installiert die Snap-Laufzeitumgebung.
- `snap refresh core`: Stellt sicher, dass die Laufzeitumgebung aktuell ist.
- `snap install --classic certbot`: Installiert Certbot. Der Parameter `--classic` gewährt Certbot die notwendigen Systemrechte zum Speichern von Zertifikaten unter `/etc/letsencrypt/`.
- `ln -s /snap/bin/certbot /usr/bin/certbot`: Erstellt einen symbolischen Link, damit `certbot` direkt in jedem Terminal aufgerufen werden kann.

---

### Option B: Alternative Installation via Standard-APT
Falls du auf deinem System kein Snap einsetzen möchtest:
```bash
sudo apt update
sudo apt install -y certbot python3-certbot-nginx
```

---

## 2. Die verschiedenen Validierungsmethoden

Certbot bietet verschiedene Plugins zur Überprüfung des Domainbesitzes:

| Methode | Einsatzbereich | Benötigter Port | Server-Neustart |
|---------|----------------|:---------------:|:---------------:|
| **`--nginx`** | Nginx Webserver im Einsatz | 80 & 443 | Automatisch |
| **`--apache`** | Apache Webserver im Einsatz | 80 & 443 | Automatisch |
| **`--standalone`** | Eigene Dienste (Node.js, Docker, Mail) | 80 | Blockiert Port kurzzeitig |
| **`--webroot`** | Bestehender Webserver mit Document Root | 80 | Keine Ausfallzeit (Zero Downtime) |
| **`--manual --preferred-challenges dns`** | Wildcard-Zertifikate (`*.example.com`) | DNS TXT-Eintrag | Keiner |

---

## 3. Praxis-Beispiele zur Zertifikatsausstellung

### Szenario 1: Automatische Nginx-Konfiguration (Standard)
Certbot liest deine Nginx-Konfiguration aus, verifiziert die Domain, richtet HTTPS in `/etc/nginx/sites-available/` ein und lädt Nginx neu:

```bash
sudo certbot --nginx -d example.com -d www.example.com --agree-tos -m admin@example.com --no-eff-email
```

#### Erklärung der Parameter:
- `--nginx`: Verwendet das Nginx-Plugin für Validierung und automatische Konfigurationsanpassung.
- `-d example.com`: Bestimmt den Domainnamen. Kann mehrfach angegeben werden, um ein Multi-Domain-Zertifikat (SAN) zu erstellen.
- `--agree-tos`: Akzeptiert die Let's Encrypt Nutzungsbedingungen automatisch.
- `-m admin@example.com`: Kontakt-E-Mail für wichtige Sicherheits- und Ablaufwarnungen.
- `--no-eff-email`: Verhindert Werbe- und Newsletter-Mails der EFF während des Setups.

---

### Szenario 2: Webroot-Modus (Keine Konfigurationsänderung)
Wenn du eine bestehende Webseite betreibst und Certbot deine Webserver-Konfiguration nicht antasten soll:

```bash
sudo certbot certonly --webroot -w /var/www/html -d example.com -d www.example.com
```

#### Erklärung der Parameter:
- `certonly`: Weist Certbot an, das Zertifikat nur herunterzuladen und zu speichern, ohne Konfigurationsdateien zu bearbeiten.
- `--webroot`: Legt die Validierungsdatei im Document-Root deines Webservers ab (`/.well-known/acme-challenge/`).
- `-w /var/www/html`: Der absolute Pfad zum Document-Root der Domain.

Die Zertifikatsdateien werden gespeichert unter:
- **Zertifikat**: `/etc/letsencrypt/live/example.com/fullchain.pem`
- **Privater Schlüssel**: `/etc/letsencrypt/live/example.com/privkey.pem`

---

### Szenario 3: Standalone-Modus (Kein Webserver aktiv)
Für eigene APIs, Docker-Container oder Mailserver, wenn Port 80 noch frei ist:

```bash
sudo certbot certonly --standalone -d api.example.com
```

Certbot startet kurzzeitig einen internen Mini-Webserver auf Port 80, schließt die Prüfung ab und beendet sich wieder.

---

### Szenario 4: Wildcard-Zertifikate via DNS-01 Challenge
Um ein Zertifikat für `*.example.com` und alle Subdomains auszustellen, ist der Nachweis über einen DNS-TXT-Eintrag erforderlich:

```bash
sudo certbot certonly --manual --preferred-challenges dns -d "example.com" -d "*.example.com"
```

1. Certbot zeigt einen geforderten TXT-Eintragsnamen (z. B. `_acme-challenge.example.com`) und einen zufälligen Prüfwert an.
2. Trage diesen TXT-Record in deinem DNS-Portal ein (z. B. auf [ternisdomains.de](https://ternisdomains.de)).
3. Warte etwa 30 Sekunden auf die DNS-Verbreitung und bestätige in Certbot mit `Enter`.

---

## 4. Automatische Verlängerung (Auto-Renewal)

Let's Encrypt Zertifikate sind **90 Tage** gültig. Certbot erneuert Zertifikate automatisch, sobald sie **30 Tage oder weniger** Restlaufzeit haben.

### Den Verlängerungsprozess simulieren (Dry Run):
Um ohne Risiko zu testen, ob alle Zertifikate fehlerfrei verlängert werden können:

```bash
sudo certbot renew --dry-run
```
- `--dry-run`: Führt eine vollständige Test-Verlängerung gegen die Staging-Server von Let's Encrypt durch, ohne echte Zertifikate zu ersetzen.

### Automatischer Hintergrunddienst:
Sowohl Snap als auch APT richten automatisch einen systemd-Timer ein, der zweimal täglich im Hintergrund prüft:

```bash
systemctl list-timers | grep certbot
```

### Reload-Hooks nach erfolgreicher Verlängerung:
Webserver müssen nach einer Zertifikatserneuerung neu geladen werden, um die neuen Dateien einzulesen:

```bash
sudo certbot renew --deploy-hook "systemctl reload nginx"
```
Alternativ kann ein Skript in `/etc/letsencrypt/renewal-hooks/deploy/reload-services.sh` abgelegt werden:

```bash
#!/usr/bin/env bash
systemctl reload nginx
```

---

## 5. Befehle zur Zertifikatsverwaltung

### 1. Alle aktiven Zertifikate und Ablaufdaten anzeigen:
```bash
sudo certbot certificates
```

### 2. Ein nicht mehr benötigtes Zertifikat löschen:
```bash
sudo certbot delete --cert-name example.com
```

### 3. Ein kompromittiertes Zertifikat widerrufen:
```bash
sudo certbot revoke --cert-path /etc/letsencrypt/live/example.com/cert.pem
```

---

## 6. Typische Fehler und Problemlösungen

| Fehler | Ursache | Lösung |
|--------|---------|--------|
| **`Connection refused` auf Port 80** | Firewall (UFW) oder Cloud-Sicherheitsgruppe blockiert HTTP | Die Let's Encrypt HTTP-01 Validierung **erfordert zwingend Port 80**. Führe `sudo ufw allow 80/tcp` aus und prüfe Router-/Portfreigaben. |
| **`CAA record forbids issuance`** | DNS CAA-Eintrag schließt Let's Encrypt aus | DNS-Zone auf restriktive CAA-Einträge prüfen oder `CAA 0 issue "letsencrypt.org"` ergänzen. |
| **`Too many certificates already issued`** | Rate-Limit überschritten (max. 50 Zertifikate pro Domain & Woche) | Bei Tests immer den Parameter `--staging` anfügen, um das Testkontingent zu nutzen. |
| **Nginx-Syntaxfehler beim Reload** | Fehlerhafte Nginx-Konfiguration | Konfiguration vor Certbot-Ausführung prüfen: `sudo nginx -t`. |
