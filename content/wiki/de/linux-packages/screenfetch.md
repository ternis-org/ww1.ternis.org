---
title: screenfetch — Systeminformationen & ASCII-Art im Terminal
description: Einsteigerfreundlicher Leitfaden zu screenfetch, Linux-Distributionslogos in ASCII-Art, Hardware-Spezifikationen und SSH-MOTD-Begrüßungsbanner.
category: linux-packages
order: 70
tags: [screenfetch, terminal, sysadmin, linux, motd, cli, hardware]
updated: 2026-10-06
related: [linux-packages/btop, linux/filesystem-permissions, linux/ssh-hardening]
---

## Was ist screenfetch?

**`screenfetch`** ist das klassische Tool zur Anzeige von Systeminformationen und ASCII-Art im Terminal.

Beim Aufruf erkennt es automatisch die Linux-Distribution und zeigt auf der linken Seite das offizielle Logo als farbige ASCII-Grafik an, während rechts wichtige System- und Hardwaredaten gelistet werden:
- Benutzer und Hostname
- Betriebssystem und Versionsstand
- Linux-Kernel-Version
- Uptime (Laufzeit seit dem letzten Systemstart)
- Installierte Softwarepakete (APT, DNF, Pacman)
- Aktive Shell (Bash, Zsh)
- CPU-Modell und Kernanzahl
- RAM-Auslastung

---

## Installation

```bash
# Ubuntu / Debian
sudo apt update && sudo apt install -y screenfetch

# Fedora
sudo dnf install -y screenfetch

# Arch Linux
sudo pacman -S screenfetch
```

---

## Befehle & Flags im Überblick

```bash
# Standardaufruf
screenfetch

# Ohne Farben ausgeben (für Textdateien)
screenfetch -N

# Bestimmtes Distributionslogo erzwingen
screenfetch -D 'Debian'

# Detaillierte Erkennungsschritte anzeigen
screenfetch -v
```

### Erklärung der Flags

- `-N`: Entfernt ANSI-Farbcodes aus der Ausgabe.
- `-D '<Name>'`: Zeigt das ASCII-Logo einer gewünschten Distribution an.
- `-v`: Verbose-Modus mit internen Debug-Meldungen.

---

## Automatische SSH-Begrüßung (MOTD) einrichten

Um bei jedem SSH-Login automatisch mit den Server-Spezifikationen begrüßt zu werden:

```bash
echo "screenfetch" | sudo tee /etc/profile.d/motd-screenfetch.sh
sudo chmod 755 /etc/profile.d/motd-screenfetch.sh
```

Skripte im Verzeichnis `/etc/profile.d/` werden bei jeder interaktiven Login-Shell automatisch ausgeführt.
