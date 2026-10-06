---
title: Nginx — Hochleistungs-Webserver und Reverse Proxy
description: Umfassender Einsteiger-Leitfaden zur Installation, Konfiguration und Verwaltung von Nginx auf Linux, mit praxiserprobten Reverse-Proxy-Vorlagen, Caching und Fehlerbehebung.
category: linux-packages
order: 45
tags: [nginx, webserver, reverseproxy, linux, sysadmin, ssl, http2]
updated: 2026-10-06
related: [selfhosting/nginx-reverse-proxy-tls, linux-packages/certbot, networking/reverse-proxy-basics, linux-packages/caddy]
---

## Was ist Nginx und wie funktioniert es?

Im Gegensatz zu klassischen prozessbasierten Webservern (wie Apache mit Prefork-MPM), die für jede eingehende Verbindung einen eigenen Thread oder Prozess starten, arbeitet **Nginx** mit einer **asynchronen, ereignisgesteuerten Architektur (Event-driven Architecture)**.

Ein Master-Prozess und wenige Worker-Prozesse (meist passend zur Anzahl der CPU-Kerne) verwalten zehntausende gleichzeitige Verbindungen effizient über moderne Kernel-Benachrichtigungen (`epoll`). Dadurch liefert Nginx statische Dateien blitzschnell aus, agiert extrem ressourcenschonend und bleibt selbst unter hoher Last stabil.

```text
[ Browser / Besucher ] ──► [ Nginx Master-Prozess ]
                                     │
                     ┌───────────────┴───────────────┐
                     ▼                               ▼
           [ Worker 1 (epoll) ]            [ Worker 2 (epoll) ]
            • SSL/TLS Terminierung          • Statischer Datei-Cache
            • Header-Verarbeitung           • Reverse Proxy zum Backend
                     │                               │
                     └───────────────┬───────────────┘
                                     ▼
                     [ Backend App: 127.0.0.1:3000 ]
```

---

## 1. Installation unter Debian und Ubuntu

Nginx wird über den Standard-Paketmanager installiert:

```bash
sudo apt update
sudo apt install -y nginx
sudo systemctl enable --now nginx
```

### Die Installationsbefehle im Detail:
- `apt update`: Aktualisiert die lokalen Paketlisten.
- `apt install -y nginx`: Installiert das Nginx-Paket.
- `systemctl enable --now nginx`: Aktiviert den automatischen Start beim Systemboot und startet den Dienst sofort.

Prüfe, ob Nginx aktiv läuft:

```bash
sudo systemctl status nginx
```

Falls die Firewall UFW aktiv ist, öffne die Ports für HTTP und HTTPS:

```bash
sudo ufw allow 'Nginx Full'
```

---

## 2. Verzeichnisstruktur und Konfigurationsaufbau

Die Konfigurationsdateien liegen unter `/etc/nginx/`:

```text
/etc/nginx/
├── nginx.conf                 # Globale Hauptkonfiguration
├── conf.d/                    # Modulare Konfigurationsschnipsel
├── sites-available/           # Archiv aller angelegten Virtual Hosts (Server-Blöcke)
└── sites-enabled/             # Symbolische Links (Symlinks) auf aktive Seiten
```

### `sites-available` vs. `sites-enabled`:
- **`sites-available/`**: Hier legst du deine Konfigurationsdateien ab. Sie sind zunächst **inaktiv**.
- **`sites-enabled/`**: Dieses Verzeichnis liest Nginx beim Starten ein. Eine Seite wird aktiviert, indem ein Symlink von `sites-available/` nach `sites-enabled/` gesetzt wird:
  ```bash
  sudo ln -s /etc/nginx/sites-available/myapp.conf /etc/nginx/sites-enabled/
  ```
- Um eine Seite zu deaktivieren, entfernst du einfach den Symlink:
  ```bash
  sudo rm /etc/nginx/sites-enabled/myapp.conf
  ```

---

## 3. Praxis-Vorlage: Reverse Proxy für Webanwendungen

Erstelle eine neue Konfigurationsdatei unter `/etc/nginx/sites-available/app.example.com.conf`:

```bash
sudo nano /etc/nginx/sites-available/app.example.com.conf
```

