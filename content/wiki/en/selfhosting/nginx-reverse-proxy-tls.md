---
title: Nginx Reverse Proxy with TLS Configuration
description: Complete beginner guide to setting up an Nginx reverse proxy with TLS encryption, upstream headers, syntax testing, and HSTS security.
category: selfhosting
order: 10
tags: [selfhosting, nginx, reverse-proxy, tls, ssl, certbot, homelab]
updated: 2026-10-06
related: [security/tls-letsencrypt, linux-packages/nginx, homelab/docker-compose-homelab, networking/reverse-proxy-basics]
---

## What is a Reverse Proxy and why use one?

When you run self-hosted applications (like Nextcloud, Gitea, Grafana, or a Node.js/Python/Go web service), they typically bind to a local port such as `127.0.0.1:3001` or run inside Docker containers.

Exposing every application on random port numbers (like `http://example.com:3001`, `http://example.com:8080`) is messy and insecure. A **reverse proxy** acts as a front-facing traffic controller:
1. It listens on standard public ports **80** (HTTP) and **443** (HTTPS).
2. It inspects incoming HTTP request headers (specifically the requested domain name in the `Host` header).
3. It terminates TLS encryption.
4. It forwards the decrypted traffic locally to the appropriate background backend service.

---

## Step 1: Base Nginx reverse proxy configuration

Create a new configuration file in `/etc/nginx/sites-available/service.example.com.conf`:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name service.example.com;

    location / {
        proxy_pass http://127.0.0.1:3001;
        proxy_http_version 1.1;

        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;

        # WebSocket support (optional, needed for live updates)
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "upgrade";
    }
}
```

### Directives & parameters breakdown

- `listen 80`: Instructs Nginx to listen for incoming IPv4 connections on TCP port 80.
- `listen [::]:80`: Instructs Nginx to listen for incoming IPv6 connections on TCP port 80.
- `server_name service.example.com`: Matches incoming HTTP requests whose `Host` header specifies `service.example.com`.
- `location /`: Matches all incoming URL request paths starting with `/`.
- `proxy_pass http://127.0.0.1:3001`: Directs Nginx to forward matching requests to the application running locally on port 3001.
- `proxy_http_version 1.1`: Uses HTTP/1.1 for proxying, required for persistent keep-alive connections and WebSockets.
- `proxy_set_header Host $host`: Passes the original domain name requested by the client to the backend application instead of replacing it with `127.0.0.1`.
- `proxy_set_header X-Real-IP $remote_addr`: Sends the real public IP address of the client to your application (otherwise your application logs would only see `127.0.0.1` for all visitors).
- `proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for`: Appends client and intermediary proxy IPs to maintain the full chain of client IP addresses.
- `proxy_set_header X-Forwarded-Proto $scheme`: Informs the backend application whether the original connection from the user was `http` or `https` (essential for backend URL generation and secure cookies).

---

## Step 2: Enabling the site and verifying syntax

On Debian/Ubuntu systems, link the configuration file to `sites-enabled` and always test syntax before reloading:

```bash
sudo ln -s /etc/nginx/sites-available/service.example.com.conf /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### Command & flag breakdown

- `ln -s <target> <link>`: Creates a symbolic link. Nginx includes files in `sites-enabled/` in its main configuration.
- `nginx -t`: **Test syntax**. Checks every Nginx configuration file for syntax errors, missing semicolons, or invalid directives without affecting running traffic. **Never reload Nginx without running `nginx -t` first!**
- `systemctl reload nginx`: Gracefully reloads configuration files in memory without dropping existing active connections or shutting down the web server.

---

## Step 3: Enabling TLS with Certbot

Once your domain points to your server's IP address and Nginx responds on port 80, secure it with HTTPS:

```bash
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d service.example.com
```

### Command & flag breakdown

- `certbot --nginx`: Automates TLS configuration by reading the `server_name service.example.com` block and inserting the `listen 443 ssl`, certificate paths, and HTTP-to-HTTPS redirect rules automatically.
- `-d service.example.com`: The exact domain to issue the certificate for.

---

## Step 4: Adding HSTS security headers

To instruct web browsers to always connect over HTTPS and never downgrade to unencrypted HTTP, add the **HTTP Strict Transport Security (HSTS)** header inside your SSL server block:

```nginx
add_header Strict-Transport-Security "max-age=63072000; includeSubDomains" always;
```

### Directive breakdown

- `Strict-Transport-Security`: The response header instructing browsers to refuse plaintext HTTP connections.
- `max-age=63072000`: Specifies the duration in seconds that the browser must remember this policy (63072000 seconds = 2 years).
- `includeSubDomains`: Applies the HTTPS-only policy to all subdomains under this domain.
- `always`: Ensures Nginx sends this header on all response status codes (including errors like 404 and 500).

---

## Quick Reference Summary Table

| Command | Purpose |
|---------|---------|
| `nginx -t` | Tests all Nginx configuration files for syntax errors |
| `sudo systemctl reload nginx` | Gracefully reloads Nginx configuration with zero downtime |
| `sudo systemctl restart nginx` | Stops and restarts Nginx service |
| `sudo tail -f /var/log/nginx/error.log` | Streams live server errors in real time |
| `sudo tail -f /var/log/nginx/access.log` | Streams live access log entries |
