---
title: CSS Layout — When to Use Grid vs Flexbox
description: The 30-second rule for grid vs flexbox, plus a holy-grail layout in 20 lines.
category: css
order: 10
tags: [css, grid, flexbox, layout]
updated: 2026-10-06
related: [css/variables-dark-mode]
---

## The rule

- **Flexbox** = one dimension (a row *or* a column: navbars, button groups).
- **Grid** = two dimensions (rows *and* columns: cards, page layouts).

## Holy grail in 20 lines

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

## Responsive collapse

```css
@media (max-width: 900px) {
  .page {
    grid-template-columns: 1fr;
    grid-template-areas: "header" "main" "nav" "aside" "footer";
  }
}
```

:::tip
Reach for `clamp()` for fluid type: `font-size: clamp(1rem, 2vw + 0.5rem, 1.5rem)`
scales smoothly without a single media query.
:::
