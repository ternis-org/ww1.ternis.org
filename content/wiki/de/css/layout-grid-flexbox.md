---
title: CSS Layout — Wann man CSS Grid vs. Flexbox einsetzt
description: Einsteigerfreundlicher Leitfaden zu modernen CSS-Layouts, der 1D- vs. 2D-Regel, Responsive Webdesign mit Grid und Flexbox-Ausrichtung.
category: css
order: 10
tags: [css, grid, flexbox, layout, responsive, frontend, webentwicklung]
updated: 2026-10-06
related: [php/getting-started-83, javascript/fetch-basics]
---

## Die goldene Regel: 1D- vs. 2D-Layouts

Früher mussten Entwickler Webseiten mühsam mit `float` und Tabellen layouten. Heute stehen mit **Flexbox** und **CSS Grid** zwei moderne Standards bereit, die sich perfekt ergänzen:

- **Flexbox (Eindimensional)**: Ordnet Elemente entlang **einer einzelnen Achse** an (entweder horizontal in einer Zeile ODER vertikal in einer Spalte).
  - *Ideal für*: Navigationsleisten, Button-Gruppen, Zentrierung von Icons und Text.
- **CSS Grid (Zweidimensional)**: Ordnet Elemente **über Zeilen UND Spalten gleichzeitig** an.
  - *Ideal für*: Gesamte Seitenlayouts (Header, Sidebar, Main, Footer), Dashboards und Bildgalerien.

---

## 1. Flexbox im Praxiseinsatz

```css
.navbar {
  display: flex;
  justify-content: space-between; /* Logo links, Navigationslinks rechts */
  align-items: center;            /* Vertikal mittig ausrichten */
  gap: 1.5rem;                    /* Sauberer Abstand zwischen Elementen */
}
```

### Die wichtigsten Flexbox-Eigenschaften

- `display: flex`: Aktiviert Flexbox für alle direkten Kindelemente.
- `justify-content`: Steuert die Ausrichtung entlang der Hauptachse (`flex-start`, `center`, `space-between`).
- `align-items`: Steuert die Ausrichtung quer zur Hauptachse (`center`, `stretch`).
- `gap`: Definiert gleichmäßige Abstände zwischen den Elementen.

---

## 2. CSS Grid: Das klassische Seitenlayout ("Holy Grail")

```css
.page-layout {
  display: grid;
  min-height: 100vh;
  grid-template-columns: 240px 1fr 240px;
  grid-template-rows: auto 1fr auto;
  grid-template-areas:
    "header header header"
    "nav    main   aside"
    "footer footer footer";
  gap: 1rem;
}

.header { grid-area: header; }
.nav    { grid-area: nav; }
.main   { grid-area: main; }
.aside  { grid-area: aside; }
.footer { grid-area: footer; }
```

### Responsive Anpassung für Mobilgeräte

```css
@media (max-width: 900px) {
  .page-layout {
    grid-template-columns: 1fr;
    grid-template-areas:
      "header"
      "nav"
      "main"
      "aside"
      "footer";
  }
}
```

### Automatische Kachel-Raster ohne Media Queries

```css
.card-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1.5rem;
}
```

- `repeat(auto-fit, ...)`: Platziert so viele Spalten nebeneinander, wie Platz vorhanden ist.
- `minmax(280px, 1fr)`: Jede Kachel ist mindestens 280px breit und dehnt sich bei mehr Platz gleichmäßig aus.
