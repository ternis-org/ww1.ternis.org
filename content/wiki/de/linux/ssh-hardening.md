---
title: SSH-Hardening — Keys, Konfiguration, Fail2ban
description: Login nur mit Keys, gehärtete sshd_config und Brute-Force-Schutz für jeden Linux-Server.
category: linux
order: 10
tags: [linux, ssh, security, hardening]
updated: 2026-10-06
related: [ubuntu/ufw-basics]
---

## Keys nutzen, Passwörter deaktivieren

```bash
ssh-keygen -t ed25519 -C "du@example.com"
ssh-copy-id benutzer@server
```

Danach in `/etc/ssh/sshd_config`:

```text
PasswordAuthentication no
PermitRootLogin no
PubkeyAuthentication yes
```

Mit `sudo systemctl restart ssh` neu starten und die **aktuelle Sitzung offen
lassen**, bis ein zweiter Login nachweislich funktioniert.

## Daemon härten

```text
Port 22
MaxAuthTries 3
LoginGraceTime 30
X11Forwarding no
AllowUsers deploy
```

:::warn
Ein geänderter SSH-Port ist Tarnung, keine Sicherheit. Echter Schutz kommt aus
Keys plus Firewall plus fail2ban — nicht aus dem Verstecken auf Port 2222.
:::

## Fail2ban dazu

```bash
sudo apt install fail2ban
sudo systemctl enable --now fail2ban
sudo fail2ban-client status sshd
```

## Prüfen

1. `ssh -o PreferredAuthentications=password benutzer@server` muss scheitern.
2. `sudo journalctl -u ssh --since today` zeigt nur Key-Logins.
3. Root-Login per SSH wird verweigert.
