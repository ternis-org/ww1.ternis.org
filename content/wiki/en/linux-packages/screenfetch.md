---
title: screenfetch — System Information & ASCII Art Tool
description: Complete beginner guide to screenfetch, displaying Linux distribution ASCII logos, hardware specifications, uptime, and configuring SSH MOTD welcome banners.
category: linux-packages
order: 70
tags: [screenfetch, terminal, sysadmin, linux, motd, cli, hardware]
updated: 2026-10-06
related: [linux-packages/btop, linux/filesystem-permissions, linux/ssh-hardening]
---

## What is screenfetch?

**`screenfetch`** is the classic "Bash Screenshot Information Tool" for Linux and Unix systems.

When executed, it automatically detects your operating system, renders the official distribution logo in vibrant ASCII art on the left, and prints detailed hardware and system metrics on the right:
- User and Hostname (`user@hostname`)
- Operating System & Distribution version (e.g. Ubuntu 24.04 LTS, Debian 12)
- Linux Kernel version (`uname -r`)
- System Uptime (days, hours, minutes since last boot)
- Installed Package count (APT, DNF, Pacman, Snap)
- Active Shell (`bash`, `zsh`)
- Screen Resolution / Desktop Environment (or server TTY)
- CPU model and core count
- GPU model
- RAM utilization (Used / Total MB)

---

## Installation

Install screenfetch via your package manager:

```bash
# Ubuntu / Debian
sudo apt update
sudo apt install -y screenfetch

# Fedora / RHEL
sudo dnf install -y screenfetch

# Arch Linux
sudo pacman -S screenfetch
```

---

## Usage & Command Flags Breakdown

```bash
# 1. Standard execution
screenfetch

# 2. Strip colors (clean monochrome output for plain logs)
screenfetch -N

# 3. Force a specific distribution logo (e.g. Debian or Arch)
screenfetch -D 'Debian'

# 4. Verbose mode showing hardware detection steps
screenfetch -v

# 5. Take an automated desktop screenshot after printing specs
screenfetch -s
```

### Flag breakdown

- `-N` (no color): Strips ANSI color escape codes from output, useful when piping into plain text log files or emails.
- `-D '<Distro>'`: Overrides automatic distribution detection and forces the ASCII art of another distribution (e.g. `Debian`, `Ubuntu`, `Arch Linux`, `Fedora`, `FreeBSD`).
- `-v` (verbose): Prints debugging output showing which sysfs files and binaries screenfetch queries to gather system information.
- `-s` (screenshot): Automatically captures a PNG screenshot of your terminal window.

---

## Adding screenfetch as an SSH MOTD Welcome Banner

A classic sysadmin touch is displaying system specs automatically whenever you log into your server over SSH:

```bash
# Create an executable profile script
echo "screenfetch" | sudo tee /etc/profile.d/motd-screenfetch.sh
sudo chmod 755 /etc/profile.d/motd-screenfetch.sh
```

### How it works

Scripts located in `/etc/profile.d/` with execute permissions (`755`) run automatically whenever an interactive login shell starts. The next time you log in via `ssh user@server`, your distribution logo and hardware stats greet you immediately in the terminal.
