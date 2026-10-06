---
title: Fail2ban — Protect SSH and Web Services from Brute-Force Attacks
description: Complete beginner-friendly guide to installing, configuring, and monitoring fail2ban on Linux, with detailed flag explanations, jail.local setup, and IP management.
category: linux-packages
order: 10
tags: [fail2ban, security, linux, ssh, ufw, firewalls, sysadmin]
updated: 2026-10-06
related: [linux/ssh-hardening, ubuntu/ufw-basics, linux-packages/nginx, linux-packages/caddy]
---

## What is fail2ban and how does it work?

Whenever an internet-facing Linux server is connected with an open port (such as SSH on port 22 or web applications on port 80/443), automated bots immediately begin attempting thousands of password guesses per hour.

**Fail2ban** is an intrusion prevention framework that runs as a background daemon (`fail2ban-server`). It actively reads your server's log files (like `/var/log/auth.log` or systemd journals) looking for repeated authentication errors. When an IP address exceeds a configured limit within a certain time window, fail2ban temporarily or permanently inserts a firewall rule (`nftables`, `iptables`, or `ufw`) to drop all subsequent packets from that IP.

```text
[ Attacker Bot ] ──(Failed SSH logins)──► [ /var/log/auth.log ]
                                                    │
                                                    ▼ (Scans with regex filters)
                                          [ fail2ban Daemon ]
                                                    │
                                                    ▼ (Exceeded maxretry!)
                                          [ Linux Firewall (UFW/nftables) ]
                                                    │
                                                    ▼
                                          [ Drop packets from Attacker IP ]
```

---

## 1. Installation and Service Setup

On Debian, Ubuntu, or Raspberry Pi OS, install fail2ban using the Advanced Package Tool (APT):

```bash
sudo apt update
sudo apt install -y fail2ban
sudo systemctl enable --now fail2ban
```

### Breakdown of installation commands and flags:
- `sudo`: Executes the command with root (administrator) privileges required for installing system packages and managing firewalls.
- `apt update`: Refreshes your local cache of package repository indices so you install the newest version.
- `apt install -y fail2ban`: Installs the fail2ban package. The `-y` flag answers "yes" to all interactive prompts automatically.
- `systemctl enable --now fail2ban`: Combines two steps into one:
  - `enable`: Configures fail2ban to start automatically on every system boot.
  - `--now`: Starts the background service immediately without requiring a reboot.

Verify that the daemon is actively running:

```bash
sudo systemctl status fail2ban
```

---

## 2. Configuration: Understanding `jail.conf` vs `jail.local`

Fail2ban ships with a default configuration file located at `/etc/fail2ban/jail.conf`.

:::warn
**Never edit `/etc/fail2ban/jail.conf` directly!**  
When the fail2ban package is updated via `apt upgrade`, package maintainers overwrite `jail.conf` with newer default upstream values, wiping out your custom rules.
:::

Fail2ban uses a layered configuration system: any file ending in `.local` overrides settings from `.conf`. Always create a copy named `jail.local`:

```bash
sudo cp /etc/fail2ban/jail.conf /etc/fail2ban/jail.local
```

Now open the file in your preferred text editor:

```bash
sudo nano /etc/fail2ban/jail.local
```

---

## 3. Essential Global Parameters Explained

Inside `/etc/fail2ban/jail.local`, locate the `[DEFAULT]` section. These settings apply to all active jails unless overridden by an individual service section:

```ini
[DEFAULT]
# How long an offending IP remains banned (e.g. 1h, 1d, 1w)
bantime = 1h

# The sliding time window during which failed attempts are counted
findtime = 10m

# How many failed attempts trigger a ban within findtime
maxretry = 5

# Trusted IP addresses or subnets that must NEVER be banned
ignoreip = 127.0.0.1/8 ::1 192.168.1.0/24 203.0.113.15

# Log monitoring backend (systemd is best for modern Debian/Ubuntu)
backend = systemd
```

### Parameter Breakdown:
- **`bantime = 1h`**: Duration of the firewall block. You can specify seconds (`3600`), minutes (`60m`), hours (`1h`), or days (`7d`). Setting `bantime = -1` creates a permanent ban.
- **`findtime = 10m`**: The monitoring window. If an IP fails 5 logins across 10 minutes, it is banned. If it fails 4 logins over 10 minutes and stops, the counter resets.
- **`maxretry = 5`**: The number of offenses permitted before fail2ban enforces the firewall drop rule.
- **`ignoreip`**: A space-separated list of IP addresses, CIDR network ranges (e.g., `192.168.1.0/24`), or DNS hostnames that are exempted. **Always include your static home/office IP or VPN address here** to avoid locking yourself out.
- **`backend = systemd`**: Instructs fail2ban to read directly from the systemd journal rather than polling flat text log files, which improves performance and avoids log-rotation latency.

