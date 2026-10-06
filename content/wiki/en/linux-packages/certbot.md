---
title: Certbot — Automated Let's Encrypt TLS Certificates
description: Install and configure Certbot to automatically issue and renew free Let's Encrypt SSL/TLS certificates for web servers.
category: linux-packages
order: 40
tags: [certbot, letsencrypt, ssl, tls, security, nginx, caddy]
updated: 2026-10-06
related: [security/tls-letsencrypt, selfhosting/nginx-reverse-proxy-tls, dns/a-aaaa-records]
---

## What is Certbot?

Certbot is the official Electronic Frontier Foundation (EFF) client for automating the issuance and renewal of free, trusted SSL/TLS certificates from Let's Encrypt using the ACME protocol.

## Installation

The recommended installation method across all Linux distributions is via `snapd`:

```bash
sudo apt install -y snapd
sudo snap install core
sudo snap refresh core
sudo snap install --classic certbot
sudo ln -s /snap/bin/certbot /usr/bin/certbot
```

Alternatively, install the standard APT package:

```bash
sudo apt install -y certbot python3-certbot-nginx
```

## Obtaining Certificates

### With Nginx Plugin (Automatic config)

Certbot will discover your domain names inside `/etc/nginx/sites-available/` and configure SSL directives automatically:

```bash
sudo certbot --nginx -d example.com -d www.example.com
```

### Standalone Mode (No web server running)

Ideal for mail servers, game servers, or initial setup when port 80 is free:

```bash
sudo certbot certonly --standalone -d example.com
```

### Webroot Mode (Zero server restart)

Validates using HTTP-01 challenges served from an existing document root:

```bash
sudo certbot certonly --webroot -w /var/www/html -d example.com
```

## Testing and Automatic Renewal

Let's Encrypt certificates are valid for 90 days. Certbot installs a systemd timer that checks twice daily for certificates expiring within 30 days.

Test the renewal process with a dry run:

```bash
sudo certbot renew --dry-run
```

View all managed certificates and expiration dates:

```bash
sudo certbot certificates
```

:::tip
Always make sure your domain's A and AAAA DNS records point to your server IP before running Certbot, otherwise the Let's Encrypt HTTP challenge will fail.
:::
