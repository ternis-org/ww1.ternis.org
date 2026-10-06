---
title: Lynx — Textbasierter Webbrowser für Terminal & SEO-Prüfung
description: Webseiten direkt im Linux-Terminal mit Lynx aufrufen, um Semantik, robots.txt und Barrierefreiheit ohne JavaScript zu prüfen.
category: linux-packages
order: 80
tags: [lynx, browser, terminal, seo, linux, accessibility]
updated: 2026-10-06
related: [linux-packages/curl, dns/debugging-dig-host-nslookup]
---

## Was ist Lynx?

`Lynx` ist der älteste bis heute gepflegte Webbrowser der Welt. Er läuft vollständig im Text-Terminal und verzichtet auf Grafiken, CSS-Layouts und JavaScript. Dadurch eignet er sich hervorragend, um zu überprüfen, wie Suchmaschinen-Crawler (wie der Googlebot) deine HTML-Struktur, Überschriften und Links erfassen.

## Installation

```bash
# Ubuntu / Debian
sudo apt update
sudo apt install -y lynx

# Fedora
sudo dnf install -y lynx

# Arch Linux
sudo pacman -S lynx
```

## Navigation im Terminal

Webseite aufrufen:

```bash
lynx https://ternis.org
```

Wichtige Tasten:

| Taste | Aktion |
| --- | --- |
| `Pfeil oben` / `unten` | Vorherigen / nächsten Link anspringen |
| `Pfeil rechts` / `Enter` | Link aufrufen |
| `Pfeil links` | Zurück im Verlauf |
| `g` | Neue URL eingeben |
| `\` | Quelltext anzeigen |
| `q` | Lynx beenden |

## Text-Ausgabe für SEO-Checks (`-dump`)

Mit `-dump` kannst du den Text einer Seite direkt auf die Standardausgabe leiten:

```bash
lynx -dump https://ternis.org/de/wiki
```

Damit lässt sich in Sekunden prüfen, ob alle wesentlichen Inhalte auch ohne JavaScript lesbar sind.