---

## 4. Configuring the SSH Jail (`[sshd]`)

Scroll down to the `[sshd]` section in `/etc/fail2ban/jail.local` and configure your SSH protection:

```ini
[sshd]
enabled  = true
port     = ssh
filter   = sshd
maxretry = 3
bantime  = 24h
```

### Explanation of Jail Parameters:
- **`enabled = true`**: Activates this specific jail.
- **`port = ssh`**: Defaults to port 22. If you changed your SSH port to a custom port (e.g., `2222`), change this value to match: `port = 2222`.
- **`filter = sshd`**: The regex filter used to parse logs (found in `/etc/fail2ban/filter.d/sshd.conf`).
- **`maxretry = 3`**: Stricter limit for SSH than the default.
- **`bantime = 24h`**: Keeps SSH brute-force attackers blocked for a full 24 hours.

After saving your changes (`Ctrl+O` then `Ctrl+X` in nano), restart fail2ban:

```bash
sudo systemctl restart fail2ban
```

---

## 5. Web Server Protection: Nginx & Apache Jails

You can also protect web applications against automated exploit scanners and brute-force HTTP auth attacks.

### Protecting Nginx against 404/Exploit Probers:
Add this jail block to `/etc/fail2ban/jail.local`:

```ini
[nginx-botsearch]
enabled  = true
port     = http,https
filter   = nginx-botsearch
logpath  = /var/log/nginx/error.log
maxretry = 2
bantime  = 48h
```

- **`port = http,https`**: Applies the firewall rule to both port 80 and port 443.
- **`filter = nginx-botsearch`**: Detects probes looking for `/wp-login.php`, `phpmyadmin`, or `.env` files that don't exist on your server.
- **`maxretry = 2`**: Because legitimate users rarely probe non-existent administrative endpoints, ban after only 2 attempts.

---

## 6. Daily Operations & CLI Command Reference

Fail2ban provides a management CLI tool called `fail2ban-client`.

### 1. View overall daemon status and active jails
```bash
sudo fail2ban-client status
```
**Example Output:**
```text
Status
|- Number of jail:      2
`- Jail list:           nginx-botsearch, sshd
```

---

### 2. Inspect a specific jail to see currently banned IPs
```bash
sudo fail2ban-client status sshd
```
**Example Output:**
```text
Status for the jail: sshd
|- Filter
|  |- Currently failed: 1
|  |- Total failed:     42
|  `- File list:        systemd
`- Actions
   |- Currently banned: 2
   |- Total banned:     15
   `- Banned IP list:   198.51.100.24 203.0.113.88
```

---

### 3. Manually unban an IP address
If a colleague or family member got banned by mistyping their SSH password, unban them immediately:

```bash
sudo fail2ban-client set sshd unbanip 203.0.113.88
```
- `set sshd`: Specifies which jail to modify.
- `unbanip <IP>`: Removes the firewall block for that specific IP address.

---

### 4. Manually ban an aggressive IP address
```bash
sudo fail2ban-client set sshd banip 198.51.100.99
```

---

### 5. Test regex filters against a log file
When debugging why an IP was or wasn't banned, use `fail2ban-regex`:

```bash
sudo fail2ban-regex /var/log/auth.log /etc/fail2ban/filter.d/sshd.conf
```
- Analyzes the log file against the filter pattern and reports how many lines matched and how many were ignored.

---

## 7. Troubleshooting & Recovery Checklist

| Problem | Cause | Solution |
|---------|-------|----------|
| **Locked out of your server** | You mistyped your password too many times without whitelisting your IP | Access server via hosting provider console (VNC/KVM), then run `sudo fail2ban-client set sshd unbanip <Your_IP>` and add your subnet to `ignoreip`. |
| **No IPs ever get banned** | Log path or backend mismatch in systemd | Set `backend = systemd` in `[DEFAULT]` or verify log file path with `ls -l /var/log/auth.log`. |
| **Fail2ban fails to start** | Typo or duplicate bracket in `jail.local` | Check syntax with `sudo fail2ban-client -d` or inspect service errors with `sudo journalctl -u fail2ban -e`. |
| **Behind Cloudflare proxy** | Web jail sees Cloudflare IP instead of real client IP | Configure Nginx `set_real_ip_from` module so logs record the authentic visitor IP (`CF-Connecting-IP`). |
