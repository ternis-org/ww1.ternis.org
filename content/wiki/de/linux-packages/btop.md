---
title: btop — Moderner Terminal-Ressourcen-Monitor
description: Einsteigerfreundlicher Leitfaden zu btop, CPU-Kerne, Arbeitsspeicher, Swap, Festplatten-I/O und Netzwerk-Bandbreite im Linux-Terminal überwachen und Prozesse beenden.
category: linux-packages
order: 20
tags: [btop, monitoring, linux, sysadmin, terminal, performance]
updated: 2026-10-06
related: [linux/systemd-services-timers, homelab/proxmox-getting-started, linux-packages/tmux]
---

## Was ist btop?

Wenn ein Server träge reagiert oder die CPU-Last steigt, ist das klassische Tool `top` oft unübersichtlich.

**`btop`** (in C++ entwickelt) ist ein hochperformanter, visueller Ressourcen-Monitor für das Terminal. Er visualisiert in Echtzeit:
1. **CPU-Auslastung**: Auslastungsgrafiken pro CPU-Kern, Taktraten, Temperaturen und Load-Average.
2. **Arbeitsspeicher & Swap**: Tatsächlicher RAM-Verbrauch, Caching-Puffer und Swap-Auslastung.
3. **Festplatten & Datenträger-I/O**: Lese- und Schreibgeschwindigkeiten sowie freier Speicherplatz.
4. **Netzwerk**: Upload- und Download-Geschwindigkeiten mit grafischem Verlauf.
5. **Interaktive Prozessliste**: Suche, Baumansicht (Tree-View) und gezieltes Beenden abgestürzter Prozesse.

---

## Installation

```bash
# Ubuntu / Debian
sudo apt update && sudo apt install -y btop

# Fedora
sudo dnf install -y btop

# Arch Linux
sudo pacman -S btop
```

---

## Bedienung und nützliche Start-Flags

```bash
# btop starten
btop

# Mit Layout-Preset 1 starten (z. B. kompakte Ansicht)
btop -p 1

# Im 16-Farben-Modus starten (für einfache Terminalemulatoren)
btop --low-color
```

### Die wichtigsten Tastaturkürzel

| Taste | Aktion |
|:-----:|--------|
| **`m`** oder **`Esc`** | Hauptmenü öffnen (Optionen, Themes, Beenden) |
| **`q`** | btop sofort beenden |
| **`Pfeiltasten`** | Durch laufende Prozesse navigieren |
| **`f`** | Prozesse nach Namen filtern / durchsuchen |
| **`t`** | Prozess-Baumansicht (Tree-View) umschalten |
| **`k`** | Prozess sofort mit `SIGKILL` (-9) beenden |
| **`+` / `-`** | Aktualisierungsintervall anpassen |
| **`1` bis `4`** | CPU-, Speicher-, Festplatten- oder Prozessbereich ein-/ausblenden |

---

## Systemwerte richtig interpretieren

- **Load Average**: Zeigt die durchschnittliche Anzahl aktiver oder wartender Prozesse über 1, 5 und 15 Minuten. Bei einer 4-Kern-CPU bedeutet ein Wert unter `4.0`, dass noch freie Reserven vorhanden sind.
- **Buffers / Cached RAM**: Linux nutzt ungenutzten RAM automatisch als Cache für Festplattenzugriffe. Wenn btop viel "Cached RAM" anzeigt, ist das völlig normal und kein Engpass!
