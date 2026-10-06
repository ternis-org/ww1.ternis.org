---
title: SSH Hardening — Keys, Config, Fail2ban
description: Key-only login, hardened sshd_config, and brute-force protection for any Linux server.
category: linux
order: 10
tags: [linux, ssh, security, hardening]
updated: 2026-10-06
related: [ubuntu/ufw-basics]
---

## Use keys, disable passwords

```bash
ssh-keygen -t ed25519 -C "you@example.com"
ssh-copy-id user@server
```

Then in `/etc/ssh/sshd_config`:

```text
PasswordAuthentication no
PermitRootLogin no
PubkeyAuthentication yes
```

Restart with `sudo systemctl restart ssh` and **keep your current session open**
until you verified a second login works.

## Harden the daemon

```text
Port 22
MaxAuthTries 3
LoginGraceTime 30
X11Forwarding no
AllowUsers deploy
```

:::warn
Changing the SSH port is obscurity, not security. Real protection comes from
keys plus a firewall plus fail2ban — not from hiding on port 2222.
:::

## Add fail2ban

```bash
sudo apt install fail2ban
sudo systemctl enable --now fail2ban
sudo fail2ban-client status sshd
```

## Verify

1. `ssh -o PreferredAuthentications=password user@server` must fail.
2. `sudo journalctl -u ssh --since today` shows only key logins.
3. Root login over SSH is refused.
