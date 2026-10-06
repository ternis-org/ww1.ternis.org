---
title: Nginx — High-Performance Web Server & Reverse Proxy
description: Install, configure, and operate Nginx on Linux for serving static sites, proxying application servers, and managing SSL/TLS certificates.
category: linux-packages
order: 45
tags: [nginx, webserver, reverseproxy, linux, sysadmin, ssl]
updated: 2026-10-06
related: [selfhosting/nginx-reverse-proxy-tls, linux-packages/certbot, networking/reverse-proxy-basics]
---

## What is Nginx?

Nginx is an event-driven, asynchronous HTTP web server, reverse proxy, and load balancer. Because of its low memory footprint and high concurrency capabilities, it powers over a third of all websites globally.

## Installation

```bash
sudo apt update
sudo apt install -y nginx
sudo systemctl enable --now nginx
```

Verify that Nginx is running and listening on port 80:

```bash
systemctl status nginx
```

## Basic Reverse Proxy Configuration

Create a virtual host configuration in `/etc/nginx/sites-available/app.conf`:

```nginx
server {
    listen 80;
    server_name app.example.com;

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

Enable the site by symlinking it into `sites-enabled`:

```bash
sudo ln -s /etc/nginx/sites-available/app.conf /etc/nginx/sites-enabled/
```

## Testing and Reloading

Always test your configuration syntax before restarting or reloading Nginx:

```bash
sudo nginx -t
```

If the syntax test passes (`syntax is ok`), reload the daemon without dropping active TCP connections:

```bash
sudo systemctl reload nginx
```

:::tip
Combine Nginx with Certbot (`sudo certbot --nginx -d app.example.com`) to automatically generate TLS certificates and redirect all HTTP traffic to HTTPS.
:::
