---
title: CSS Layout — When to Use CSS Grid vs. Flexbox
description: Complete beginner guide to modern CSS layouts, the 1D vs 2D rule, building responsive page layouts with Grid, and mastering Flexbox component alignment.
category: css
order: 10
tags: [css, grid, flexbox, layout, responsive, frontend, web]
updated: 2026-10-06
related: [php/getting-started-83, javascript/fetch-basics]
---

## The Golden Rule: 1-Dimensional vs. 2-Dimensional Layouts

Before modern CSS, developers relied on floats and table hacks to lay out web pages. Today, **Flexbox** and **CSS Grid** are modern standards designed for complementary jobs:

- **Flexbox (1-Dimensional)**: Positions items along **one single axis at a time** (either in a horizontal row OR a vertical column).
  - *Best for*: Navigation bars, button groups, aligning icons with text, card headers.
- **CSS Grid (2-Dimensional)**: Positions items across **both rows AND columns simultaneously**.
  - *Best for*: Full page macro layouts, complex dashboards, multi-column image galleries.

---

## 1. When to use Flexbox

Use Flexbox when you want items inside a container to space themselves out along a single direction:

```css
.navbar {
  display: flex;
  justify-content: space-between; /* Pushes brand to left, nav links to right */
  align-items: center;            /* Vertically centers items */
  gap: 1.5rem;                    /* Clean spacing between items */
}
```

### Essential Flexbox properties breakdown

- `display: flex`: Activates flex context on immediate children.
- `flex-direction: row | column`: The main axis direction (defaults to `row`).
- `justify-content`: Controls alignment along the **main axis** (`flex-start`, `center`, `space-between`, `space-around`).
- `align-items`: Controls alignment along the **cross axis** (`center`, `stretch`, `baseline`).
- `gap`: Adds uniform spacing between child elements without messy `margin-right` calculations.
- `flex-wrap: wrap`: Allows items to wrap onto a new line if screen width is constrained.

---

## 2. When to use CSS Grid: The Holy Grail Layout

For an entire page layout containing a Header, Sidebar Navigation, Main Content, Aside, and Footer, **CSS Grid** is unbeatable:

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

### Grid properties breakdown

- `grid-template-columns: 240px 1fr 240px`: Defines three vertical columns: a fixed 240px nav, a flexible middle main area taking up remaining space (`1fr` = 1 fraction unit), and a 240px aside.
- `grid-template-rows: auto 1fr auto`: Header shrinks to its content height (`auto`), main area expands to fill the screen (`1fr`), footer shrinks to content height (`auto`).
- `grid-template-areas`: Visually maps CSS classes to a 2D layout grid like an architectural floor plan.

---

## 3. Responsive Collapse without complex math

To make the layout mobile-friendly on smartphones, collapse the 3-column grid into a single vertical stack:

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

### The magical auto-fitting card grid

For responsive card listings (like blog articles or product catalogs) that automatically re-arrange from 4 columns to 2 to 1 without needing a single media query:

```css
.card-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1.5rem;
}
```

- `repeat(auto-fit, ...)`: Generates as many columns as will fit across the available width.
- `minmax(280px, 1fr)`: Each card will never shrink below 280px, but will stretch equally to fill remaining space.

---

## Pro Tip: Fluid Typography with `clamp()`

Stop writing ten separate media queries just to resize text for mobile screens. Use the CSS `clamp()` function:

```css
h1 {
  font-size: clamp(1.75rem, 4vw + 1rem, 3.25rem);
}
```

- `1.75rem`: Minimum font size on small mobile screens.
- `4vw + 1rem`: Fluid ideal scaling based on viewport width.
- `3.25rem`: Maximum ceiling font size on wide desktop monitors.
