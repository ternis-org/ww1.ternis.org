# 04 — UI / UX

Reuse the organic green-tech system. No new framework, no new font.

## Views (`src/views/wiki/`, rendered inside `layouts/main.php`)

| View | Purpose | Notes |
|------|---------|-------|
| `home.php` | `/​{lang}/wiki` — hero + search box + category grid + featured/popular | Mirrors `views/index.php` section-header + card rhythm |
| `category.php` | `/​{lang}/wiki/{category}` — title, description, article list (ordered) | Breadcrumb: Home / Wiki / {Category} |
| `article.php` | `/​{lang}/wiki/{category}/{slug}` — TOC sidebar, body, prev/next, related, last-updated | Breadcrumb + Article JSON-LD + `copy-chip-btn` on code blocks |
| `search.php` | `/​{lang}/wiki/search?q=` — server-rendered results (JS progressively enhances) | `noindex, follow` |
| `components/wiki_card.php` | Shared category/article card | Same `.project-card` language as homepage |

All views escape via existing `e()` helper; Markdown renderer escapes raw HTML by default.

## Article page anatomy

1. Breadcrumbs (`Home / Wiki / {Category} / {Title}`) — same accessible
   `<nav aria-label="Breadcrumb">` pattern as `views/legal.php:19-25`.
2. H1 + description + meta row (reading time, `updated` date, tags).
3. Two-column on desktop: sticky TOC (`On this page`, anchor links) + body;
   single column on mobile, TOC collapses to `<details>`.
4. Code blocks: existing terminal/code styling + per-block copy button
   (reuse `data-copy` / `data-toast` convention from homepage NS terminal).
5. Prev/next (by `order` within category) + `related` cards + "Edit on GitHub"
   link (`config('repo_url') . '/blob/master/content/wiki/...'` via `app_repo_url()`).
6. Language-switch banner when translation is missing (see `03-content-model.md`).

## Search

- Build script (`bin/wiki-index.php` or `src/wiki.php::wiki_build_index()`)
  emits `content/wiki/index.{en,de}.json`: `{ title, description, category, slug, url, tags, headings }`.
- Client: fetch JSON, filter on input, highlight matches, keyboard navigable —
  no external API, no cookies (consistent with zero-tracker stance).
- `/{lang}/wiki/search` SSR fallback renders the same matches server-side for
  no-JS + crawlers.

## Styling (`assets/css/app.css` — append, don't fork)

Add a `/* Wiki */` section reusing tokens (`--primary`, `--bg-card`,
`--border-subtle`, `--radius-md`, `--font-mono`):
- `.wiki-grid`, `.wiki-card`, `.wiki-tag`, `.wiki-toc`, `.wiki-prose`
  (typography scale for h2/h3, tables, blockquotes, admonitions),
  `.wiki-search`, `.wiki-kbd`.
- Dark-mode via existing `[data-theme="dark"]` overrides — no separate stylesheet.
- Print stylesheet nicety: hide nav/TOC, expand body (cheap `@media print` block).

## PWA (`public/sw.js`, `public/manifest.json`)

- Add `/en/wiki`, `/de/wiki` to precache list; runtime cache wiki article
  HTML + `index.{en,de}.json` with stale-while-revalidate (same strategy as today).
- No change to `manifest.json` needed beyond optionally adding a `shortcuts` entry for Wiki.
