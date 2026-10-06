---
title: Linux Filesystem Permissions — rwx, chmod, sudo Hygiene
description: Owner/group/other bits, chmod and chown, umask, and sudo rules that don't hand out root.
category: linux
order: 5
tags: [linux, permissions, chmod, sudo]
updated: 2026-10-06
related: [linux/ssh-hardening, linux/systemd-services-timers]
---

## The nine bits

```text
-rwxr-xr--  app
 │││ │││ │││
 │││ │││ └── others: read only
 │││ └────── group: read + execute
 └────────── owner: full control
```

`r=4, w=2, x=1`: `755` = directories and executables, `644` = data files,
`600` = secrets (SSH keys, `.env` files).

## Everyday commands

```bash
chmod 755 deploy.sh
chmod 600 ~/.ssh/id_ed25519
chown -R www-data:www-data /var/www/app
umask 027   # new files: 750 dirs, 640 files
```

## Sudo hygiene

```bash
# /etc/sudoers.d/deploy — one command, no blanket root
deploy ALL=(root) NOPASSWD: /usr/bin/systemctl restart myapp
```

Rules: individual files in `sudoers.d` (never edit the main file by hand —
always `visudo`), `NOPASSWD` only for non-interactive single commands, and no
`ALL=(ALL) NOPASSWD: ALL` anywhere outside throwaway VMs.

:::warn
`chmod 777` is never the fix. It trades a permission error you can diagnose for
a security hole you cannot see. Find the right owner instead.
:::
