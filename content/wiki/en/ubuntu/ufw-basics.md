---
title: UFW Basics — Default-Deny Firewall on Ubuntu & Debian
description: Step-by-step beginner guide to configuring Ubuntu's Uncomplicated Firewall (UFW), command breakdown, rules, port syntax, and avoiding SSH lockout.
category: ubuntu
order: 10
tags: [ubuntu, debian, ufw, firewall, security, linux]
updated: 2026-10-06
related: [linux/ssh-hardening, linux-packages/fail2ban, networking/nat-port-forwarding]
---

## What is UFW?

**UFW (Uncomplicated Firewall)** is a frontend interface for Linux's kernel packet filtering subsystems (`iptables` and `nftables`). Direct `iptables` syntax is notorious for being complex and error-prone. UFW simplifies firewall administration into clear, intuitive commands so you can secure a server in minutes.

A firewall inspects incoming and outgoing network traffic, deciding whether to permit or block packets based on rules (IP addresses, ports, and protocols).

---

## The golden rule: Default-Deny policy

A secure server follows the **principle of least privilege**:
1. **Block all incoming traffic** by default (prevent unauthorized scans and connections).
2. **Allow all outgoing traffic** by default (allow your server to fetch updates and query DNS).
3. **Explicitly allow only the specific ports** needed for your services (e.g. SSH, HTTP, HTTPS).

```bash
sudo ufw default deny incoming
sudo ufw default allow outgoing
```

### Command & flag breakdown

- `sudo`: Executes the command with superuser (root) privileges, required for network interface modifications.
- `ufw`: The firewall management binary.
- `default deny incoming`: Instructs UFW to drop every incoming connection request unless an explicit rule allows it.
- `default allow outgoing`: Allows your server's own outbound network requests (such as `apt update`, DNS queries, or outbound API requests) to leave unobstructed.

---

## Step 2: Allow SSH BEFORE enabling the firewall

:::warn
**Never enable UFW before opening your SSH port!** If you enable the firewall without an allow rule for SSH, your current connection will be severed and you will be completely locked out of your remote VPS or server.
:::

Open port 22 (or your custom SSH port) before activating UFW:

```bash
sudo ufw allow 22/tcp
```

### Command & flag breakdown

- `allow`: Creates a rule permitting matching packets through the firewall.
- `22`: The port number. Port 22 is the standard IANA port for the SSH (Secure Shell) protocol.
- `/tcp`: The transport layer protocol. SSH uses TCP (Transmission Control Protocol), not UDP. Restricting rules to the exact protocol (`/tcp`) is cleaner and more secure than omitting it.

---

## Step 3: Rate-limiting SSH (Brute-force protection)

To protect SSH against credential brute-forcing, UFW provides a built-in rate-limiting feature:

```bash
sudo ufw limit 22/tcp
```

### Command & flag breakdown

- `limit`: Instead of simply allowing all attempts, `limit` permits connections but automatically denies connections from an IP address that attempts 6 or more connections within 30 seconds. This stops automated brute-force password bots without needing third-party tools.

---

## Step 4: Allowing web services (HTTP & HTTPS)

Web servers (like Nginx, Caddy, or Apache) require ports 80 (HTTP) and 443 (HTTPS) to be reachable from the internet.

You can specify individual ports or combined comma-separated lists:

```bash
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
# Or combined:
sudo ufw allow 80,443/tcp
```

### Command & flag breakdown

- `80/tcp`: Standard unencrypted web traffic port (used for initial redirects and ACME domain validation).
- `443/tcp`: Standard encrypted web traffic port (TLS/SSL).

---

## Step 5: Working with Application Profiles

UFW can read predefined service profiles located in `/etc/ufw/applications.d/`. These profiles map human-readable names to their required ports:

```bash
# List available application profiles on your system
sudo ufw app list

# Inspect what ports a profile opens
sudo ufw app info 'Nginx Full'

# Allow the profile
sudo ufw allow 'Nginx Full'
```

### Command & flag breakdown

- `app list`: Scans installed packages that registered UFW profiles (e.g. `OpenSSH`, `Nginx HTTP`, `Nginx HTTPS`, `Nginx Full`).
- `app info '<Profile>'`: Displays the description, ports, and protocols defined by that application profile. For instance, `Nginx Full` automatically opens both port 80 and port 443.

---

## Step 6: Enabling and verifying UFW

Once your allow rules are confirmed, enable the firewall and inspect the active status:

```bash
sudo ufw enable
sudo ufw status verbose
```

### Command & flag breakdown

- `enable`: Activates the firewall and configures the system to start UFW automatically upon system boot. It will prompt with: `Command may disrupt existing ssh connections. Proceed with operation (y|n)?`. If you already allowed port 22, press `y`.
- `status verbose`: Outputs the complete current status of the firewall, showing:
  - Logging mode
  - Default policies (`deny (incoming)`, `allow (outgoing)`)
  - A table of all active rules with their action (`ALLOW IN`, `LIMIT IN`), source IP, and destination port.

---

## Managing rules: Listing by number and deleting

If you made a mistake or want to remove an old port rule, do not guess. View numbered rules and delete by rule index:

```bash
sudo ufw status numbered
sudo ufw delete 2
```

### Command & flag breakdown

- `status numbered`: Displays every rule prefixed with a bracketed index number (e.g., `[ 1]`, `[ 2]`).
- `delete <number>`: Deletes the rule corresponding to that exact number. This avoids typos and ensures you remove only the targeted rule.

---

## Advanced: Allowing specific IP addresses or subnets

If you have a private database or internal admin service that should only be accessible from your home or office IP:

```bash
sudo ufw allow from 203.0.113.45 to any port 3306 proto tcp
sudo ufw allow from 192.168.1.0/24 to any port 22 proto tcp
```

### Command & flag breakdown

- `from <IP or CIDR>`: Restricts the rule to accept connections only originating from that specific IP address or local subnet.
- `to any port <port>`: The destination port on your server (e.g. 3306 for MySQL/MariaDB).
- `proto tcp`: Explicitly restricts the rule to TCP packets.

---

## Quick Reference Summary Table

| Command | Purpose |
|---------|---------|
| `sudo ufw default deny incoming` | Sets default incoming policy to block everything |
| `sudo ufw default allow outgoing` | Sets default outgoing policy to allow server internet access |
| `sudo ufw allow 22/tcp` | Opens TCP port 22 for SSH connections |
| `sudo ufw limit 22/tcp` | Rate-limits SSH (blocks IPs with 6+ attempts in 30s) |
| `sudo ufw allow 80,443/tcp` | Opens standard HTTP and HTTPS ports for web traffic |
| `sudo ufw allow 'Nginx Full'` | Uses the registered application profile for HTTP and HTTPS |
| `sudo ufw enable` | Activates UFW and enables boot-time startup |
| `sudo ufw disable` | Deactivates UFW without deleting rules |
| `sudo ufw status verbose` | Shows active status, policies, and detailed rules |
| `sudo ufw status numbered` | Shows numbered list of rules for easy deletion |
| `sudo ufw delete <number>` | Deletes rule by number |
| `sudo ufw reload` | Reloads rules from configuration files without downtime |
