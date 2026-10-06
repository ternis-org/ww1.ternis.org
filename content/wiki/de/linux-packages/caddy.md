---
title: Caddy — Moderner Webserver & Reverse Proxy mit automatischem HTTPS
description: Ausführlicher Einsteiger-Leitfaden zur Installation von Caddy, Syntax des Caddyfile, Reverse-Proxy für Docker und automatischer Let's Encrypt TLS-Verschlüsselung.
category: linux-packages
order: 50
tags: [caddy, webserver, reverseproxy, tls, letsencrypt, docker, http3]
updated: 2026-10-06
related: [networking/reverse-proxy-basics, security/tls-letsencrypt, selfhosting/nginx-reverse-proxy-tls, linux-packages/nginx]
---

## Warum Caddy?

Klassische Webserver wie Apache und Nginx erfordern externe Hilfswerkzeuge (wie Certbot oder acme.sh), Cronjobs und Dutzende Zeilen Konfigurations-Boilerplate, nur um eine gesicherte HTTPS-Verbindung aufzubauen.

**Caddy** ist ein moderner, in Go geschriebener Open-Source-Webserver. Seine herausragende Eigenschaft ist **Automatic HTTPS**: Sobald in der Konfiguration ein Domainname eingetragen wird, fordert Caddy vollkommen selbstständig über ACME TLS-Zertifikate von Let's Encrypt oder ZeroSSL an, installiert sie, bindet OCSP-Stapling ein und erneuert sie vor Ablauf ohne jeden manuellen Eingriff. Zudem sind **HTTP/3 (QUIC)** und zeitgemäße Kompression (`zstd` und `gzip`) von Haus aus standardmäßig aktiviert.

```text
[ Besucher: https://api.example.com ]
                  │
                  ▼
          [ Caddy Webserver ]
    • Automatisches Let's Encrypt TLS
    • HTTP/3 & HTTP/2 Unterstützung
    • Automatische HTTP -> HTTPS Weiterleitung
                  │
                  ▼ (reverse_proxy)
       [ Backend: 127.0.0.1:8080 ]
       (Node.js / Docker / Go / Python)
```

---

## 1. Installation unter Debian und Ubuntu

Caddy wird über das offizielle, stabile Cloudsmith-Paketarchiv installiert:

```bash
# 1. Voraussetzungen für sichere Paketüberprüfung installieren
sudo apt update
sudo apt install -y debian-keyring debian-archive-keyring apt-transport-https curl

# 2. Offiziellen GPG-Signaturschlüssel von Caddy hinzufügen
curl -1sLF 'https://dl.cloudsmith.io/public/caddy/stable/gpg.key' | sudo gpg --dearmor -o /usr/share/keyrings/caddy-stable-archive-keyring.gpg

# 3. APT-Paketquelle eintragen
curl -1sLF 'https://dl.cloudsmith.io/public/caddy/stable/debian.deb.txt' | sudo tee /etc/apt/sources.list.d/caddy-stable.list

# 4. Paketquellen aktualisieren und Caddy installieren
sudo apt update
sudo apt install -y caddy
```

### Die Installationsbefehle im Detail:
- `apt-transport-https`: Erlaubt dem Paketmanager APT den sicheren Download über verschlüsselte HTTPS-Verbindungen.
- `gpg --dearmor`: Konvertiert den ASCII-gepanzerten öffentlichen Schlüssel in das binäre GPG-Format, das von `/usr/share/keyrings/` erwartet wird.
- `sudo systemctl status caddy`: Zeigt den aktuellen Laufzeitstatus des Hintergrunddienstes an.

---

## 2. Die Caddyfile-Syntax

Die zentrale Konfigurationsdatei liegt unter `/etc/caddy/Caddyfile`.

Ein typischer Caddyfile-Eintrag ist extrem übersichtlich:

```caddyfile
example.com {
    # Hier stehen die Anweisungen
}
```

---

## 3. Praxis-Konfigurationen für Produktion

### Beispiel 1: Reverse Proxy für Docker- oder Node.js-Dienste
Wenn deine Backend-Anwendung (z. B. Express, Django, FastAPI oder ein Docker-Container) intern auf Port `8080` lauscht:

```caddyfile
api.example.com {
    reverse_proxy 127.0.0.1:8080
}
```

