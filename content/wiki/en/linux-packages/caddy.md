---
title: Caddy — Zero-Config Web Server with Automatic HTTPS
description: Deploy Caddy to serve websites and reverse proxy Docker apps with automatic Let's Encrypt TLS out of the box.
category: linux-packages
order: 50
tags: [caddy, webserver, reverseproxy, tls, letsencrypt, docker]
updated: 2026-10-06
related: [networking/reverse-proxy-basics, security/tls-letsencrypt, selfhosting/nginx-reverse-proxy-tls]
---

## Why Caddy?

Caddy is an open-source web server written in Go that manages HTTPS certificates completely automatically. Unlike traditional servers that require cron jobs and external scripts like Certbot, Caddy obtains, renews, and staples OCSP responses for Let's Encrypt and ZeroSSL certificates with zero manual intervention.

## Installation

On Debian and Ubuntu:

```bash
sudo apt install -y debian-keyring debian-archive-keyring apt-transport-https curl
curl -1sLF 'https://dl.cloudsmith.io/public/caddy/stable/gpg.key' | sudo gpg --dearmor -o /usr/share/keyrings/caddy-stable-archive-keyring.gpg
curl -1sLF 'https://dl.cloudsmith.io/public/caddy/stable/debian.deb.txt' | sudo tee /etc/apt/sources.list.d/caddy-stable.list
sudo apt update
sudo apt install -y caddy
```

## The Caddyfile

Caddy's configuration file lives at `/etc/caddy/Caddyfile`.

### Reverse Proxying a Docker or Backend App

```caddyfile
example.com {
    reverse_proxy 127.0.0.1:8080
}
```

Just those three lines will automatically:
1. Open HTTP on port 80 and HTTPS on port 443.
2. Request a Let's Encrypt TLS certificate for `example.com`.
3. Redirect all HTTP requests to HTTPS.
4. Proxy requests to your application on port 8080.

### Serving Static Files

```caddyfile
static.example.com {
    root * /var/www/my-site
    file_server
}
```

## Validating and Reloading

Check configuration syntax without restarting:

```bash
caddy validate --config /etc/caddy/Caddyfile
```

Reload changes with zero downtime:

```bash
sudo systemctl reload caddy
```

:::tip
Caddy supports HTTP/3 (QUIC) by default, providing faster page loads and connection migration for modern mobile devices.
:::
