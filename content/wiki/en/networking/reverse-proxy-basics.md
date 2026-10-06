---
title: Reverse Proxy Basics — One Front Door for All Web Services
description: Complete beginner guide to reverse proxies, forward vs reverse proxies, SNI routing, upstream headers (X-Forwarded-For), TLS termination, and choosing between Caddy and Nginx.
category: networking
order: 20
tags: [networking, reverse-proxy, nginx, caddy, traefik, tls, homelab]
updated: 2026-10-06
related: [selfhosting/nginx-reverse-proxy-tls, linux-packages/caddy, linux-packages/nginx]
---

## What is a Reverse Proxy?

To understand a **reverse proxy**, compare it with a **forward proxy**:

- **Forward Proxy (Client-facing)**: Sits in front of a group of clients (like an office web proxy or VPN). It hides the clients' identities from destination websites.
- **Reverse Proxy (Server-facing)**: Sits in front of a group of backend origin web servers or Docker containers. To external internet users, the reverse proxy appears to be the web server itself.

```text
                               ┌──►  Service A (Nextcloud :8080)
[ Clients ] ──► [ REVERSE PROXY ]
  Port 443                     ├──►  Service B (Gitea :3000)
  HTTPS                        └──►  Service C (API Backend :5000)
```

---

## Why every homelab and web infrastructure needs one

1. **Single IP, Multiple Services**: You usually have only one public IP address. A reverse proxy allows dozens of different domain names (`cloud.example.com`, `git.example.com`, `api.example.com`) to share port 443.
2. **Centralized TLS Termination**: The reverse proxy manages Let's Encrypt certificates, renewals, and SSL encryption. Backend applications can communicate over simple, unencrypted internal HTTP without having to implement TLS themselves.
3. **Security Shield**: Backend servers do not have public internet exposure. You only need to patch and harden the single reverse proxy.
4. **Load Balancing & Caching**: Distributes traffic across multiple instances of an app and caches static assets.

---

## How does it know which service you want? SNI and Host headers

When an encrypted HTTPS connection arrives at port 443, how does the reverse proxy know which website certificate to present and which backend to contact?

1. **SNI (Server Name Indication)**: During the initial TLS handshake (before encryption begins), the client sends the requested domain name in the TLS `ClientHello` packet. This tells the proxy which certificate to present.
2. **The `Host` Header**: Once the TLS tunnel is established and the HTTP request is decrypted, the proxy reads the `Host: app.example.com` HTTP header and routes traffic to the designated backend port.

---

## Comparing the top Reverse Proxies

| Proxy | Configuration Style | Automatic HTTPS | Best For |
|-------|---------------------|:---------------:|----------|
| **Caddy** | Simple Caddyfile (human readable) | **Built-in by default** | Beginners, rapid setups, homelabs |
| **Nginx** | Modular `nginx.conf` server blocks | Requires Certbot plugin | Enterprise production, heavy custom rules |
| **Traefik** | Dynamic labels on Docker containers | Built-in | Heavy dynamic Docker / Kubernetes environments |
| **HAProxy** | High-performance configuration file | Manual cert management | Pure Layer 4 TCP load balancing at scale |

### The Caddy example: 4 lines of configuration

Caddy is the simplest option for beginners because it manages TLS certificates automatically:

```text
app.example.com {
    reverse_proxy 127.0.0.1:3001
}
```

That is the entire configuration! Caddy requests a Let's Encrypt certificate, handles renewals, sets proper proxy headers, and forwards requests.

---

## Crucial proxy headers your backend apps depend on

When a reverse proxy forwards requests to a backend server, the connection appears to originate from `127.0.0.1`. Without forwarding headers, your application will lose the client's identity:

```text
X-Forwarded-For: 203.0.113.195
X-Forwarded-Proto: https
Host: app.example.com
```

### Why these headers matter

- `Host`: Tells the backend app which domain name the user typed into the browser. Without this, multi-tenant apps cannot determine which tenant is being requested.
- `X-Forwarded-For`: Contains the real client IP address. Essential for rate-limiting, fail2ban blocking, and accurate analytics.
- `X-Forwarded-Proto`: Informs the backend whether the user connected with `http` or `https`. **If this is omitted, backend apps often get stuck in an infinite redirect loop** (the backend sees an unencrypted HTTP connection from the proxy and sends a 301 redirect to HTTPS, over and over again).
