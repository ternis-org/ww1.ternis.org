---
title: TLS with Let's Encrypt — ACME Without Tears
description: Complete beginner guide to HTTPS certificates, ACME HTTP-01 vs DNS-01 challenges, Certbot commands, flags, automated renewal, and certificate chains.
category: security
order: 10
tags: [security, tls, ssl, letsencrypt, acme, certbot, https]
updated: 2026-10-06
related: [selfhosting/nginx-reverse-proxy-tls, linux-packages/certbot, linux-packages/caddy]
---

## What is TLS and Let's Encrypt?

**TLS (Transport Layer Security)**, formerly known as SSL, is the cryptographic protocol that encrypts network traffic between web browsers and servers. It guarantees three critical pillars of internet communication:
1. **Confidentiality (Privacy)**: Third parties eavesdropping on the network cannot read user passwords, session tokens, or personal data.
2. **Integrity**: Attackers cannot tamper with or inject malicious scripts into data transmitted between client and server.
3. **Authentication**: Confirms that your visitors are genuinely connected to your real domain and not an imposter site.

**Let's Encrypt** is a non-profit Certificate Authority (CA) that issues free, automated, and trusted TLS certificates. To obtain a certificate, an automated client (such as **Certbot**) communicates with Let's Encrypt using the open **ACME (Automated Certificate Management Environment)** protocol.

---

## How ACME proves domain ownership: The Challenges

Before issuing a certificate for `example.com`, Let's Encrypt must prove that you actually control that domain name. It does this using automated "challenges":

| Challenge | How it works | Requirements | Wildcard Support? |
|-----------|--------------|--------------|-------------------|
| **HTTP-01** | Certbot places a temporary token at `http://example.com/.well-known/acme-challenge/<TOKEN>`. Let's Encrypt fetches it over the public internet. | Publicly accessible port 80 (HTTP) | No |
| **DNS-01** | Certbot creates a temporary DNS `TXT` record named `_acme-challenge.example.com`. Let's Encrypt queries your nameservers. | DNS Provider API credentials | **Yes** (`*.example.com`) |

:::tip
For standard public web servers, **HTTP-01** is the easiest since it requires no DNS API keys. For internal homelab services not exposed to port 80, or if you need a wildcard certificate (`*.yourdomain.com`), choose **DNS-01**.
:::

---

## Installing Certbot

On modern Debian and Ubuntu systems, Certbot is installed via Python package or native apt:

```bash
sudo apt update
sudo apt install -y certbot python3-certbot-nginx
```

### Command & flag breakdown

- `apt update`: Synchronizes package index files from upstream repositories.
- `apt install -y`: Installs the specified packages, automatically answering `yes` (`-y`) to confirmation prompts.
- `certbot`: The core ACME client binary.
- `python3-certbot-nginx`: The official Nginx plugin for Certbot. It allows Certbot to automatically read your Nginx configuration, verify challenges, and configure SSL directives without manual file editing.

---

## Obtaining your first certificate with Certbot

To obtain and automatically configure a certificate for your domain:

```bash
sudo certbot --nginx -d example.com -d www.example.com
```

### Command & flag breakdown

- `certbot`: The command line tool to request, verify, and renew certificates.
- `--nginx`: Specifies the Nginx plugin. Certbot will detect existing `server_name` blocks matching your domains, provision the challenge response, and update your Nginx configuration to point to the newly issued certificate files.
- `-d <domain>`: The domain name(s) you wish to include in the certificate (Subject Alternative Names). You can pass `-d` multiple times to cover both the apex domain (`example.com`) and subdomains (`www.example.com`).

Certbot will ask for:
1. An **email address** for urgent renewal notices and security advisories.
2. Agreement to the Let's Encrypt Terms of Service.
3. Whether to automatically redirect HTTP traffic to HTTPS (always recommend **Yes**).

---

## Where are the certificates stored?

Certificates issued by Certbot are saved under `/etc/letsencrypt/live/<domain>/`.

```bash
sudo ls -l /etc/letsencrypt/live/example.com/
```

Files inside this folder are symlinks pointing to the latest version in `/etc/letsencrypt/archive/`:

- `fullchain.pem`: The complete certificate bundle (your server certificate + the intermediate CA certificate). **Always serve this file in your web server!**
- `privkey.pem`: Your private cryptographic key. Keep this file strictly secret and never share it.
- `cert.pem`: The server leaf certificate alone (without intermediate certificates). Most modern servers do not need this directly.
- `chain.pem`: The intermediate Certificate Authority chain.

:::warn
Serving `cert.pem` instead of `fullchain.pem` causes intermediate chain errors. Desktop browsers may cache intermediate certs and appear to work, but mobile apps, curl, and automated APIs will fail with `SSL certificate problem: unable to get local issuer certificate`.
:::

---

## Testing automated renewals

Let's Encrypt certificates are valid for **90 days**. Certbot automatically renews them when they have 30 days or fewer remaining.

To verify that automatic renewal will succeed when the time comes:

```bash
sudo certbot renew --dry-run
```

### Command & flag breakdown

- `renew`: Tells Certbot to inspect all certificates installed on the system and renew any that are close to expiration.
- `--dry-run`: Runs through the entire ACME handshake and validation against the Let's Encrypt Staging (testing) environment without actually issuing a real certificate or modifying your production files. If this returns success, your automated renewals will work smoothly.

---

## How renewal is triggered automatically

On systemd-based Linux systems, package managers install an automated systemd timer that runs twice daily:

```bash
systemctl status certbot.timer
```

### Command & flag breakdown

- `systemctl status certbot.timer`: Checks whether the background timer is active and displays when it is scheduled to run next.

---

## Quick Reference Summary Table

| Command / Flag | Purpose |
|----------------|---------|
| `certbot --nginx -d example.com` | Requests cert via Nginx plugin and configures web server |
| `certbot certonly --standalone -d example.com` | Obtains cert using standalone temporary web server on port 80 |
| `certbot renew` | Renews all certificates on machine within 30 days of expiry |
| `certbot renew --dry-run` | Simulates renewal process without touching production certificates |
| `certbot certificates` | Lists all active certificates, domains covered, and expiration dates |
| `certbot delete --cert-name example.com` | Revokes and cleanly removes a certificate from the system |
