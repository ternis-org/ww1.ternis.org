---
title: btop — Modern Terminal Resource Monitor
description: Monitor CPU, memory, disks, networks, and running processes with the responsive and visual btop monitor in your Linux terminal.
category: linux-packages
order: 20
tags: [btop, monitoring, linux, sysadmin, terminal]
updated: 2026-10-06
related: [linux/systemd-services-timers, homelab/proxmox-getting-started]
---

## What is btop?

`btop` (C++ successor to `bpytop` and `bashtop`) is a modern, high-performance terminal resource monitor. It provides rich real-time visual graphs for CPU usage, memory and swap, disk read/write throughput, network upload/download rates, and an interactive process list with tree view and signal dispatch.

## Installation

On modern Linux distributions:

```bash
# Ubuntu / Debian
sudo apt install -y btop

# Fedora
sudo dnf install -y btop

# Arch Linux
sudo pacman -S btop
```

If your distribution carries an older version, install the static binary directly:

```bash
sudo snap install btop
```

## Running and Navigation

Start the monitor:

```bash
btop
```

Key keyboard shortcuts inside `btop`:

| Key | Action |
| --- | --- |
| `Esc` or `m` | Open main configuration and theme menu |
| `q` | Quit btop |
| `Up` / `Down` | Browse through running processes |
| `k` | Send `SIGKILL` (kill) to selected process |
| `t` | Toggle process tree view |
| `f` | Filter processes by name |
| `+` / `-` | Increase / decrease refresh rate |

:::tip
Press `m` and navigate to **Options > Color theme** to choose themes like Dracula, Solarized, Gruvbox, or Nord directly inside your terminal without editing config files.
:::
