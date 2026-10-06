---
title: Fail2ban — SSH und Webdienste vor Brute-Force-Angriffen schützen
description: Umfassender Einsteiger-Ratgeber zur Installation, Konfiguration und Verwaltung von Fail2ban auf Linux, mit detaillierter Flag-Erklärung, jail.local und IP-Entsperrung.
category: linux-packages
order: 10
tags: [fail2ban, sicherheit, linux, ssh, ufw, firewalls, sysadmin]
updated: 2026-10-06
related: [linux/ssh-hardening, ubuntu/ufw-basics, linux-packages/nginx, linux-packages/caddy]
---

## Was ist Fail2ban und wie funktioniert es?

Sobald ein Linux-Server mit einem offenen Port an das Internet angebunden ist (z. B. SSH auf Port 22 oder Webserver auf Port 80/443), scannen automatisierte Bots das System und probieren hunderte Passwörter pro Minute durch.

**Fail2ban** ist ein Open-Source-Sicherheitsdienst (`fail2ban-server`), der die Protokolldateien des Servers (wie `/var/log/auth.log` oder das systemd-Journal) kontinuierlich überwacht. Erkennt das System wiederholte fehlgeschlagene Authentifizierungsversuche von derselben IP-Adresse innerhalb eines definierten Zeitfensters, trägt Fail2ban automatisch eine Sperrregel in die Firewall ein (`nftables`, `iptables` oder `ufw`), um alle künftigen Pakete dieses Angreifers zu verwerfen.

```text
[ Angreifer / Bot ] ──(Fehlgeschlagene Logins)──► [ /var/log/auth.log ]
                                                            │
                                                            ▼ (Scan mit Regex-Filtern)
                                                  [ Fail2ban Daemon ]
                                                            │
                                                            ▼ (maxretry überschritten!)
                                                  [ Linux Firewall (UFW/nftables) ]
                                                            │
                                                            ▼
                                                  [ Droppe alle Pakete der Angreifer-IP ]
```

---

## 1. Installation und Dienst-Einrichtung

Unter Debian, Ubuntu oder Raspberry Pi OS installierst du Fail2ban über den Paketmanager APT:

```bash
sudo apt update
sudo apt install -y fail2ban
sudo systemctl enable --now fail2ban
```

### Erklärung der Befehle und Parameter:
- `sudo`: Führt den Befehl mit Administratorrechten (root) aus, die zur Verwaltung von Systempaketen und Firewalls erforderlich sind.
- `apt update`: Aktualisiert die Paketlisten der konfigurierten Paketquellen auf den neuesten Stand.
- `apt install -y fail2ban`: Installiert das Fail2ban-Paket. Der Parameter `-y` beantwortet alle Bestätigungsabfragen automatisch mit "Ja".
- `systemctl enable --now fail2ban`: Vereint zwei Schritte:
  - `enable`: Richtet Fail2ban so ein, dass es bei jedem Serverstart automatisch mitgestartet wird.
  - `--now`: Startet den Dienst sofort im Hintergrund, ohne dass ein Neustart erforderlich ist.

Überprüfe, ob der Dienst aktiv läuft:

```bash
sudo systemctl status fail2ban
```

---

## 2. Konfiguration: Der Unterschied zwischen `jail.conf` und `jail.local`

Die Standardkonfiguration liegt unter `/etc/fail2ban/jail.conf`.

:::warn
**Bearbeite niemals `/etc/fail2ban/jail.conf` direkt!**  
Bei jedem Systemupdate (`apt upgrade`) wird `jail.conf` mit den neuen Standardwerten der Paketbetreuer überschrieben. Eigene Anpassungen gehen dabei unwiderruflich verloren.
:::

Fail2ban verwendet ein mehrschichtiges Konfigurationssystem: Dateien mit der Endung `.local` haben immer Vorrang vor `.conf`. Erstelle daher eine Arbeitskopie:

```bash
sudo cp /etc/fail2ban/jail.conf /etc/fail2ban/jail.local
```

Öffne die neue Konfigurationsdatei mit einem Editor:

```bash
sudo nano /etc/fail2ban/jail.local
```

---

## 3. Zentrale Standardparameter (`[DEFAULT]`)

Suche in `/etc/fail2ban/jail.local` den Abschnitt `[DEFAULT]`. Diese Einstellungen gelten global für alle Schutzbereiche (Jails), sofern sie nicht spezifisch überschrieben werden:

```ini
[DEFAULT]
# Dauer der Sperre (z. B. 1h, 1d, 1w)
bantime = 1h

# Zeitfenster, in dem Fehlversuche gezählt werden
findtime = 10m

# Anzahl erlaubter Fehlversuche vor der Sperrung
maxretry = 5

# Vertrauenswürdige IP-Adressen (Whitelist), die NIEMALS gesperrt werden dürfen
ignoreip = 127.0.0.1/8 ::1 192.168.1.0/24 203.0.113.15

# Protokoll-Backend (systemd ist optimal für moderne Debian/Ubuntu-Systeme)
backend = systemd
```

