---
title: Install and Secure phpMyAdmin on Ubuntu
description: Install phpMyAdmin with cookie auth, a blowfish secret, and access restricted to VPN or IP allow-list.
category: phpmyadmin
order: 10
tags: [phpmyadmin, mysql, mariadb, install]
updated: 2026-10-06
related: [mysql-mariadb/backup-restore-mysqldump]
---

## Install

```bash
sudo apt install phpmyadmin
```

Choose `apache2` or `none` (for Nginx + PHP-FPM, configure the vhost manually).
Use **cookie auth** — never hardcode credentials in `config.inc.php`.

## Blowfish secret

```bash
openssl rand -base64 32
```

Paste it as `$cfg['blowfish_secret']` in `/etc/phpmyadmin/config.inc.php`.
It encrypts cookies; without it, sessions break on every deploy.

## Hardening checklist

- [ ] Restrict `/phpmyadmin` by IP or serve only over VPN/Tailscale.
- [ ] Never allow `root` login — create a least-privilege DBA user.
- [ ] Force HTTPS (HSTS) — cookies carry live database access.
- [ ] Rename the alias from `/phpmyadmin` to something unguessable.

:::warn
phpMyAdmin is the most-scanned admin panel on the internet. If it is reachable
from the public internet without IP restriction, it will be attacked daily.
:::
