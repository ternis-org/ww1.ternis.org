---
title: screenfetch — System-Informationen und ASCII-Logo im Terminal
description: Distributions-Logo, Kernel-Version, Uptime, RAM und Hardware-Daten im Terminal oder als Willkommens-Banner bei SSH-Logins anzeigen.
category: linux-packages
order: 70
tags: [screenfetch, terminal, sysadmin, linux, motd]
updated: 2026-10-06
related: [linux-packages/btop, linux/filesystem-permissions]
---

## Was ist screenfetch?

`screenfetch` ist ein beliebtes Tool für Screenshots und Systemübersichten im Terminal. Es erkennt die laufende Linux-Distribution automatisch, gibt das offizielle Logo als farbige ASCII-Art aus und fasst Kernel, Betriebszeit, Paketanzahl, Shell, Auflösung und RAM-Auslastung übersichtlich zusammen.

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

## Aufruf und Optionen

Befehl starten:

```bash
screenfetch
```

Nützliche Optionen:

| Option | Beschreibung |
| --- | --- |
| `-v` | Ausführliche Diagnose der Hardware-Erkennung |
| `-N` | Farbcodes deaktivieren |
| `-D 'Debian'` | Bestimmtes Distributionslogo erzwingen |
| `-s` | Screenshot nach der Ausgabe erstellen |

## Als SSH-Willkommensbanner einrichten

Um bei jedem SSH-Login automatisch eine Systemübersicht zu sehen, lege eine Skriptdatei in `/etc/profile.d/` ab:

```bash
echo "screenfetch" | sudo tee /etc/profile.d/motd-specs.sh
sudo chmod +x /etc/profile.d/motd-specs.sh
```
