---
title: screenfetch — System Information & ASCII Art Tool
description: Display distribution logos, kernel version, uptime, memory, and hardware stats in your terminal or SSH MOTD banners.
category: linux-packages
order: 70
tags: [screenfetch, terminal, sysadmin, linux, motd]
updated: 2026-10-06
related: [linux-packages/btop, linux/filesystem-permissions]
---

## What is screenfetch?

`screenfetch` is a popular "Bash Screenshot Information Tool". It automatically detects your Linux distribution, renders the official distribution logo in ASCII art, and prints key system statistics like kernel version, uptime, package count, shell, CPU, and memory usage.

## Installation

```bash
# Ubuntu / Debian
sudo apt update
sudo apt install -y screenfetch

# Fedora
sudo dnf install -y screenfetch

# Arch Linux
sudo pacman -S screenfetch
```

## Usage

Simply run:

```bash
screenfetch
```

Useful command flags:

| Flag | Description |
| --- | --- |
| `-v` | Verbose output with detailed detection steps |
| `-N` | Strip ANSI color escape codes |
| `-D 'Debian'` | Force display of a specific distribution logo |
| `-s` | Take a screenshot after printing info |

## Use as an SSH MOTD Welcome Banner

To greet yourself with your server's specs every time you log in via SSH, add it to `/etc/profile.d/motd-specs.sh`:

```bash
echo "screenfetch" | sudo tee /etc/profile.d/motd-specs.sh
sudo chmod +x /etc/profile.d/motd-specs.sh
```

Next time you open an SSH connection, your distribution logo and hardware stats will greet you in color.
