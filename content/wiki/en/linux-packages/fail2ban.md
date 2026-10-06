---
title: Fail2ban — Protect SSH and Web Services from Brute Force
description: Install, configure, and operate fail2ban to automatically block malicious IP addresses attempting brute-force logins.
category: linux-packages
order: 10
tags: [fail2ban, security, linux, ssh, ufw, firewalls]
updated: 2026-10-06
related: [linux/ssh-hardening, ubuntu/ufw-basics]
---

## What fail2ban does

Fail2ban scans system log files (like `/var/log/auth.log` or systemd journals) for repeated failed login attempts. When an IP address exceeds the configured threshold, fail2ban temporarily or permanently blocks that IP by adding a rule to your firewall (`nftables`, `iptables`, or `ufw`).

## Installation

On Debian, Ubuntu, or Raspberry Pi OS:

```bash
sudo apt update
sudo apt install -y fail2ban
sudo systemctl enable --now fail2ban
```

## Configure with jail.local

Never edit `/etc/fail2ban/jail.conf` directly, as package upgrades will overwrite it. Always create `/etc/fail2ban/jail.local`:

```bash
sudo cp /etc/fail2ban/jail.conf /etc/fail2ban/jail.local
```

Open `/etc/fail2ban/jail.local` and configure your default parameters:

```ini
[DEFAULT]
bantime  = 1h
findtime = 10m
maxretry = 5
ignoreip = 127.0.0.1/8 ::1 192.168.1.0/24

[sshd]
enabled = true
port    = 22
mode    = aggressive
```

:::tip
Always whitelist your trusted local network or VPN subnets under `ignoreip` to avoid accidentally locking yourself out of your server.
:::

## Common commands

Check the general service status:

```bash
sudo fail2ban-client status
```

Inspect a specific jail (like `sshd`):

```bash
sudo fail2ban-client status sshd
```

Unban an IP address that was blocked by mistake:

```bash
sudo fail2ban-client set sshd unbanip 203.0.113.42
```

Manually ban a persistent attacker:

```bash
sudo fail2ban-client set sshd banip 203.0.113.42
```

Restart fail2ban after configuration changes:

```bash
sudo systemctl restart fail2ban
```
