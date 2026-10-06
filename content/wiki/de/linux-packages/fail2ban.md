---
title: Fail2ban — SSH und Webdienste vor Brute-Force schützen
description: Fail2ban installieren, konfigurieren und betreiben, um bösartige IP-Adressen nach fehlgeschlagenen Anmeldeversuchen automatisch zu sperren.
category: linux-packages
order: 10
tags: [fail2ban, security, linux, ssh, ufw, firewalls]
updated: 2026-10-06
related: [linux/ssh-hardening, ubuntu/ufw-basics]
---

## Wie Fail2ban funktioniert

Fail2ban überwacht Logdateien (wie `/var/log/auth.log` oder das systemd-Journal) auf wiederholte fehlgeschlagene Login-Versuche. Sobald eine IP-Adresse das konfigurierte Limit überschreitet, fügt Fail2ban automatisch eine Sperr-Regel in die Firewall ein (`nftables`, `iptables` oder `ufw`).

## Installation

Unter Debian, Ubuntu oder Raspberry Pi OS:

```bash
sudo apt update
sudo apt install -y fail2ban
sudo systemctl enable --now fail2ban
```

## Konfiguration mit jail.local

Bearbeite niemals `/etc/fail2ban/jail.conf` direkt, da Paket-Updates diese Datei überschreiben. Erstelle stattdessen immer eine `/etc/fail2ban/jail.local`:

```bash
sudo cp /etc/fail2ban/jail.conf /etc/fail2ban/jail.local
```

Passe die Standardparameter in `/etc/fail2ban/jail.local` an:

```ini
[DEFAULT]
bantime  = 1h
findtime = 10m
maxretry = 5
ignoreip = 127.0.0.1/8 ::1 192.168.1.0/24

[sshd]
enabled = true
port    = 22
mode    = aggressive
```

:::tip
Trage immer dein eigenes lokales Netzwerk oder deine VPN-IPs in `ignoreip` ein, um dich nicht versehentlich selbst auszusperren.
:::

## Die wichtigsten Befehle

Status aller aktiven Jails abrufen:

```bash
sudo fail2ban-client status
```

Details zu einem bestimmten Jail (z. B. `sshd`) anzeigen:

```bash
sudo fail2ban-client status sshd
```

Versehentlich gesperrte IP-Adresse wieder entsperren:

```bash
sudo fail2ban-client set sshd unbanip 203.0.113.42
```

Dauerhaften Angreifer manuell sperren:

```bash
sudo fail2ban-client set sshd banip 203.0.113.42
```
