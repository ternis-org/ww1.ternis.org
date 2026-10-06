---
title: UFW Basics — Default-Deny Firewall on Ubuntu
description: Allow-list firewalling with UFW: defaults, app profiles, and SSH rate limiting.
category: ubuntu
order: 10
tags: [ubuntu, ufw, firewall]
updated: 2026-10-06
related: [linux/ssh-hardening]
---

## Default deny, then open holes

```bash
sudo ufw default deny incoming
sudo ufw default allow outgoing
sudo ufw allow 22/tcp
sudo ufw allow 80,443/tcp
sudo ufw enable
sudo ufw status verbose
```

## SSH rate limiting

```bash
sudo ufw limit 22/tcp
```

This throttles brute-force connection attempts without fail2ban.

## App profiles

```bash
sudo ufw app list
sudo ufw allow 'Nginx Full'
```

:::warn
Enable the SSH rule **before** `ufw enable`. Locking yourself out of a remote
VPS is a rite of passage — check your provider's serial console first.
:::
