---
title: Certbot — Automated Let's Encrypt TLS Certificates
description: Complete beginner guide to installing Certbot, issuing free SSL/TLS certificates, understanding HTTP-01 and DNS-01 challenges, and configuring auto-renewal with hooks.
category: linux-packages
order: 40
tags: [certbot, letsencrypt, ssl, tls, security, nginx, caddy, apache]
updated: 2026-10-06
related: [security/tls-letsencrypt, selfhosting/nginx-reverse-proxy-tls, dns/a-aaaa-records, domains/choosing-tld]
---

## What is Certbot and ACME?

In modern web development, serving traffic over unencrypted plain HTTP is considered obsolete and insecure. Web browsers mark HTTP sites as "Not Secure", modern APIs reject HTTP, and search engines penalize unencrypted websites.

**Certbot** is an open-source command-line tool developed by the Electronic Frontier Foundation (EFF). It communicates with the free certificate authority **Let's Encrypt** using the **ACME protocol** (Automated Certificate Management Environment) to automatically verify domain ownership, issue cryptographically signed X.509 SSL/TLS certificates, and renew them before they expire.

```text
[ Your Server (Certbot) ] ──(1. Request cert for example.com)──► [ Let's Encrypt CA ]
             │                                                          │
             │◄───(2. ACME Challenge: Serve token on port 80)───────────┤
             │                                                          │
             ├────(3. Serves token at /.well-known/acme-challenge/...)─►│
             │                                                          │
             │◄───(4. Validated! Issues signed 90-day TLS Certificate)──┘
```

---

## 1. Installation: Snap vs APT

The Electronic Frontier Foundation officially recommends installing Certbot via **Snap** because snap packages are kept up to date with the latest ACME protocol specifications and cryptography standards.

### Option A: Recommended Installation via Snap
```bash
sudo apt update
sudo apt install -y snapd
sudo snap install core
sudo snap refresh core
sudo snap install --classic certbot
sudo ln -s /snap/bin/certbot /usr/bin/certbot
```

#### Flag breakdown:
- `snap install core`: Installs the core snap runtime environment.
- `snap refresh core`: Ensures the runtime is on the newest version.
- `snap install --classic certbot`: Installs Certbot. The `--classic` flag grants Certbot the necessary system permissions to read and write certificates in `/etc/letsencrypt/`.
- `ln -s /snap/bin/certbot /usr/bin/certbot`: Creates a symbolic link so you can run `certbot` from any terminal session.

---

### Option B: Alternative Installation via Standard APT
If you prefer not to use snapd:
```bash
sudo apt update
sudo apt install -y certbot python3-certbot-nginx
```

---

## 2. Choosing Your Validation Method

Certbot supports several validation plugins depending on your server architecture:

| Method | When to use | Port required | Server reload |
|--------|-------------|:-------------:|:-------------:|
| **`--nginx`** | Running Nginx web server | 80 & 443 | Automatic |
| **`--apache`** | Running Apache (`httpd`) | 80 & 443 | Automatic |
| **`--standalone`** | Standalone services (Node.js, Docker, Mail) | 80 | Temporarily binds port |
| **`--webroot`** | Existing web server with active document root | 80 | Zero downtime |
| **`--manual --preferred-challenges dns`** | Wildcard certificates (`*.example.com`) | DNS TXT Record | None |

---

## 3. Practical Certificate Issuance Examples

### Scenario 1: Automatic Nginx Configuration (Most Common)
Certbot reads your Nginx configuration, validates domain ownership, modifies `/etc/nginx/sites-available/` to enable HTTPS, and reloads Nginx automatically:

```bash
sudo certbot --nginx -d example.com -d www.example.com --agree-tos -m admin@example.com --no-eff-email
```

#### Breakdown of flags:
- `--nginx`: Uses the Nginx authenticator and installer plugin.
- `-d example.com`: Specifies the domain name. You can repeat `-d` multiple times to include multiple hostnames on a single certificate (SAN).
- `--agree-tos`: Automatically accepts the Let's Encrypt Terms of Service.
- `-m admin@example.com`: The administrative email address used by Let's Encrypt for critical expiration and security notices.
- `--no-eff-email`: Declines signing up for EFF newsletter emails during setup.

---

### Scenario 2: Webroot Mode (Zero Downtime)
If you already have a running website and do not want Certbot to modify your web server configuration files:

