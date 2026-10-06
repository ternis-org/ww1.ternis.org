---
title: curl — HTTP-Client und API-Debugging im Terminal
description: Wichtige curl-Befehle für REST-APIs, HTTP-Header-Prüfung, TLS-Zertifikats-Debugging und präzise Latenz-Messungen.
category: linux-packages
order: 60
tags: [curl, http, api, debugging, networking, cli]
updated: 2026-10-06
related: [dns/debugging-dig-host-nslookup, javascript/fetch-basics, security/tls-letsencrypt]
---

## Was ist curl?

`curl` ist das Standardwerkzeug auf der Linux-Kommandozeile zur Datenübertragung über HTTP, HTTPS, FTP und viele weitere Protokolle. Es ist das wichtigste Hilfsmittel zum Prüfen von Webservern, REST-Schnittstellen und DNS-Routings.

## Wichtige Befehle für den Alltag

### Nur HTTP-Header abfragen (`-I`)

Ruft den Statuscode und Header ab, ohne den HTML- oder Datei-Inhalt herunterzuladen:

```bash
curl -I https://ternis.org
```

### Weiterleitungen folgen (`-L`)

Folgt 301/302-Redirects bis zum finalen Ziel:

```bash
curl -IL https://ternis.org/wiki
```

### JSON per POST senden

```bash
curl -X POST https://api.beispiel.de/v1/items \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer MEIN_TOKEN" \
  -d '{"name": "production-node", "active": true}'
```

### Verbose-Modus für SSL/TLS-Debugging (`-v`)

Macht den vollständigen TLS-Handshake und alle Anfrage-Header sichtbar:

```bash
curl -vI https://ternis.org
```

### DNS umgehen mit `--resolve`

Einen neuen Server testen, bevor die öffentlichen DNS-Records umgestellt sind:

```bash
curl -I --resolve beispiel.de:443:203.0.113.10 https://beispiel.de
```

### HTTP-Antwortzeiten präzise messen

Gibt DNS-Dauer, TCP-Verbindung, TLS-Handshake und Time-to-First-Byte (TTFB) in Sekunden aus:

```bash
curl -w "DNS: %{time_namelookup}s | Connect: %{time_connect}s | TLS: %{time_appconnect}s | TTFB: %{time_starttransfer}s | Total: %{time_total}s\n" \
  -o /dev/null -s https://ternis.org
```
