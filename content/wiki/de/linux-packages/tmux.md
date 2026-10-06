---
title: tmux — Terminal-Multiplexer für dauerhafte SSH-Sitzungen
description: Mehrere Terminals in einem Fenster verwalten, Splits erstellen und Befehle bei SSH-Verbindungsabbrüchen dauerhaft im Hintergrund weiterlaufen lassen.
category: linux-packages
order: 30
tags: [tmux, terminal, ssh, sysadmin, linux]
updated: 2026-10-06
related: [linux/ssh-hardening, linux/systemd-services-timers]
---

## Warum tmux unverzichtbar ist

Wenn du über SSH arbeitest und das WLAN abbricht oder der Laptop zugeklappt wird, sterben alle im Terminal laufenden Programme. `tmux` läuft als dauerhafter Prozess im Hintergrund. Du kannst dich jederzeit trennen und später exakt an derselben Stelle wieder einsteigen.

## Installation

```bash
sudo apt install -y tmux
```

## Sitzungen erstellen und steuern

Neue benannte Sitzung starten:

```bash
tmux new -s dev
```

Sitzung verlassen (trennen), ohne sie zu beenden:

Drücke `Strg+b`, lasse los, und drücke dann `d`.

Alle laufenden Sitzungen auflisten:

```bash
tmux ls
```

Wieder mit einer Sitzung verbinden:

```bash
tmux attach -t dev
```

## Wichtige Tastenkombinationen

Alle Standard-Befehle beginnen mit dem Prefix `Strg+b`:

| Tastenkürzel | Funktion |
| --- | --- |
| `Strg+b %` | Bereich vertikal teilen (links / rechts) |
| `Strg+b "` | Bereich horizontal teilen (oben / unten) |
| `Strg+b Pfeiltaste` | Zwischen Bereichen wechseln |
| `Strg+b c` | Neues Fenster anlegen |
| `Strg+b n` / `p` | Nächstes / vorheriges Fenster |
| `Strg+b d` | Sicher von der Sitzung trennen |

:::tip
Schreibe `set -g mouse on` in deine `~/.tmux.conf`, um Maus-Scrolling und Klicks zwischen Bereichen zu aktivieren.
:::
