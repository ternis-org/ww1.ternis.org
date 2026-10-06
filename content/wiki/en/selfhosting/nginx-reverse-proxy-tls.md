---
title: Nginx Reverse Proxy with TLS
description: Server blocks, Let's Encrypt certificates, and HSTS for self-hosted services.
category: selfhosting
order: 10
tags: [selfhosting, nginx, reverse-proxy, tls]
updated: 2026-10-06
related: [security/tls-letsencrypt, homelab/docker-compose-homelab]
---

## Proxy a local service

```nginx
server {
    listen 80;
    server_name service.example.com;

    location / {
        proxy_pass http://127.0.0.1:3001;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

## Add TLS with certbot

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d service.example.com
```

## Harden slightly

```nginx
add_header Strict-Transport-Security "max-age=63072000" always;
```

:::tip
Prefer DNS-01 challenges for internal-only services: no inbound port 80 needed,
and wildcards (`*.example.com`) work with one certificate.
:::
