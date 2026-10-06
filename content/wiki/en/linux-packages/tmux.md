---
title: tmux — Terminal Multiplexer for Persistent SSH Sessions
description: Manage multiple terminal windows and split panes inside a single window, and keep long-running commands alive across SSH disconnects.
category: linux-packages
order: 30
tags: [tmux, terminal, ssh, sysadmin, linux]
updated: 2026-10-06
related: [linux/ssh-hardening, linux/systemd-services-timers]
---

## Why use tmux?

When working over SSH, closing your laptop or losing network connection normally terminates all processes running in your shell. `tmux` runs as a persistent server process in the background. If you disconnect, your shell sessions, text editors, and running build scripts continue unharmed.

## Installation

```bash
sudo apt install -y tmux
```

## Starting and Managing Sessions

Create a named session:

```bash
tmux new -s dev
```

Detach from the session without stopping it:

Press `Ctrl+b`, release, then press `d`.

List active sessions:

```bash
tmux ls
```

Reattach to an existing session:

```bash
tmux attach -t dev
```

## Essential Split and Navigation Shortcuts

All default tmux commands start with the prefix `Ctrl+b`:

| Shortcut | Description |
| --- | --- |
| `Ctrl+b %` | Split pane vertically (left / right) |
| `Ctrl+b "` | Split pane horizontally (top / bottom) |
| `Ctrl+b Arrow` | Switch focus between panes |
| `Ctrl+b c` | Create a new window |
| `Ctrl+b n` | Switch to next window |
| `Ctrl+b p` | Switch to previous window |
| `Ctrl+b [` | Enter scrollback / copy mode (press `q` to exit) |
| `Ctrl+b d` | Detach safely from session |

:::tip
Create `~/.tmux.conf` and add `set -g mouse on` to enable mouse scrolling, pane resizing, and clicking between splits.
:::
