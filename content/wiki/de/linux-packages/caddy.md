---
title: Caddy — Webserver mit automatischem HTTPS ohne Konfiguration
description: Caddy als modernen Webserver und Reverse-Proxy für Docker-Container mit vollautomatischen Let's Encrypt TLS-Zertifikaten einsetzen.
category: linux-packages
order: 50
tags: [caddy, webserver, reverseproxy, tls, letsencrypt, docker]
updated: 2026-10-06
related: [networking/reverse-proxy-basics, security/tls-letsencrypt, selfhosting/nginx-reverse-proxy-tls]
---

## Warum Caddy?

Caddy ist ein moderner Webserver in Go, der HTTPS vollautomatisch verwaltet. Anders als bei traditionellen Servern, die externe Skripte wie Certbot erfordern, bezieht und erneuert Caddy TLS-Zertifikate von Let's Encrypt und ZeroSSL selbstständig ohne zusätzlichen Wartungsaufwand.

## Installation

Unter Debian und Ubuntu:

```bash
sudo apt install -y debian-keyring debian-archive-keyring apt-transport-https curl
curl -1sLF 'https://dl.cloudsmith.io/public/caddy/stable/gpg.key' | sudo gpg --dearmor -o /usr/share/keyrings/caddy-stable-archive-keyring.gpg
curl -1sLF 'https://dl.cloudsmith.io/public/caddy/stable/debian.deb.txt' | sudo tee /etc/apt/sources.list.d/caddy-stable.list
sudo apt update
sudo apt install -y caddy
```

## Das Caddyfile

Die Konfiguration liegt unter `/etc/caddy/Caddyfile`.

### Reverse-Proxy für Docker oder Backend-Apps

```caddyfile
beispiel.de {
    reverse_proxy 127.0.0.1:8080
}
```

Diese drei Zeilen genügen für:
1. Port 80 und 443 öffnen.
2. Automatisches TLS-Zertifikat für `beispiel.de` anfordern.
3. Dauerhafte HTTP-nach-HTTPS-Weiterleitung.
4. Weiterleitung an den Dienst auf Port 8080.

### Statische Dateien ausliefern

```caddyfile
static.beispiel.de {
    root * /var/www/meine-website
    file_server
}
```

## Konfiguration prüfen und neu laden

Syntax prüfen:

```bash
caddy validate --config /etc/caddy/Caddyfile
```

Ohne Downtime neu laden:

```bash
sudo systemctl reload caddy
```
