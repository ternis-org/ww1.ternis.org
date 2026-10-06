---
title: tmux — Terminal-Multiplexer für persistente SSH-Sitzungen
description: Einsteigerfreundlicher Leitfaden zu tmux, SSH-Sitzungen vor Verbindungsabbrüchen schützen, Fenster teilen und Tastaturkürzel beherrschen.
category: linux-packages
order: 30
tags: [tmux, terminal, ssh, sysadmin, linux, devops]
updated: 2026-10-06
related: [linux/ssh-hardening, linux/systemd-services-timers, linux-packages/btop]
---

## Warum tmux für jeden Administrator Pflicht ist

Wenn du per SSH auf einem Server arbeitest und dein WLAN abbricht oder du den Laptop zuklappst, wird die SSH-Verbindung sofort gekappt. Alle im Terminal laufenden Programme, Builds und Skripte brechen unweigerlich ab.

**`tmux` (Terminal Multiplexer)** läuft als Hintergrunddienst auf dem Server:
1. **Dauerhafte Sitzungen**: Verbindungsabbrüche beenden deine Programme nicht; sie laufen auf dem Server nahtlos weiter.
2. **Geteilte Fenster (Splits)**: Teile dein Terminalfenster horizontal und vertikal in mehrere Bereiche auf.
3. **Mehrere virtuelle Fenster (Tabs)**: Wechsle zwischen Vollbild-Fenstern innerhalb einer einzigen SSH-Verbindung.

---

## Installation

```bash
sudo apt update && sudo apt install -y tmux
```

---

## 1. Sitzungen verwalten: Befehle & Flags

```bash
# 1. Neue Sitzung mit sprechendem Namen starten
tmux new -s dev

# 2. Alle laufenden Hintergrundsitzungen auflisten
tmux ls

# 3. Zu einer bestehenden Sitzung zurückkehren
tmux attach -t dev

# 4. Eine Sitzung komplett beenden
tmux kill-session -t dev
```

### Erklärung der Flags

- `new -s <name>`: Startet eine neue Session. `-s` vergibt einen lesbaren Namen (z. B. `dev`, `backup`).
- `ls`: Listet alle aktiven Sessions mit Fensteranzahl und Zeitstempel auf.
- `attach -t <name>`: Verbindet das Terminal wieder mit der Session. `-t` bestimmt den Zielnamen.
- `kill-session -t <name>`: Beendet die angegebene Session mitsamt allen Unterprozessen.

---

## 2. Die Sitzung sicher verlassen (Detachen)

Um eine Sitzung zu verlassen, ohne deine laufenden Programme zu beenden:

1. Drücke **`Strg + b`**, lasse beide Tasten los.
2. Drücke **`d`** (detach).

Du landest wieder in deiner regulären Shell mit der Meldung `[detached]`. Du kannst nun die SSH-Verbindung schließen. Wenn du dich später wieder einloggst:

```bash
tmux attach -t dev
```

Alles ist exakt an dem Punkt, an dem du es verlassen hast!

---

## 3. Die wichtigsten Tastaturkürzel

Alle Befehle beginnen mit dem Standard-Präfix **`Strg + b`**:

### Bereiche teilen (Panes)

| Tastenkürzel | Aktion |
|--------------|--------|
| `Strg+b` dann `%` | Bereich vertikal teilen (links / rechts) |
| `Strg+b` dann `"` | Bereich horizontal teilen (oben / unten) |
| `Strg+b` dann `Pfeiltaste` | Fokus auf benachbarten Bereich wechseln |
| `Strg+b` dann `z` | Zoom (aktiven Bereich auf Vollbild vergrößern/verkleinern) |
| `Strg+b` dann `x` | Aktiven Bereich schließen |

### Fenster (Tabs)

| Tastenkürzel | Aktion |
|--------------|--------|
| `Strg+b` dann `c` | Neues Vollbild-Fenster erstellen |
| `Strg+b` dann `n` | Zum nächsten Fenster wechseln |
| `Strg+b` dann `p` | Zum vorherigen Fenster wechseln |

### Scrollen im Verlauf

- Drücke **`Strg+b` dann `[`**, um den Scroll-Modus zu aktivieren.
- Mit den Pfeiltasten oder `Bild auf`/`Bild ab` im Verlauf blättern.
- Mit **`q`** den Scroll-Modus beenden.

---

## 4. Mausunterstützung aktivieren in `~/.tmux.conf`

```bash
cat << 'EOF' > ~/.tmux.conf
set -g mouse on
set -g history-limit 10000
set -g default-terminal "screen-256color"
EOF
```
