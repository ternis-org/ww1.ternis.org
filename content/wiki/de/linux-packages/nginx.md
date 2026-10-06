---
title: Nginx — Hochleistungs-Webserver und Reverse-Proxy
description: Nginx unter Linux installieren und einrichten, um statische Webseiten auszuliefern, Anwendungsdienste weiterzuleiten und TLS zu verwalten.
category: linux-packages
order: 45
tags: [nginx, webserver, reverseproxy, linux, sysadmin, ssl]
updated: 2026-10-06
related: [selfhosting/nginx-reverse-proxy-tls, linux-packages/certbot, networking/reverse-proxy-basics]
---

## Was ist Nginx?

Nginx ist ein ereignisgesteuerter, asynchroner HTTP-Webserver, Reverse-Proxy und Load-Balancer. Dank minimalem Speicherverbrauch und hoher Parallelität liefert er Millionen gleichzeitiger Verbindungen stabil aus.

## Installation

```bash
sudo apt update
sudo apt install -y nginx
sudo systemctl enable --now nginx
```

## Reverse-Proxy einrichten

Erstelle eine Konfiguration unter `/etc/nginx/sites-available/app.conf`:

```nginx
server {
    listen 80;
    server_name app.beispiel.de;

    location / {
        proxy_pass http://127.0.0.1:3000;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection 'upgrade';
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

Die Konfiguration aktivieren:

```bash
sudo ln -s /etc/nginx/sites-available/app.conf /etc/nginx/sites-enabled/
```

## Syntax prüfen und neu laden

Teste immer die Syntax, bevor du den Dienst neu lädst:

```bash
sudo nginx -t
```

Wenn der Test erfolgreich ist (`syntax is ok`), lädst du Nginx ohne Verbindungsunterbrechung neu:

```bash
sudo systemctl reload nginx
```
