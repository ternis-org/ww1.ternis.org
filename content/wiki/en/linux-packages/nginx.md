---
title: Nginx — High-Performance Web Server and Reverse Proxy
description: Complete beginner-friendly guide to installing, configuring, and operating Nginx on Linux, with detailed reverse proxy templates, security headers, and troubleshooting.
category: linux-packages
order: 45
tags: [nginx, webserver, reverseproxy, linux, sysadmin, ssl, http2]
updated: 2026-10-06
related: [selfhosting/nginx-reverse-proxy-tls, linux-packages/certbot, networking/reverse-proxy-basics, linux-packages/caddy]
---

## What is Nginx and how does it work?

Unlike traditional process-based web servers (such as Apache with prefork MPM) that allocate a dedicated thread or process for every active connection, **Nginx** uses an **asynchronous, event-driven architecture**.

A small number of master and worker processes (typically matched to the number of CPU cores) manage thousands of connections concurrently using modern Linux kernel event notifications (`epoll`). This design gives Nginx exceptional throughput, near-instant static file delivery, and negligible memory overhead under heavy load.

```text
[ Browser Clients ] ──► [ Nginx Master Process ]
                                   │
                   ┌───────────────┴───────────────┐
                   ▼                               ▼
         [ Worker 1 (epoll) ]            [ Worker 2 (epoll) ]
          • SSL Termination               • Static File Cache
          • Header Manipulation           • Reverse Proxy to Backend
                   │                               │
                   └───────────────┬───────────────┘
                                   ▼
                   [ Backend App: 127.0.0.1:3000 ]
```

---

## 1. Installation on Debian and Ubuntu

Install Nginx using the system package manager:

```bash
sudo apt update
sudo apt install -y nginx
sudo systemctl enable --now nginx
```

### Breakdown of installation commands:
- `apt update`: Updates package repositories.
- `apt install -y nginx`: Installs the Nginx HTTP server package.
- `systemctl enable --now nginx`: Enables the service to start automatically on system boot and immediately starts the daemon.

Verify that the process is running and actively listening on port 80:

```bash
sudo systemctl status nginx
```

If you have a firewall like UFW active, permit HTTP and HTTPS traffic:

```bash
sudo ufw allow 'Nginx Full'
```

---

## 2. Directory Layout & Configuration Architecture

Nginx configuration files are organized in `/etc/nginx/`:

```text
/etc/nginx/
├── nginx.conf                 # Main global configuration file
├── conf.d/                    # Drop-in configuration snippets
├── sites-available/           # Storage for all configured server blocks
└── sites-enabled/             # Symlinks pointing to active server blocks
```

### Understanding `sites-available` vs `sites-enabled`:
- **`sites-available/`**: A library of all your website configurations. Configurations stored here are **inactive** until linked.
- **`sites-enabled/`**: The folder Nginx actively reads on startup. You activate a website by creating a symbolic link (symlink) from `sites-available/` into `sites-enabled/`:
  ```bash
  sudo ln -s /etc/nginx/sites-available/myapp.conf /etc/nginx/sites-enabled/
  ```
- To disable a website without deleting your configuration, simply remove the symlink:
  ```bash
  sudo rm /etc/nginx/sites-enabled/myapp.conf
  ```

---

## 3. Production Reverse Proxy Configuration

Create a new configuration file at `/etc/nginx/sites-available/app.example.com.conf`:

```bash
sudo nano /etc/nginx/sites-available/app.example.com.conf
```

Paste the following production template:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name app.example.com;

    # Maximum allowed request body size (vital for file uploads)
    client_max_body_size 64M;

    location / {
        # Forward traffic to internal backend server
        proxy_pass http://127.0.0.1:3000;

        # Use HTTP/1.1 for persistent connection keep-alive
        proxy_http_version 1.1;

        # WebSocket support
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "upgrade";

        # Forward authentic client metadata to backend
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;

        # Timeouts preventing hung backend connections
        proxy_connect_timeout 60s;
        proxy_send_timeout 60s;
        proxy_read_timeout 60s;
    }
}
```

### Explanation of Directives:
- **`listen 80;` and `listen [::]:80;`**: Tells Nginx to listen on standard HTTP port 80 for both IPv4 and IPv6 connections.
- **`server_name app.example.com;`**: The HTTP `Host` header Nginx matches to route requests to this specific block.
- **`client_max_body_size 64M;`**: Overrides the default 1MB file upload limit, preventing `413 Request Entity Too Large` errors.
- **`proxy_pass http://127.0.0.1:3000;`**: Specifies the internal target (port, IP, or UNIX domain socket).
- **`proxy_set_header Host $host;`**: Passes the original domain name requested by the browser so backend frameworks (Django, Rails, Node) generate correct redirect URLs.
- **`proxy_set_header X-Real-IP $remote_addr;`**: Sends the client's actual IP address rather than `127.0.0.1`.
- **`proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;`**: Appends the client IP to the chain of proxy IPs.
- **`proxy_set_header X-Forwarded-Proto $scheme;`**: Informs the backend whether the initial user connection was `http` or `https`.

---

## 4. Serving Static Web Assets with Caching

If serving static HTML, CSS, JavaScript, or images directly from disk:

```nginx
server {
    listen 80;
    server_name static.example.com;
    root /var/www/my-site;
    index index.html index.htm;

    # Serve files directly; 404 if not found
    location / {
        try_files $uri $uri/ =404;
    }

    # Aggressive browser caching for static media
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|woff2|webp)$ {
        expires 30d;
        add_header Cache-Control "public, no-transform";
    }
}
```

- **`try_files $uri $uri/ =404;`**: Tests if the requested file exists, then if a folder matches; otherwise returns HTTP 404.
- **`location ~* \.(...)$`**: Regular expression match (`~*` is case-insensitive) for common asset extensions.
- **`expires 30d;`**: Sets `Cache-Control: max-age=2592000`, instructing browsers to cache files locally for 30 days to save bandwidth.

---

## 5. Testing and Zero-Downtime Reloads

:::tip
**Always test configuration syntax before reloading Nginx!**  
If there is a typo or missing semicolon, reloading or restarting will fail.
:::

### 1. Test configuration syntax:
```bash
sudo nginx -t
```
**Expected Successful Output:**
```text
nginx: the configuration file /etc/nginx/nginx.conf syntax is ok
nginx: configuration file /etc/nginx/nginx.conf test is successful
```

### 2. Reload Nginx without dropping connections:
```bash
sudo systemctl reload nginx
```
- Re-reads configuration files and starts new worker processes gracefully. Ongoing client transfers continue uninterrupted on old workers until finished.

---

## 6. Common Issues & Troubleshooting

| Error | Root Cause | Solution |
|-------|------------|----------|
| **`502 Bad Gateway`** | The upstream backend application is stopped or listening on another port | Check backend status: `curl http://127.0.0.1:3000`. Ensure backend server is running. |
| **`504 Gateway Timeout`** | Backend took longer than `proxy_read_timeout` to complete calculation | Increase `proxy_read_timeout 120s;` for slow batch queries or optimize backend code. |
| **`413 Request Entity Too Large`** | Uploaded file exceeds `client_max_body_size` | Add `client_max_body_size 100M;` inside `server` or `location` block. |
| **Port 80 already in use** | Another service (Apache, Caddy, Lighttpd) occupies port 80 | Identify the conflicting process: `sudo ss -tulpn \| grep -E ':80\|:443'`. Stop or disable the competing service. |
| **`403 Forbidden` on static files** | Incorrect file permissions on web directory | Grant read permissions: `sudo chmod -R 755 /var/www/my-site` and ensure parent folders are accessible. |
