---
title: SSH Hardening — Keys, sshd_config, and Brute-Force Protection
description: Complete step-by-step guide to securing SSH access on Linux servers using Ed25519 keys, disabling passwords, hardening daemon configuration, and testing.
category: linux
order: 10
tags: [linux, ssh, security, hardening, sysadmin, devops]
updated: 2026-10-06
related: [ubuntu/ufw-basics, linux-packages/fail2ban, linux/filesystem-permissions]
---

## Why harden SSH?

**SSH (Secure Shell)** is the primary remote management interface for Linux servers. Because it is exposed to the internet, internet bots continuously probe port 22 with automated dictionaries of common usernames (`root`, `admin`, `ubuntu`) and passwords.

Securing SSH consists of three core defenses:
1. **Cryptographic key authentication** (replaces easily guessable passwords).
2. **Disabling direct root logins** (attackers cannot target the default superuser account).
3. **Hardening the SSH daemon configuration** (reducing timeouts, limiting authentication attempts).

---

## Step 1: Generating a modern Ed25519 key pair

On your **local computer** (laptop or desktop), generate an Ed25519 SSH key pair. Ed25519 offers superior security, smaller key lengths, and resistance to side-channel attacks compared to legacy RSA:

```bash
ssh-keygen -t ed25519 -C "you@example.com"
```

### Command & flag breakdown

- `ssh-keygen`: The standard OpenSSH key generation utility.
- `-t ed25519`: Specifies the cryptographic algorithm type. `ed25519` (Edwards-curve Digital Signature Algorithm) is the modern gold standard.
- `-C "you@example.com"`: Adds a comment label to the end of the public key file. This helps you identify which device owns which key when inspecting `authorized_keys`.
- When prompted for a passphrase: **Always provide a passphrase!** A passphrase encrypts your private key file on disk so that even if your laptop is stolen, your server credentials remain safe.

This produces two files in `~/.ssh/`:
- `id_ed25519` (Private Key): **Never share this file.** Permissions must be `600`.
- `id_ed25519.pub` (Public Key): This is copied to servers you want to log into.

---

## Step 2: Copying the public key to the server

To install your public key onto your remote server:

```bash
ssh-copy-id -i ~/.ssh/id_ed25519.pub username@server-ip
```

### Command & flag breakdown

- `ssh-copy-id`: A helper script that connects to the target host and installs your public key into the remote user's `~/.ssh/authorized_keys` file.
- `-i <path>`: Specifies the path to the public key file to install.
- `username@server-ip`: The target remote user and IP address or hostname.

If `ssh-copy-id` is unavailable on your system, you can manually append your key:

```bash
# On the remote server:
mkdir -p ~/.ssh
chmod 700 ~/.ssh
echo "ssh-ed25519 AAAAC3NzaC1l... you@example.com" >> ~/.ssh/authorized_keys
chmod 600 ~/.ssh/authorized_keys
```

---

## Step 3: Hardening `/etc/ssh/sshd_config`

Connect to the server and edit the SSH daemon configuration (or drop a file into `/etc/ssh/sshd_config.d/99-hardening.conf`):

```bash
sudo nano /etc/ssh/sshd_config
```

Set the following security directives:

```text
# Disable password authentication completely
PasswordAuthentication no
ChallengeResponseAuthentication no

# Disable root login over SSH
PermitRootLogin no

# Enforce public key authentication
PubkeyAuthentication yes

# Connection & attempt limits
MaxAuthTries 3
LoginGraceTime 30
X11Forwarding no

# Optional: Restrict which users can log in
AllowUsers deploy fabian
```

### Directives breakdown

- `PasswordAuthentication no`: Disables passwords entirely. Attackers cannot brute-force passwords because the server will refuse password prompts.
- `PermitRootLogin no`: Disallows direct login as `root`. You must log in as a normal user with sudo privileges.
- `PubkeyAuthentication yes`: Enables cryptographic key-based logins.
- `MaxAuthTries 3`: Disconnects after 3 failed authentication attempts (slows down automated fuzzing tools).
- `LoginGraceTime 30`: Drops unauthenticated connections if they fail to authenticate within 30 seconds.
- `X11Forwarding no`: Disables graphical window forwarding, eliminating unnecessary attack surface.
- `AllowUsers <user1> <user2>`: Whitelists specific accounts permitted to connect; all other accounts are rejected.

---

## Step 4: Testing syntax and safely restarting sshd

:::warn
**Never disconnect your current SSH session until you verify the new configuration works in a second terminal window!**
:::

Always test for configuration syntax errors before restarting:

```bash
# 1. Test configuration syntax
sudo sshd -t

# 2. Restart the SSH service
sudo systemctl restart ssh    # On Debian/Ubuntu
# or: sudo systemctl restart sshd   # On RHEL/CentOS/Fedora
```

### Command & flag breakdown

- `sshd -t`: **Test mode**. Validates configuration files and reports syntax errors. If it outputs nothing, the syntax is valid.
- `systemctl restart ssh`: Restarts the daemon so changes take effect.

**Crucial test:** Open a new, separate terminal window on your local machine and run:

```bash
ssh username@server-ip
```

If the new session connects cleanly using your key, your server is secure.

---

## Step 5: Verification tests

Run these checks to confirm passwords and root access are truly blocked:

```bash
# 1. Test password rejection (must output: Permission denied (publickey))
ssh -o PreferredAuthentications=password username@server-ip

# 2. Test root login rejection
ssh root@server-ip

# 3. View SSH authentication logs in systemd journal
sudo journalctl -u ssh -n 20 --no-pager
```

### Command & flag breakdown

- `-o PreferredAuthentications=password`: Forces the SSH client to attempt password login only, verifying that your server actively rejects password authentication.
- `journalctl -u ssh`: Displays recent system log entries for the SSH daemon.