Füge folgende praxiserprobte Vorlage ein:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name app.example.com;

    # Maximale Upload-Größe (verhindert Fehler bei Datei-Uploads)
    client_max_body_size 64M;

    location / {
        # Anfragen an den internen Anwendungsdienst weiterleiten
        proxy_pass http://127.0.0.1:3000;

        # HTTP/1.1 für persistente Verbindungen (Keep-Alive)
        proxy_http_version 1.1;

        # Unterstützung für WebSockets
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "upgrade";

        # Echte Client-Metadaten an das Backend weitergeben
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;

        # Timeouts gegen blockierte Verbindungen
        proxy_connect_timeout 60s;
        proxy_send_timeout 60s;
        proxy_read_timeout 60s;
    }
}
```

### Erklärung der wichtigsten Direktiven:
- **`listen 80;` und `listen [::]:80;`**: Bindet den Port 80 sowohl für IPv4 als auch für IPv6.
- **`server_name app.example.com;`**: Der Hostname, für den dieser Block zuständig ist.
- **`client_max_body_size 64M;`**: Hebt das Nginx-Standardlimit von 1 MB an, um `413 Request Entity Too Large`-Fehler zu verhindern.
- **`proxy_pass http://127.0.0.1:3000;`**: Das Ziel, an das Anfragen weitergeleitet werden.
- **`proxy_set_header Host $host;`**: Übergibt den ursprünglichen Domainnamen an das Backend, damit Redirects korrekt generiert werden.
- **`proxy_set_header X-Real-IP $remote_addr;`**: Übergibt die echte IP-Adresse des Besuchers statt der lokalen Server-IP.

---

## 4. Statische Dateien mit Browser-Caching ausliefern

Zur schnellen Auslieferung von HTML, CSS, JavaScript und Bildern direkt vom Dateisystem:

```nginx
server {
    listen 80;
    server_name static.example.com;
    root /var/www/my-site;
    index index.html index.htm;

    # Ausliefern oder 404 zurückgeben
    location / {
        try_files $uri $uri/ =404;
    }

    # Browser-Caching für statische Medien (30 Tage)
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|woff2|webp)$ {
        expires 30d;
        add_header Cache-Control "public, no-transform";
    }
}
```

- **`try_files $uri $uri/ =404;`**: Prüft, ob die Datei oder der Ordner existiert; falls nicht, wird ein 404-Statuscode ausgegeben.
- **`expires 30d;`**: Setzt den Header `Cache-Control: max-age=2592000`, sodass Browser die Dateien 30 Tage lokal zwischenspeichern.

---

## 5. Konfiguration testen und ohne Downtime neu laden

:::tip
**Überprüfe die Konfigurations-Syntax immer vor dem Neuladen!**  
Ein vergessener Strichpunkt oder Tippfehler führt dazu, dass Nginx beim Neustart abbricht.
:::

### 1. Syntaxprüfung durchführen:
```bash
sudo nginx -t
```
**Erwartete Erfolgsmeldung:**
```text
nginx: the configuration file /etc/nginx/nginx.conf syntax is ok
nginx: configuration file /etc/nginx/nginx.conf test is successful
```

### 2. Nginx ohne Verbindungsabbrüche neu laden:
```bash
sudo systemctl reload nginx
```
- Liest Konfigurationsänderungen fließend im laufenden Betrieb ein. Bestehende Verbindungen werden sauber zu Ende geführt.

---

## 6. Häufige Fehler und Troubleshooting

| Fehler | Ursache | Lösung |
|--------|---------|--------|
| **`502 Bad Gateway`** | Das Backend läuft nicht oder lauscht auf einem anderen Port | Status der Anwendung prüfen: `curl http://127.0.0.1:3000`. Sicherstellen, dass der Dienst gestartet ist. |
| **`504 Gateway Timeout`** | Backend benötigt zu lange für die Antwort | `proxy_read_timeout 120s;` erhöhen oder Datenbank-Abfragen im Backend optimieren. |
| **`413 Request Entity Too Large`** | Upload-Größe übersteigt `client_max_body_size` | `client_max_body_size 100M;` im `server`- oder `location`-Block ergänzen. |
| **Port 80 bereits belegt** | Ein anderer Dienst (Apache, Caddy) läuft bereits | Den blockierenden Prozess ermitteln: `sudo ss -tulpn \| grep -E ':80\|:443'` und den konkurrierenden Dienst beenden. |
| **`403 Forbidden` bei statischen Dateien** | Falsche Dateiberechtigungen | Leserechte vergeben: `sudo chmod -R 755 /var/www/my-site` und übergeordnete Pfade prüfen. |