### Was Caddy mit diesen drei Zeilen automatisch erledigt:
1. Bindet Port `80` (HTTP) und Port `443` (HTTPS).
2. Fordert ein kostenloses Let's Encrypt Zertifikat für `api.example.com` an.
3. Leitet alle unverschlüsselten `http://`-Anfragen automatisch auf `https://` um.
4. Überträgt echte Client-Header (`X-Forwarded-For`, `X-Forwarded-Proto` und `Host`) an das Backend.
5. Leitet WebSockets automatisch weiter, ohne dass manuelle `Upgrade`-Header definiert werden müssen!

---

### Beispiel 2: Statische Webseite mit Kompression & Sicherheits-Headern
Zur Auslieferung von HTML, CSS, JavaScript und Medieninhalten:

```caddyfile
static.example.com {
    root * /var/www/my-site
    file_server

    # Schnelle Kompression aktivieren
    encode zstd gzip

    # Empfohlene Sicherheits-Header
    header {
        X-Frame-Options "SAMEORIGIN"
        X-Content-Type-Options "nosniff"
        Referrer-Policy "strict-origin-when-cross-origin"
        Strict-Transport-Security "max-age=31536000; includeSubDomains; preload"
    }
}
```

- `root * /var/www/my-site`: Definiert das Basisverzeichnis für alle Anfragen (`*`).
- `file_server`: Aktiviert Caddys integrierten Dateiserver.
- `encode zstd gzip`: Komprimiert Datenströme in Echtzeit mit Zstandard (höhere Datenrate) und Gzip-Fallback.

---

### Beispiel 3: Single Page Application (SPA) Routing (React, Vue, Svelte)
Bei clientseitigem Routing müssen Pfade ohne physische Datei auf `index.html` zurückfallen:

```caddyfile
app.example.com {
    root * /var/www/spa/dist
    file_server
    encode zstd gzip

    # Falls angefragte Datei nicht existiert, index.html ausliefern
    try_files {path} /index.html
}
```

---

### Beispiel 4: Lastverteilung (Load Balancing) über mehrere Server
Caddy kann eingehenden Datenverkehr gleichmäßig auf mehrere Backend-Instanzen verteilen:

```caddyfile
service.example.com {
    reverse_proxy 10.0.0.11:8080 10.0.0.12:8080 {
        lb_policy round_robin
        health_uri /healthz
        health_interval 5s
    }
}
```

- `lb_policy round_robin`: Wechselt abwechselnd zwischen den verfügbaren Knoten.
- `health_uri /healthz`: Führt regelmäßige Health-Checks aus und schließt abgestürzte Knoten automatisch aus.

---

## 4. Wichtige CLI-Befehle

### 1. Caddyfile sauber formatieren:
```bash
caddy fmt --overwrite /etc/caddy/Caddyfile
```
- Richtet Einrückungen, Klammern und Direktiven automatisch nach den offiziellen Richtlinien aus.

### 2. Konfiguration vor dem Anwenden prüfen:
```bash
caddy validate --config /etc/caddy/Caddyfile
```
- Prüft die Syntax auf Tippfehler, ohne den laufenden Dienst zu unterbrechen.

### 3. Änderungen ohne Downtime laden:
```bash
sudo systemctl reload caddy
```
- Tauscht die Konfiguration im laufenden Betrieb fließend aus. Bestehende Verbindungen bleiben unberührt.

### 4. Live-Logs einsehen:
```bash
sudo journalctl -u caddy -f
```

---

## 5. Vergleich: Caddy vs. Nginx

| Funktion | Caddy | Nginx |
|----------|:-----:|:-----:|
| **HTTPS-Zertifikate** | Vollautomatisch (Integrierter ACME-Client) | Manuelle Einrichtung nötig (Certbot) |
| **HTTP/3 (QUIC)** | Standardmäßig aktiv | Erfordert manuelle Kompilierung / Mainline |
| **Konfigurationsaufwand** | Minimal (3-5 Zeilen pro Dienst) | Moderat (viele Direktiven & Blöcke) |
| **Programmiersprache** | Go (Speichersicher, keine Buffer Overflows) | C (Extrem schnell, hardwarenah) |
| **WebSockets** | Automatische Weiterleitung | Erfordert manuelle `Upgrade`-Header |
| **Einsatzbereich** | Moderne Cloud-Infrastruktur & Docker | Etablierter Standard in Großunternehmen |
