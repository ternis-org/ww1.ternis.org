---
title: Caddy — Modern Web Server and Reverse Proxy with Automatic HTTPS
description: Comprehensive beginner-friendly guide to installing Caddy, mastering the Caddyfile, setting up reverse proxies, Docker integrations, and automatic Let's Encrypt TLS.
category: linux-packages
order: 50
tags: [caddy, webserver, reverseproxy, tls, letsencrypt, docker, http3]
updated: 2026-10-06
related: [networking/reverse-proxy-basics, security/tls-letsencrypt, selfhosting/nginx-reverse-proxy-tls, linux-packages/nginx]
---

## Why Caddy?

Traditional web servers like Apache and Nginx require external helper tools (such as Certbot or acme.sh), cron jobs, and dozens of lines of SSL boilerplate configuration just to get a secure HTTPS connection working.

**Caddy** is a next-generation open-source web server written in Go. Its defining feature is **Automatic HTTPS**: whenever you specify a domain name in its configuration, Caddy autonomously coordinates with Let's Encrypt or ZeroSSL using ACME to obtain, install, OCSP-staple, and renew TLS certificates before they expire. It also enables **HTTP/3 (QUIC)** and modern compression (`zstd` and `gzip`) out of the box with zero extra plugins.

```text
[ Incoming User: https://api.example.com ]
                     │
                     ▼
             [ Caddy Web Server ]
       • Automatic Let's Encrypt TLS
       • HTTP/3 & HTTP/2
       • Automatic HTTP -> HTTPS redirect
                     │
                     ▼ (reverse_proxy)
          [ Backend: 127.0.0.1:8080 ]
          (Node.js / Go / Docker / Python)
```

---

## 1. Installation on Debian and Ubuntu

Install Caddy from the official stable Cloudsmith repository:

```bash
# 1. Install prerequisites for secure repository verification
sudo apt update
sudo apt install -y debian-keyring debian-archive-keyring apt-transport-https curl

# 2. Add Caddy's official GPG signing key
curl -1sLF 'https://dl.cloudsmith.io/public/caddy/stable/gpg.key' | sudo gpg --dearmor -o /usr/share/keyrings/caddy-stable-archive-keyring.gpg

# 3. Add Caddy APT source list
curl -1sLF 'https://dl.cloudsmith.io/public/caddy/stable/debian.deb.txt' | sudo tee /etc/apt/sources.list.d/caddy-stable.list

# 4. Refresh package list and install Caddy
sudo apt update
sudo apt install -y caddy
```

### Breakdown of installation commands:
- `apt-transport-https`: Enables APT to securely fetch packages over encrypted HTTPS connections.
- `gpg --dearmor`: Converts Cloudsmith's ASCII-armored public key into the binary format expected by Debian/Ubuntu keyring directories (`/usr/share/keyrings/`).
- `sudo systemctl status caddy`: Verifies that Caddy's systemd daemon is active and running.

---

## 2. The Caddyfile Syntax

Caddy's main configuration file is `/etc/caddy/Caddyfile`.

A basic Caddyfile entry follows this structure:

```caddyfile
example.com {
    # Directives go here
}
```

---

## 3. Production Configuration Examples

### Example 1: Reverse Proxying Docker or Node.js Applications
If you have a backend application (like Express, Django, FastAPI, or a Docker container) running on port `3000` or `8080`:

```caddyfile
api.example.com {
    reverse_proxy 127.0.0.1:8080
}
```

### What Caddy does automatically with these 3 lines:
1. Binds to port `80` (HTTP) and port `443` (HTTPS).
2. Obtains a free Let's Encrypt certificate for `api.example.com`.
3. Automatically redirects all plain `http://` traffic to `https://`.
4. Passes real client IP headers (`X-Forwarded-For`, `X-Forwarded-Proto`, and `Host`) to your backend.
5. Handles WebSocket upgrades automatically without needing manual `Upgrade` header declarations!

---

### Example 2: Static Website with Compression & Security Headers
To serve static HTML, CSS, JavaScript, and image assets:

```caddyfile
static.example.com {
    root * /var/www/my-site
    file_server

    # Enable fast modern compression
    encode zstd gzip

    # Custom security headers
    header {
        X-Frame-Options "SAMEORIGIN"
        X-Content-Type-Options "nosniff"
        Referrer-Policy "strict-origin-when-cross-origin"
        Strict-Transport-Security "max-age=31536000; includeSubDomains; preload"
    }
}
```

- `root * /var/www/my-site`: Sets the document root directory for all requests (`*`).
- `file_server`: Enables Caddy's high-performance static file handler.
- `encode zstd gzip`: Compresses responses on-the-fly using Zstandard (superior compression ratio) with Gzip fallback for legacy clients.

---

### Example 3: Single Page Application (SPA) Routing (React, Vue, Svelte)
SPAs require all non-file requests to fall back to `/index.html` so client-side routing works:

```caddyfile
app.example.com {
    root * /var/www/spa/dist
    file_server
    encode zstd gzip

    # If the requested file or folder does not exist, serve index.html
    try_files {path} /index.html
}
```

---

### Example 4: Load Balancing across Multiple Replicas
Caddy can distribute incoming requests across multiple internal application instances:

```caddyfile
service.example.com {
    reverse_proxy 10.0.0.11:8080 10.0.0.12:8080 {
        lb_policy round_robin
        health_uri /healthz
        health_interval 5s
    }
}
```

- `lb_policy round_robin`: Alternates between available backend nodes.
- `health_uri /healthz`: Actively probes backend health and removes crashing nodes automatically.

---

## 4. Useful CLI Commands & Flags

Caddy includes powerful formatting and validation utilities:

### 1. Format the Caddyfile cleanly:
```bash
caddy fmt --overwrite /etc/caddy/Caddyfile
```
- Automatically aligns brackets, indents directives, and sorts blocks according to official style guidelines.

### 2. Validate configuration before applying:
```bash
caddy validate --config /etc/caddy/Caddyfile
```
- Checks for syntax errors or invalid directives without affecting the running service.

### 3. Reload changes with ZERO downtime:
```bash
sudo systemctl reload caddy
```
- Performs a graceful in-memory configuration swap. Active visitor connections are never dropped.

### 4. View live access and error logs:
```bash
sudo journalctl -u caddy -f
```
- `-u caddy`: Filters log entries for the Caddy systemd unit.
- `-f`: Follows the stream in real-time.

---

## 5. Caddy vs Nginx: Quick Comparison

| Feature | Caddy | Nginx |
|---------|:-----:|:-----:|
| **HTTPS Certificates** | Fully automatic (Built-in ACME) | Manual setup required (Certbot) |
| **HTTP/3 (QUIC)** | Enabled by default | Requires special compilation or mainline |
| **Configuration Complexity** | Very low (3-5 lines per site) | Moderate (verbose block syntax) |
| **Language & Memory Safety** | Go (Memory-safe, no buffer overflows) | C (High-speed, raw low-level memory) |
| **WebSockets** | Automatic proxying | Requires explicit `Upgrade` headers |
| **Enterprise Ecosystem** | Fast-growing, beloved in DevOps | 20+ years of legacy enterprise adoption |
