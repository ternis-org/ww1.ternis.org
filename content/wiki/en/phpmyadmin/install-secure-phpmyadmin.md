---
title: Install and Secure phpMyAdmin on Ubuntu & Debian
description: Step-by-step beginner guide to installing phpMyAdmin, configuring blowfish cookie encryption, custom URL aliases, and securing access behind IP and VPN allow-lists.
category: phpmyadmin
order: 10
tags: [phpmyadmin, mysql, mariadb, security, sysadmin, php, ubuntu]
updated: 2026-10-06
related: [mysql-mariadb/backup-restore-mysqldump, mysql-mariadb/choosing-mysql-vs-mariadb, ubuntu/ufw-basics]
---

## What is phpMyAdmin and why must it be secured?

**phpMyAdmin** is a free, web-based graphical user interface for managing MySQL and MariaDB databases. It lets you run SQL queries, import/export tables, manage user permissions, and optimize databases from a web browser.

:::warn
**phpMyAdmin is the single most actively scanned administrative tool on the public internet.** Automated botnets scan every IPv4 address 24/7 searching for `/phpmyadmin`. If left exposed on default URLs with standard logins, it will suffer endless brute-force attempts and potential zero-day exploit probes.
:::

---

## Step 1: Installing phpMyAdmin and prerequisites

Install phpMyAdmin along with required PHP multibyte and compression extensions:

```bash
sudo apt update
sudo apt install -y phpmyadmin php-mbstring php-zip php-gd php-json php-curl
```

### Installation prompts breakdown

During the interactive installation package wizard:
1. **Web server selection**: If using Apache, select `apache2` with the Spacebar. If using Nginx or Caddy, select nothing and press `Enter` (we configure the web server virtual host manually).
2. **dbconfig-common**: Choose `Yes` to allow the installer to create phpMyAdmin's internal storage database schema (`phpmyadmin`), then set a password for the application's internal control user.

---

## Step 2: Generating a strong Blowfish secret

phpMyAdmin uses a cryptographic passphrase (the **Blowfish secret**) to encrypt session cookies in the browser. If this secret is missing or too short, you will see a red error banner: *"The secret passphrase in configuration (blowfish_secret) is too short."*

Generate a cryptographically secure 32-character random string:

```bash
openssl rand -base64 32
```

### Command & flag breakdown

- `openssl rand`: OpenSSL random byte generation engine.
- `-base64`: Encodes raw random binary bytes into clean printable ASCII base64 characters.
- `32`: Generates 32 bytes of high-entropy cryptographic randomness.

Edit `/etc/phpmyadmin/config.inc.php`:

```bash
sudo nano /etc/phpmyadmin/config.inc.php
```

Locate the `$cfg['blowfish_secret']` line and paste your generated string:

```php
$cfg['blowfish_secret'] = 'a9F3k...your_32_character_random_string_here...';
```

---

## Step 3: Hardening phpMyAdmin

Follow these essential security practices to protect your database:

### 1. Change the URL alias away from `/phpmyadmin`

Never leave phpMyAdmin reachable at the standard `/phpmyadmin` URL. In Apache (`/etc/apache2/conf-available/phpmyadmin.conf`) or Nginx, change the location alias:

```nginx
# Instead of location /phpmyadmin:
location /secret_db_console_8892/ {
    alias /usr/share/phpmyadmin/;
    index index.php;
    # ...
}
```

This immediately eliminates 99.9% of automated internet scan hits.

### 2. Restrict access by IP or VPN

Only allow your home/office static IP address or VPN subnet (such as Tailscale or WireGuard) to access the administrative directory:

```nginx
location /secret_db_console_8892/ {
    alias /usr/share/phpmyadmin/;
    index index.php;

    # Allow local network / VPN only:
    allow 100.64.0.0/10;   # Tailscale CGNAT range
    allow 192.168.1.0/24;  # Local office subnet
    allow 203.0.113.50;    # Admin static IP
    deny all;              # Block all other internet visitors
}
```

### 3. Disable root database logins

Never log into phpMyAdmin using the database `root` account over the web. Create a dedicated database user with privileges scoped strictly to the application schemas they actually need:

```sql
CREATE USER 'app_admin'@'localhost' IDENTIFIED BY 'VeryStrongSecurePassword123!';
GRANT ALL PRIVILEGES ON app_database.* TO 'app_admin'@'localhost';
FLUSH PRIVILEGES;
```

---

## Quick Reference Security Checklist

| Check | Recommendation | Why |
|-------|----------------|-----|
| **HTTPS Only** | Enforce TLS with valid certificate | Session cookies contain unencrypted database credentials in transit |
| **Blowfish Secret** | 32-character random base64 string | Encrypts authentication cookie data |
| **Custom Path** | Rename `/phpmyadmin` to unguessable slug | Evades automated mass internet vulnerability scanners |
| **IP Restriction** | Whitelist trusted IPs or private VPN | Eliminates remote internet attack surface completely |
| **Authentication** | Use `cookie` auth, never `config` | Never store database passwords in plain text on disk |
