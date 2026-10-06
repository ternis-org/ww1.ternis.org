---
title: systemd Services and Timers — systemctl Survival Guide
description: Complete beginner guide to managing Linux background services, writing custom systemd unit files, viewing journalctl logs, and replacing cron with timers.
category: linux
order: 15
tags: [linux, systemd, services, timers, systemctl, journalctl, sysadmin]
updated: 2026-10-06
related: [linux/filesystem-permissions, linux/ssh-hardening, selfhosting/nginx-reverse-proxy-tls]
---

## What is systemd?

**systemd** is the modern init system and service manager for virtually all major Linux distributions (Ubuntu, Debian, Fedora, Arch, RHEL, CentOS). As process ID 1 (`PID 1`), it is the very first process launched by the Linux kernel during system boot.

systemd is responsible for:
- Initializing hardware, network, and storage during boot.
- Starting, stopping, and restarting background daemons and applications.
- Monitoring processes and automatically restarting them if they crash.
- Managing timed scheduled tasks (via systemd timers, replacing legacy cron).
- Aggregating centralized logs via `journald`.

---

## Daily service management commands

To control background services, you use the `systemctl` utility:

```bash
# Check if a service is running and view recent logs
sudo systemctl status nginx

# Start and enable a service on boot in a single command
sudo systemctl enable --now nginx

# Restart a service
sudo systemctl restart nginx

# Gracefully reload configuration without dropping connections
sudo systemctl reload nginx

# Stop and prevent service from starting on boot
sudo systemctl disable --now nginx
```

### Command & flag breakdown

- `status <service>`: Displays active/inactive state, Main PID, memory usage, CPU time, and the latest few lines of log output.
- `enable`: Configures the service to launch automatically when the computer boots up (creates a symlink in `/etc/systemd/system/`).
- `--now`: A powerful flag that performs the action immediately in addition to the enable/disable state. `enable --now` enables on boot **and** starts the process right away without needing a separate `systemctl start` command.
- `restart`: Completely stops and starts the process.
- `reload`: Tells the process to re-read its configuration files without dropping existing network sockets.

---

## Viewing live logs with `journalctl`

systemd captures `stdout` and `stderr` output from all services into an indexed binary journal:

```bash
# Follow live incoming logs in real time
sudo journalctl -u nginx -f

# View the last 50 log lines
sudo journalctl -u nginx -n 50 --no-pager

# View logs generated today
sudo journalctl -u nginx --since today
```

### Command & flag breakdown

- `journalctl`: Queries the systemd logging daemon (`systemd-journald`).
- `-u <unit>`: Filters log output to only the specified systemd unit/service.
- `-f` (follow): Continuously streams new log lines as they appear (identical to `tail -f`). Press `Ctrl+C` to exit.
- `-n <lines>`: Number of recent log lines to display (defaults to 10).
- `--no-pager`: Prints output directly to the terminal without piping into `less`.
- `--since today`: Filters entries to only those recorded since midnight of the current day.

---

## Writing your own custom service

Suppose you have a custom web application or Python/Node.js script located at `/opt/myapp/server.py`. You can turn it into a managed background daemon by creating a unit file at `/etc/systemd/system/myapp.service`:

```ini
[Unit]
Description=My Custom Backend Web App
After=network-online.target
Wants=network-online.target

[Service]
Type=simple
User=www-data
Group=www-data
WorkingDirectory=/opt/myapp
ExecStart=/usr/bin/python3 /opt/myapp/server.py
Restart=on-failure
RestartSec=5s
Environment=PORT=8080
Environment=NODE_ENV=production

[Install]
WantedBy=multi-user.target
```

### Unit directives breakdown

- `[Unit]`: General metadata and dependencies.
  - `Description`: Human-readable label shown in logs and status listings.
  - `After=network-online.target`: Ensures systemd waits until network connectivity is fully up before launching this service.
- `[Service]`: Execution parameters and behavior.
  - `Type=simple`: The default process model; systemd considers the service started as soon as `ExecStart` is spawned.
  - `User` / `Group`: Drops root privileges and runs the process under an unprivileged user (e.g. `www-data`) for security.
  - `WorkingDirectory`: The current working folder where relative file paths in your script resolve.
  - `ExecStart`: Full absolute path to the executable and its arguments.
  - `Restart=on-failure`: Automatically restarts the process if it exits with an error or is terminated by a signal.
  - `RestartSec=5s`: Waits 5 seconds before attempting to restart a failed process.
  - `Environment`: Defines environment variables passed to the process.
- `[Install]`:
  - `WantedBy=multi-user.target`: Standard target for non-graphical multi-user system boot.

---

## Activating your custom service

Whenever you create or modify any unit file in `/etc/systemd/system/`, inform systemd of the changes:

```bash
# 1. Reload systemd unit configuration cache
sudo systemctl daemon-reload

# 2. Enable and start your new service
sudo systemctl enable --now myapp.service

# 3. Check health and status
sudo systemctl status myapp.service
```

### Command & flag breakdown

- `daemon-reload`: Reloads all systemd unit files from disk and reconstructs dependency trees. If you edit a `.service` file without running `daemon-reload`, systemd will warn you and use the old cached version.

---

## Timers: Replacing cron with systemd timers

Instead of opaque cron jobs, systemd timers provide unified logging, dependency management, and missed-run recovery.

A timer consists of two files:
1. A service file (e.g. `/etc/systemd/system/backup.service`): defines **what** runs.
2. A timer file (e.g. `/etc/systemd/system/backup.timer`): defines **when** it runs.

Example `/etc/systemd/system/backup.timer`:

```ini
[Unit]
Description=Nightly Database Backup Timer

[Timer]
OnCalendar=*-*-* 03:00:00
Persistent=true

[Install]
WantedBy=timers.target
```

### Timer directives breakdown

- `OnCalendar=*-*-* 03:00:00`: Runs every night at 3:00 AM (syntax: `DayOfWeek Year-Month-Day Hour:Minute:Second`). Shortcuts like `daily` or `weekly` are also supported.
- `Persistent=true`: If the server was powered off when the timer was scheduled to trigger, it runs the missed job immediately upon next boot.

Enable and monitor timers:

```bash
sudo systemctl daemon-reload
sudo systemctl enable --now backup.timer
systemctl list-timers
```

### Command & flag breakdown

- `list-timers`: Displays a table of all scheduled timers, showing the next trigger time, how long until execution, and when they last ran.
