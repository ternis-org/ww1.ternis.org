---
title: Docker Compose Patterns for the Homelab — Beginner to Pro
description: Complete beginner guide to organizing self-hosted services with Docker Compose, yaml syntax breakdown, persistent volumes, networking, and safe updates.
category: homelab
order: 10
tags: [homelab, docker, compose, selfhosting, devops, containers]
updated: 2026-10-06
related: [selfhosting/nginx-reverse-proxy-tls, networking/reverse-proxy-basics, linux-packages/caddy]
---

## What is Docker Compose?

**Docker** packages applications and their exact dependencies into isolated containers that run reliably on any Linux machine.

While raw `docker run` commands work, managing multiple applications with dozens of CLI flags becomes unwieldy. **Docker Compose** allows you to define your entire multi-container architecture declaratively in a clean, version-controlled YAML file (`compose.yaml`).

---

## The Homelab Directory Structure

Never put all your unrelated containers into one massive monolithic file. Organize by service:

```text
/opt/homelab/
├── caddy/
│   ├── compose.yaml
│   └── Caddyfile
├── uptime-kuma/
│   ├── compose.yaml
│   ├── .env
│   └── data/
└── nextcloud/
    ├── compose.yaml
    └── html/
```

This modular layout ensures that updating or debugging one application never disrupts your other running services.

---

## Anatomy of a Production-Ready `compose.yaml`

Here is an annotated, best-practice compose configuration for **Uptime Kuma** (service monitoring):

```yaml
services:
  uptime-kuma:
    image: louislam/uptime-kuma:2
    container_name: uptime-kuma
    restart: unless-stopped
    volumes:
      - ./data:/app/data
    ports:
      - "127.0.0.1:3001:3001"
    environment:
      - NODE_ENV=production
```

### Directive breakdown

- `services:`: Top-level block defining the container workloads to manage.
- `uptime-kuma:`: The internal service identifier name.
- `image: louislam/uptime-kuma:2`: The container image from Docker Hub.
  - **Pinning Major Versions**: Notice we use `:2` instead of `:latest`. Using `:latest` means automated updates can pull major breaking releases unexpectedly at 3 AM.
- `container_name:`: Assigns a fixed, friendly name visible in `docker ps`.
- `restart: unless-stopped`: Automatically restarts the container if it crashes or if the server reboots. Unlike `always`, it respects manual `docker compose stop` commands.
- `volumes:` (`./data:/app/data`): **Data persistence**.
  - Without a volume, all data inside a container is ephemeral and destroyed when the container is recreated!
  - Syntax is `<host_path>:<container_path>`. Here, the host folder `./data` is mapped into `/app/data` inside the container.
- `ports:` (`"127.0.0.1:3001:3001"`): **Crucial Security Pattern!**
  - Syntax is `<host_ip>:<host_port>:<container_port>`.
  - By prepending `127.0.0.1:`, this port is accessible **only** to the local machine (for your reverse proxy like Caddy or Nginx). If you write `3001:3001` without `127.0.0.1:`, Docker bypasses your UFW firewall and exposes the port directly to the local LAN and public internet!

---

## Essential CLI Commands & Flags Breakdown

```bash
# 1. Start containers in the background (detached mode)
docker compose up -d

# 2. View running containers and health status
docker compose ps

# 3. Stream live container logs in real time
docker compose logs -f

# 4. Stop and remove containers (preserving volume data on disk)
docker compose down

# 5. Execute an interactive shell inside a running container
docker compose exec uptime-kuma /bin/sh
```

### Command & flag breakdown

- `up`: Builds, creates, and starts all containers declared in `compose.yaml`.
- `-d` (detached mode): Runs containers in the background and releases your terminal prompt.
- `ps`: Lists container status, uptime, and mapped ports.
- `logs`: Prints console output from all containers.
- `-f` (follow): Continuously streams incoming log messages (exit with `Ctrl+C`).
- `down`: Gracefully stops container processes and removes virtual network bridges. Data stored in mounted volumes remains safe on your host disk.

---

## Safe Step-by-Step Update Routine

To update a service without surprise breakage:

```bash
# 1. Pull the latest updated image for the pinned tag
docker compose pull

# 2. Recreate containers with zero downtime
docker compose up -d

# 3. Remove old, unused cached container images to reclaim disk space
docker image prune -f
```

### Flag breakdown

- `pull`: Downloads updated image layers from the registry without touching the currently running container.
- `prune`: Deletes orphaned, dangling image layers.
- `-f` (force): Skips the interactive `Are you sure? (y/n)` confirmation prompt.
