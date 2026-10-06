---
title: CSS-Layout — Wann Grid, wann Flexbox
description: Die 30-Sekunden-Regel für Grid vs Flexbox plus ein Holy-Grail-Layout in 20 Zeilen.
category: css
order: 10
tags: [css, grid, flexbox, layout]
updated: 2026-10-06
related: [css/variables-dark-mode]
---

## Die Regel

- **Flexbox** = eine Dimension (eine Zeile *oder* eine Spalte: Navbars, Button-Gruppen).
- **Grid** = zwei Dimensionen (Zeilen *und* Spalten: Karten, Seitenlayouts).

## Holy Grail in 20 Zeilen

```css
.page {
  display: grid;
  grid-template-columns: 240px 1fr 240px;
  grid-template-rows: auto 1fr auto;
  grid-template-areas:
    "header header header"
    "nav main aside"
    "footer footer footer";
  min-height: 100vh;
}
.header { grid-area: header; }
.nav    { grid-area: nav; }
.main   { grid-area: main; }
.aside  { grid-area: aside; }
.footer { grid-area: footer; }
```

## Responsiver Zusammenbruch

```css
@media (max-width: 900px) {
  .page {
    grid-template-columns: 1fr;
    grid-template-areas: "header" "main" "nav" "aside" "footer";
  }
}
```

:::tip
Für fließende Schrift `clamp()` nutzen: `font-size: clamp(1rem, 2vw + 0.5rem, 1.5rem)`
skaliert stufenlos ohne eine einzige Media Query.
:::
