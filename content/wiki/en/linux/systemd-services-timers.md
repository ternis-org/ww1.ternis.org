---
title: systemd Services and Timers — systemctl Survival Guide
description: Writing unit files, reading status output, and replacing cron with timers.
category: linux
order: 15
tags: [linux, systemd, services, timers]
updated: 2026-10-06
related: [linux/filesystem-permissions, linux/ssh-hardening]
---

## The daily commands

```bash
systemctl status myapp
systemctl enable --now myapp
journalctl -u myapp -f
systemctl restart myapp
```

`enable --now` persists across reboots *and* starts immediately — the two
things beginners most often do separately and then forget one.

## A minimal unit

```ini
# /etc/systemd/system/myapp.service
[Unit]
Description=My app
After=network-online.target

[Service]
User=app
WorkingDirectory=/opt/myapp
ExecStart=/opt/myapp/bin/server
Restart=on-failure

[Install]
WantedBy=multi-user.target
```

```bash
systemctl daemon-reload
systemctl enable --now myapp
```

## Timers beat cron

Timers get logging, dependencies, andCalendar expressions for free:

```ini
# /etc/systemd/system/backup.timer
[Unit]
Description=Nightly backup

[Timer]
OnCalendar=daily
Persistent=true

[Install]
WantedBy=timers.target
```

Pair with a same-named `backup.service`. Check everything with
`systemctl list-timers`.

:::tip
`Restart=on-failure` plus `journalctl -u` is 90% of production resilience for
small services. Add alerting (Uptime Kuma, healthchecks) only after this works.
:::