### Die Parameter im Detail:
- **`bantime = 1h`**: Bestimmt die Sperrdauer. Mögliche Einheiten: Sekunden (`3600`), Minuten (`60m`), Stunden (`1h`) oder Tage (`7d`). Der Wert `-1` bewirkt eine permanente Sperre.
- **`findtime = 10m`**: Das Beobachtungszeitfenster. Treten innerhalb von 10 Minuten 5 Fehlversuche auf, greift die Sperre. Liegen zwischen den Fehlversuchen mehr als 10 Minuten, wird der Zähler zurückgesetzt.
- **`maxretry = 5`**: Die maximale Toleranz an Fehlversuchen, bevor die Firewall-Regel aktiviert wird.
- **`ignoreip`**: Eine durch Leerzeichen getrennte Liste von IPs, Subnetzen (z. B. `192.168.1.0/24`) oder Hostnamen, die von Sperren ausgenommen sind. **Trage hier unbedingt deine eigene feste IP-Adresse oder dein VPN-Netzwerk ein**, um dich nicht selbst auszusperren.
- **`backend = systemd`**: Weist Fail2ban an, direkt das systemd-Journal auszulesen. Das spart Ressourcen gegenüber alten Logdateien und verhindert Probleme bei Log-Rotationen.

---

## 4. SSH-Schutz konfigurieren (`[sshd]`)

Scrolle zum Abschnitt `[sshd]` in `/etc/fail2ban/jail.local` und passe die Einstellungen an:

```ini
[sshd]
enabled  = true
port     = ssh
filter   = sshd
maxretry = 3
bantime  = 24h
```

- **`enabled = true`**: Aktiviert dieses Jail.
- **`port = ssh`**: Standardmäßig Port 22. Wenn du einen alternativen SSH-Port nutzt (z. B. `2222`), passe diesen Wert entsprechend an: `port = 2222`.
- **`maxretry = 3`**: Strengeres Limit für SSH als der globale Standard.
- **`bantime = 24h`**: Sperrt Angreifer auf SSH für volle 24 Stunden.

Speichere die Datei (`Ctrl+O`, dann `Enter` und `Ctrl+X` in nano) und starte Fail2ban neu:

```bash
sudo systemctl restart fail2ban
```

---

## 5. Webserver-Schutz: Jails für Nginx & Apache

Auch Webanwendungen lassen sich gezielt vor Exploit-Scannern und Brute-Force-Attacken schützen.

### Nginx vor Bot-Scans schützen:
Füge diesen Block zu `/etc/fail2ban/jail.local` hinzu:

```ini
[nginx-botsearch]
enabled  = true
port     = http,https
filter   = nginx-botsearch
logpath  = /var/log/nginx/error.log
maxretry = 2
bantime  = 48h
```

- **`port = http,https`**: Wendet die Sperre auf Port 80 und Port 443 an.
- **`filter = nginx-botsearch`**: Erkennt automatische Anfragen nach Schwachstellen (wie `/wp-login.php`, `phpmyadmin` oder `.env`-Dateien), die auf dem Server gar nicht existieren.
- **`maxretry = 2`**: Da legitime Nutzer solche Pfade nicht aufrufen, greift die Sperre bereits nach dem zweiten Versuch für 48 Stunden.

---

## 6. Verwaltung im Alltag: Die wichtigsten CLI-Befehle

Zur Verwaltung dient das Kommandozeilen-Werkzeug `fail2ban-client`.

### 1. Gesamtstatus und aktive Jails prüfen
```bash
sudo fail2ban-client status
```

---

### 2. Spezifisches Jail analysieren und gesperrte IPs auflisten
```bash
sudo fail2ban-client status sshd
```
**Beispiel-Ausgabe:**
```text
Status for the jail: sshd
|- Filter
|  |- Currently failed: 1
|  |- Total failed:     42
|  `- File list:        systemd
`- Actions
   |- Currently banned: 2
   |- Total banned:     15
   `- Banned IP list:   198.51.100.24 203.0.113.88
```

---

### 3. Eine IP-Adresse manuell entsperren
Wurde eine eigene IP oder die eines Kollegen versehentlich blockiert, lässt sich diese sofort freigeben:

```bash
sudo fail2ban-client set sshd unbanip 203.0.113.88
```
- `set sshd`: Gibt an, in welchem Jail die Aktion ausgeführt werden soll.
- `unbanip <IP>`: Entfernt die Firewall-Sperre für die angegebene Adresse.

---

### 4. Eine verdächtige IP manuell sperren
```bash
sudo fail2ban-client set sshd banip 198.51.100.99
```

---

### 5. Regex-Filter an Logdateien testen
Um neue Filterregeln vor der Aktivierung zu überprüfen, nutze `fail2ban-regex`:

```bash
sudo fail2ban-regex /var/log/auth.log /etc/fail2ban/filter.d/sshd.conf
```

---

## 7. Häufige Fehler und Troubleshooting

| Problem | Ursache | Lösung |
|---------|---------|--------|
| **Vom eigenen Server ausgesperrt** | Kennwort zu oft falsch eingegeben, keine Whitelist | Über die Provider-Webkonsole (VNC/KVM) anmelden, `sudo fail2ban-client set sshd unbanip <Eigene_IP>` ausführen und die IP in `ignoreip` eintragen. |
| **Keine IPs werden gebannt** | Falscher Log-Pfad oder Backend | In `[DEFAULT]` `backend = systemd` setzen oder den Pfad mit `ls -l /var/log/auth.log` kontrollieren. |
| **Fail2ban startet nicht** | Syntaxfehler in `jail.local` | Konfiguration mit `sudo fail2ban-client -d` auf Fehler prüfen oder `sudo journalctl -u fail2ban -e` einsehen. |
| **Hinter Cloudflare Proxy** | Web-Jail sieht nur Cloudflare-IPs | In Nginx das Modul `set_real_ip_from` mit den Cloudflare-Netzen konfigurieren, damit die echte Client-IP geloggt wird. |
