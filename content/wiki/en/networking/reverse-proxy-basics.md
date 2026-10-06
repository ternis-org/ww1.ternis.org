---
title: Reverse Proxy Basics — One Door for All Services
description: How Nginx, Caddy and Traefik front homelab services: SNI routing, headers, and TLS termination.
category: networking
order: 20
tags: [networking, reverse-proxy, nginx, caddy, tls]
updated: 2026-10-06
related: [selfhosting/nginx-reverse-proxy-tls, homelab/docker-compose-homelab]
---

## The idea

One public IP + many services = a **reverse proxy** that reads the requested
hostname (SNI for HTTPS) and forwards to the right container:

```text
app.example.com   →  127.0.0.1:3001
files.example.com →  127.0.0.1:8080
```

## Picking the proxy

| Proxy | Strength | Config style |
|-------|----------|--------------|
| Nginx | Ubiquitous, documented everywhere | Server blocks |
| Caddy | Automatic HTTPS with zero config | 5-line Caddyfile |
| Traefik | Docker-label auto-discovery | Labels on containers |

For a first homelab, **Caddy** wins on simplicity:

```text
app.example.com {
    reverse_proxy 127.0.0.1:3001
}
```

TLS certificate included, auto-renewed. Done.

## Headers your apps need

```text
X-Forwarded-For: <client-ip>
X-Forwarded-Proto: https
Host: app.example.com
```

Without `X-Forwarded-Proto`, apps behind the proxy generate `http://` links and
trigger mixed-content warnings. Without the real client IP, fail2ban and rate
limits see only the proxy's address.

:::tip
Terminate TLS at the proxy, keep container traffic on an internal Docker
network, and bind published ports to `127.0.0.1`. Three lines of hygiene that
eliminate entire classes of exposure bugs.
:::
