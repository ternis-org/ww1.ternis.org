---
title: tmux — Terminal Multiplexer for Persistent SSH Sessions
description: Complete beginner guide to tmux, managing persistent sessions across SSH disconnects, splitting terminal panes, keyboard shortcuts, and configuration.
category: linux-packages
order: 30
tags: [tmux, terminal, ssh, sysadmin, linux, devops]
updated: 2026-10-06
related: [linux/ssh-hardening, linux/systemd-services-timers, linux-packages/btop]
---

## Why tmux is a sysadmin lifesaver

When connected to a remote server over SSH, closing your laptop, experiencing Wi-Fi drops, or switching networks immediately kills your active shell session. Any long-running script, database migration, or system compilation running in that terminal is abruptly terminated.

**`tmux` (Terminal Multiplexer)** solves this by running as a persistent background daemon:
1. **Persistent Sessions**: Disconnecting from SSH does not terminate your processes; programs continue running on the server.
2. **Terminal Tiling**: Split a single terminal window into multiple horizontal and vertical panes.
3. **Multi-Window Navigation**: Switch between full-screen virtual terminal tabs inside a single SSH connection.

---

## Installation

On Debian, Ubuntu, or Raspberry Pi OS:

```bash
sudo apt update
sudo apt install -y tmux
```

---

## 1. Managing Sessions: Commands & Flags Breakdown

```bash
# 1. Start a brand new session with a memorable name
tmux new -s dev

# 2. List all active background sessions
tmux ls

# 3. Reattach to an existing session
tmux attach -t dev

# 4. Terminate a session completely
tmux kill-session -t dev
```

### Command & flag breakdown

- `new -s <name>`: Creates a new session. The `-s` flag assigns a custom human-readable name (e.g. `dev`, `backup`, `deploy`) instead of a random number.
- `ls`: Lists all currently running tmux sessions, showing the number of windows, creation date, and attached/detached status.
- `attach -t <name>`: Re-attaches your terminal to a background session. The `-t` flag specifies the target session name.
- `kill-session -t <name>`: Shuts down the specified session and gracefully terminates its child shell processes.

---

## 2. Detaching safely: Keep programs running

To disconnect from a running session without killing your programs:

1. Press **`Ctrl + b`**, release both keys.
2. Press **`d`** (detach).

You are returned to your normal shell prompt with the message `[detached (from session dev)]`. You can now safely close your terminal, shut down your laptop, or disconnect SSH.

When you log back in later, simply type:

```bash
tmux attach -t dev
```

Everything will be exactly where you left it!

---

## 3. Essential Keyboard Shortcuts

Inside tmux, all commands begin with the default **prefix key**: **`Ctrl + b`**. Press the prefix first, release it, and then press the action key:

### Managing Panes (Splits)

| Shortcut | Action |
|----------|--------|
| `Ctrl+b` then `%` | Split current pane vertically (left and right) |
| `Ctrl+b` then `"` | Split current pane horizontally (top and bottom) |
| `Ctrl+b` then `Arrow Key` | Move cursor focus to an adjacent pane |
| `Ctrl+b` then `z` | Zoom (toggle full-screen for active pane) |
| `Ctrl+b` then `x` | Close / kill active pane (prompts for confirmation) |

### Managing Windows (Tabs)

| Shortcut | Action |
|----------|--------|
| `Ctrl+b` then `c` | Create a brand new window |
| `Ctrl+b` then `n` | Switch to the next window |
| `Ctrl+b` then `p` | Switch to the previous window |
| `Ctrl+b` then `0–9` | Jump directly to window number |
| `Ctrl+b` then `,` | Rename the current window |

### Scrolling & Copy Mode

Terminal output in tmux doesn't scroll with your mouse wheel by default:
- Press **`Ctrl+b` then `[`** to enter scroll mode.
- Use arrow keys or `Page Up` / `Page Down` to scroll through historical logs.
- Press **`q`** to exit scroll mode and return to your live terminal prompt.

---

## 4. Enabling Mouse Support in `~/.tmux.conf`

Create a configuration file at `~/.tmux.conf` to enable mouse clicking between splits, drag-to-resize panes, and mouse wheel scrolling:

```bash
cat << 'EOF' > ~/.tmux.conf
# Enable full mouse control (clicking panes, scrolling, resizing)
set -g mouse on

# Increase scrollback history buffer to 10,000 lines
set -g history-limit 10000

# Use 256 colors
set -g default-terminal "screen-256color"
EOF
```

Reload the configuration inside tmux:
Press **`Ctrl+b` then `:`**, type `source-file ~/.tmux.conf`, and press `Enter`.