```bash
sudo certbot certonly --webroot -w /var/www/html -d example.com -d www.example.com
```

#### Breakdown of flags:
- `certonly`: Tells Certbot to only obtain the certificate and save it to disk, without modifying any web server configuration files.
- `--webroot`: Tells Certbot to place challenge tokens into your existing document root.
- `-w /var/www/html`: Path to the directory where your web server serves files for this domain. Certbot creates `/.well-known/acme-challenge/` inside it.

Your certificate files are saved to:
- **Certificate**: `/etc/letsencrypt/live/example.com/fullchain.pem`
- **Private Key**: `/etc/letsencrypt/live/example.com/privkey.pem`

---

### Scenario 3: Standalone Mode (No Web Server)
If you are securing a custom Python/Go API, Docker container, or mail server and port 80 is currently unoccupied:

```bash
sudo certbot certonly --standalone -d api.example.com
```

Certbot spins up a temporary lightweight web server on port 80, completes the ACME challenge, saves the certificates, and terminates the temporary server.

---

### Scenario 4: Wildcard Certificates via DNS-01 Challenge
To issue a certificate covering `*.example.com` and all possible subdomains, you must prove ownership of the entire DNS zone using a DNS TXT record:

```bash
sudo certbot certonly --manual --preferred-challenges dns -d "example.com" -d "*.example.com"
```

1. Certbot will output a specific TXT record name (e.g. `_acme-challenge.example.com`) and a random verification string.
2. Log into your DNS provider (e.g. [ternisdomains.de](https://ternisdomains.de)) and create the TXT record.
3. Wait 30 seconds for DNS propagation, then press Enter in Certbot to finish issuance.

---

## 4. Automatic Renewal & Dry Runs

Let's Encrypt certificates are valid for **90 days**. Certbot automatically renews certificates when they have **30 days or fewer** remaining.

### Testing the renewal mechanism (Dry Run):
To verify that your server can renew without errors before waiting 60 days:

```bash
sudo certbot renew --dry-run
```
- `--dry-run`: Performs a complete simulation of the renewal process with Let's Encrypt staging servers without actually replacing your production certificates.

### How automatic renewal runs in the background:
When installed via snap or apt, Certbot installs a systemd timer that runs twice every day:

```bash
systemctl list-timers | grep certbot
```

### Adding a Post-Renewal Hook:
When a certificate renews, running web servers or reverse proxies must reload to read the new certificate files from disk:

```bash
sudo certbot renew --deploy-hook "systemctl reload nginx"
```
Or place an executable script inside `/etc/letsencrypt/renewal-hooks/deploy/reload-services.sh`:

```bash
#!/usr/bin/env bash
systemctl reload nginx
```

---

## 5. Certificate Management Commands

### 1. View all active certificates, domains, and expiry dates:
```bash
sudo certbot certificates
```
**Example Output:**
```text
Found the following certs:
  Certificate Name: example.com
    Serial Number: 4a2f8b...
    Key Type: ECDSA
    Domains: example.com www.example.com
    Expiry Date: 2027-01-04 14:22:00+00:00 (VALID: 89 days)
    Certificate Path: /etc/letsencrypt/live/example.com/fullchain.pem
    Private Key Path: /etc/letsencrypt/live/example.com/privkey.pem
```

### 2. Delete an old or decommissioned certificate:
```bash
sudo certbot delete --cert-name example.com
```

### 3. Revoke a compromised certificate:
```bash
sudo certbot revoke --cert-path /etc/letsencrypt/live/example.com/cert.pem
```

---

## 6. Common Issues & Troubleshooting

| Error | Cause | Resolution |
|-------|-------|------------|
| **`Connection refused` on port 80** | Firewall (UFW) or cloud security group blocks HTTP port 80 | Let's Encrypt HTTP-01 validation **strictly requires port 80**. Run `sudo ufw allow 80/tcp` and verify ISP does not block port 80. |
| **`CAA record forbids issuance`** | DNS CAA record specifies another CA | Ensure your DNS zone does not have CAA records restricting issuance, or add `CAA 0 issue "letsencrypt.org"`. |
| **`Too many certificates already issued`** | Exceeded Let's Encrypt rate limit (50 per registered domain per week) | Use Let's Encrypt staging environment during development: add `--staging` flag. |
| **Nginx test failure on reload** | Broken configuration syntax | Test Nginx configuration before running Certbot: `sudo nginx -t`. |
