---
title: Lynx — Textbasierter Webbrowser für Terminal & SEO-Audits
description: Einsteigerfreundlicher Leitfaden zu Lynx, Webseiten rein im Textmodus betrachten, HTML-Semantik und Barrierefreiheit prüfen und CLI-Dump-Flags für SEO.
category: linux-packages
order: 80
tags: [lynx, browser, terminal, seo, linux, barrierefreiheit, sysadmin]
updated: 2026-10-06
related: [linux-packages/curl, dns/debugging-dig-host-nslookup, css/layout-grid-flexbox]
---

## Was ist Lynx?

**Lynx** ist der älteste Webbrowser, der noch aktiv gepflegt wird (entwickelt ab 1992 an der University of Kansas).

Er läuft vollständig im Terminal ohne CSS-Stylesheets, Bilder oder JavaScript auszuführen. Für Entwickler und SEO-Experten ist Lynx dennoch ein mächtiges Werkzeug:
1. **Der Blick von Suchmaschinen-Crawlern**: Suchmaschinen wie Googlebot lesen primär den semantischen HTML-Text. Lynx zeigt dir ungeschönt, was ein Crawler sieht.
2. **Barrierefreiheit (Accessibility)**: Simuliert die Erfahrung sehbehinderter Nutzer mit Screenreadern.
3. **Dokumentation auf Headless-Servern**: Webseiten und Handbücher direkt auf einem Server ohne Desktop-Umgebung lesen.

---

## Installation

```bash
# Ubuntu / Debian
sudo apt update && sudo apt install -y lynx

# Fedora
sudo dnf install -y lynx

# Arch Linux
sudo pacman -S lynx
```

---

## 1. Interaktives Surfen im Terminal

```bash
lynx https://ternis.org
```

### Die wichtigsten Tastaturkürzel

| Taste | Aktion |
|:-----:|--------|
| **`Pfeil oben` / `unten`** | Zum vorherigen / nächsten Link springen |
| **`Pfeil rechts`** oder **`Enter`** | Ausgewählten Link öffnen |
| **`Pfeil links`** | Zurück zur vorherigen Seite in der Historie |
| **`Leertaste`** / **`b`** | Seite nach unten / oben scrollen |
| **`g`** | Neue URL-Adresse eingeben |
| **`\`** | HTML-Quellcode der aktuellen Seite anzeigen |
| **`q`** | Lynx beenden (mit `y` bestätigen) |

---

## 2. Text-Dump für automatisierte SEO-Audits

Lynx kann Webseiten ohne grafische Oberfläche direkt auf der Konsole ausgeben:

```bash
# 1. Gerenderten Text auf stdout ausgeben
lynx -dump https://ternis.org/de/wiki

# 2. Ausschließlich alle verlinkten URLs auflisten
lynx -dump -listonly https://ternis.org/de/wiki

# 3. HTTP-Header einsehen
lynx -head https://ternis.org
```

### Erklärung der Flags

- `-dump`: Lädt die Seite, wandelt sie in formatierten Reintext um und gibt sie auf `stdout` aus.
- `-listonly`: Gibt in Kombination mit `-dump` nur die nummerierte Liste aller Hyperlinks der Seite aus. Perfekt zur Überprüfung interner Verlinkungen.
- `-head`: Sendet eine `HEAD`-Anfrage und zeigt die Antwort-Header des Servers an.
