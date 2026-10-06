---
title: btop — Modern Terminal Resource Monitor
description: Complete beginner guide to btop, monitoring CPU cores, memory, swap, disk I/O, network bandwidth, process inspection, and sending kill signals from your terminal.
category: linux-packages
order: 20
tags: [btop, monitoring, linux, sysadmin, terminal, performance]
updated: 2026-10-06
related: [linux/systemd-services-timers, homelab/proxmox-getting-started, linux-packages/tmux]
---

## What is btop?

When investigating high server loads or sluggish systems, traditional tools like `top` feel archaic and hard to read.

**`btop`** (the high-performance C++ successor to `bpytop` and `bashtop`) is an interactive, responsive terminal resource monitor. It visualizes:
1. **CPU Usage & Temperatures**: Per-core frequency, utilization graphs, and system load averages.
2. **Memory & Swap**: Physical RAM utilization, disk cache buffers, and swap pressure.
3. **Disks & Storage I/O**: Real-time read/write speeds, free space percentages, and active mounts.
4. **Network Activity**: Real-time upload and download rate graphs with total bandwidth counters.
5. **Interactive Process Explorer**: Search, filter, inspect process trees, and terminate runaway processes.

---

## Installation

On modern Linux distributions:

```bash
# Ubuntu 22.04+ / Debian 12+
sudo apt update
sudo apt install -y btop

# Fedora / RHEL
sudo dnf install -y btop

# Arch Linux
sudo pacman -S btop
```

---

## Running btop and CLI Flags Breakdown

```bash
# Launch interactive monitor
btop

# Launch with a specific layout preset (Presets 0 to 4)
btop -p 1

# Launch in low-color mode (for basic TTYs or serial consoles)
btop --low-color
```

### CLI Flag breakdown

- `-p <number>` (or `--preset`): Loads a specific preset layout (e.g., CPU-only, processes-only, or full 4-panel dashboard).
- `--low-color`: Restricts rendering to standard 16-color ANSI output for legacy terminal emulators or low-bandwidth serial connections.
- `--utf-force`: Forces UTF-8 symbols even if locale detection reports ASCII.

---

## Essential In-App Keyboard Shortcuts

Navigate `btop` effortlessly with your keyboard or mouse:

| Key | Action |
|:---:|--------|
| **`m`** or **`Esc`** | Open main menu (Options, Help, Themes, Quit) |
| **`q`** | Instantly quit btop |
| **`Up` / `Down`** | Scroll through the running process list |
| **`f`** | Filter / search processes by name (press `Enter` to confirm, `Esc` to clear) |
| **`t`** | Toggle process **Tree View** (visualize parent and child processes) |
| **`k`** | Send `SIGKILL` (-9) to force-kill the highlighted runaway process |
| **`s`** | Send custom termination signals (`SIGTERM`, `SIGHUP`, `SIGINT`) |
| **`+` / `-`** | Increase or decrease refresh interval speed (100ms to 2000ms) |
| **`1` / `2` / `3` / `4`** | Toggle display of CPU, Memory, Disks, or Processes panels |

---

## Understanding System Metrics

### 1. Load Average (1m, 5m, 15m)
Displayed at the top of the CPU box:
- Represents the average number of processes actively using or waiting for CPU time over 1, 5, and 15 minutes.
- On an 8-core CPU, a load average below `8.0` means the system has surplus capacity. A load average of `16.0` means tasks are queued up and waiting.

### 2. RAM vs. Buffers / Cache
Linux aggressively uses free RAM to cache disk reads (`Cached`). If btop shows high memory usage but low swap, do not panic! Linux automatically reclaims cached RAM the millisecond an application requests it.

### 3. Swap Usage
If swap usage is rising alongside high disk I/O, the system is low on physical RAM and thrashing the disk.
