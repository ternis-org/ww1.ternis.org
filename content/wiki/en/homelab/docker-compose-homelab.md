---
title: Docker Compose Patterns for the Homelab
description: Compose conventions for volumes, updates, and backups that keep a homelab boring and reliable.
category: homelab
order: 10
tags: [homelab, docker, compose, selfhosting]
updated: 2026-10-06
related: [selfhosting/nginx-reverse-proxy-tls]
---

## One folder per service

```text
homelab/
  uptime-kuma/compose.yaml
  paperless/compose.yaml
```

## The template

```yaml
services:
  app:
    image: louislam/uptime-kuma:2
    restart: unless-stopped
    volumes:
      - ./data:/app/data
    ports:
      - 127.0.0.1:3001:3001
```

Bind to `127.0.0.1` and expose through a reverse proxy — never publish
database ports to the LAN.

## Updates without fear

```bash
docker compose pull && docker compose up -d && docker image prune -f
```

:::warn
`latest` plus auto-updates equals surprise breakage at 3am. Pin versions and
update on your schedule, after a backup.
:::
