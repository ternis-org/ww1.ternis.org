---
title: curl — Der Standard-HTTP-Client für Terminal & APIs
description: Praxisnaher Einsteiger-Leitfaden zu curl, Abfrage von HTTP-Headern, REST-APIs testen, SSL/TLS-Handshakes analysieren und Performance-Messungen mit Flag-Erklärungen.
category: linux-packages
order: 60
tags: [curl, http, api, debugging, netzwerk, cli, sysadmin]
updated: 2026-10-06
related: [dns/debugging-dig-host-nslookup, javascript/fetch-basics, security/tls-letsencrypt]
---

## Was ist curl?

**`curl` (Client URL)** ist das weltweite Standard-Kommandozeilenprogramm zur Datenübertragung über Netzwerkprotokolle (HTTP, HTTPS, FTP, SFTP u.v.m.).

Es ist auf nahezu jedem Linux-, macOS- und Windows-System vorinstalliert und ein unersetzliches Werkzeug für Entwickler und Administratoren, um Webserver zu prüfen, APIs zu testen und Netzwerkprobleme zu isolieren.

---

## 1. Nur HTTP-Header abrufen (`-I` / `--head`)

Um schnell den HTTP-Statuscode oder Caching-Header eines Servers zu prüfen, ohne den gesamten HTML-Inhalt herunterzuladen:

```bash
curl -I https://ternis.org
```

### Flag-Erklärung

- `-I` (oder `--head`): Sendet eine `HTTP HEAD`-Anfrage statt `GET`. Der Webserver liefert nur die Header-Zeilen (z. B. `HTTP/2 200`, `Content-Type`, `Cache-Control`) und beendet die Verbindung sofort.

---

## 2. Weiterleitungen automatisch folgen (`-L` / `--location`)

Websites leiten Anfragen häufig weiter (z. B. von HTTP zu HTTPS):

```bash
curl -IL https://ternis.org/wiki
```

### Flag-Erklärung

- `-L` (oder `--location`): Folgt automatisch HTTP-Weiterleitungen (`301 Moved Permanently` oder `302 Found`). Die Kombination `-IL` zeigt die vollständige Kette aller Weiterleitungen bis zur finalen Zielseite an.

---

## 3. JSON-POST-Anfragen an APIs senden

```bash
curl -X POST https://api.example.com/v1/items \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer DEIN_TOKEN" \
  -d '{"name": "server-node", "active": true}'
```

### Flag-Erklärung

- `-X POST`: Bestimmt die HTTP-Methode.
- `-H "<header>"`: Fügt einen benutzerdefinierten HTTP-Header hinzu (z. B. Authentifizierung und Content-Type).
- `-d '<daten>'`: Sendet den Text als HTTP-Request-Body.

---

## 4. Verbose-Modus: SSL/TLS-Handshakes analysieren (`-v`)

```bash
curl -vI https://ternis.org
```

### Flag-Erklärung

- `-v` (oder `--verbose`): Gibt detaillierte Verbindungsinformationen aus:
  - DNS-Auflösung und verbundene IP.
  - TLS-Zertifikatskette, Verschlüsselungsverfahren (Cipher Suites).
  - Gesendete Anfrageheader (`>`) und empfangene Antwortheader (`<`).

---

## 5. Server vor DNS-Umstellung testen (`--resolve`)

Wenn eine Website auf einen neuen Server umzieht, kannst du die Konfiguration und TLS-Zertifikate vor der öffentlichen DNS-Änderung prüfen:

```bash
curl -I --resolve example.com:443:203.0.113.10 https://example.com
```

### Flag-Erklärung

- `--resolve <host:port:ip>`: Zwingt curl, sich direkt mit der angegebenen IP zu verbinden, während weiterhin der korrekte Hostname und SNI übermittelt werden.

---

## 6. Ladezeiten und Latenzen messen (`-w`)

```bash
curl -w "DNS: %{time_namelookup}s | Connect: %{time_connect}s | TLS: %{time_appconnect}s | TTFB: %{time_starttransfer}s | Gesamt: %{time_total}s\n" \
  -o /dev/null -s https://ternis.org
```

- `-o /dev/null`: Verwirft den heruntergeladenen HTML-Inhalt.
- `-s` (silent): Blendet Fortschrittsbalken aus.
- `-w`: Gibt die formatierten Zeitmessungen aus.
