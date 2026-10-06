---
title: btop — Moderner visueller Ressourcen-Monitor im Terminal
description: CPU, RAM, Datenträger, Netzwerkauslastung und Prozesse mit dem visuellen und flüssigen btop-Monitor im Linux-Terminal überwachen.
category: linux-packages
order: 20
tags: [btop, monitoring, linux, sysadmin, terminal]
updated: 2026-10-06
related: [linux/systemd-services-timers, homelab/proxmox-getting-started]
---

## Was ist btop?

`btop` (der in C++ geschriebene Nachfolger von `bpytop` und `bashtop`) ist ein schneller, interaktiver Ressourcen-Monitor für die Kommandozeile. Er visualisiert CPU-Kerne, Arbeitsspeicher, Swap, Festplatten-I/O, Netzwerk-Durchsatz und die laufenden Prozesse mit hochauflösenden Graphen.

## Installation

Auf modernen Linux-Distributionen:

```bash
# Ubuntu / Debian
sudo apt install -y btop

# Fedora
sudo dnf install -y btop

# Arch Linux
sudo pacman -S btop
```

## Bedienung und Tastenkürzel

Monitor starten:

```bash
btop
```

Wichtige Tasten im Betrieb:

| Taste | Aktion |
| --- | --- |
| `Esc` oder `m` | Hauptmenü & Optionen öffnen |
| `q` | btop beenden |
| `Pfeiltasten` | Prozesse auswählen |
| `k` | Prozess beenden (`SIGKILL`) |
| `t` | Prozessbaum-Ansicht ein-/ausschalten |
| `f` | Prozesse nach Name filtern |
| `+` / `-` | Aktualisierungsrate anpassen |

:::tip
Über `m` > **Options > Color theme** kannst du Farbschemata wie Nord, Dracula oder Gruvbox direkt im Terminal auswählen.
:::
