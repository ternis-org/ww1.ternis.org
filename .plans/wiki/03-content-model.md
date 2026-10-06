# 03 — Content Model

## Storage: flat-file Markdown (no DB)

```
content/
└── wiki/
    ├── index.en.json / index.de.json   # generated search + nav index (git-ignored or committed)
    ├── en/
    │   ├── networking/subnetting.md
    │   ├── homelab/reverse-proxy.md
    │   ├── domains/transfer.md
    │   ├── dns/a-records.md
    │   ├── sql/joins.md
    │   ├── linux/ssh-hardening.md
    │   ├── ubuntu/ufw-basics.md
    │   ├── mysql-vs-mariadb/choosing.md
    │   ├── phpmyadmin/install.md
    │   ├── php/getting-started.md
    │   ├── javascript/fetch-basics.md
    │   └── css/layout-grid-flexbox.md
    └── de/
        └── ... mirror tree (same category/slug, translated body)
```

Why flat files:
- Matches zero-dependency, sovereign-hosting ethos; deploy = `git pull`.
- Diffable, PR-reviewable, works with existing `?v=` git-hash cache-busting story.
- No migration needed for current Apache/LiteSpeed + `public/.htaccess` setup.

## Categories (v1 slugs — stable, English, never renamed)

`networking`, `homelab`, `domains`, `dns`, `sql`, `linux`, `ubuntu`,
`mysql-mariadb`, `phpmyadmin`, `php`, `javascript`, `css`, `selfhosting`,
`security`, `git-devops` (overflow for TLS, Nginx/Apache, Docker, backups).

Category metadata lives in code (not per-file), e.g. `src/wiki.php::wiki_categories()`:
`slug → { icon, en_title, de_title, description_en/de, order }`.
Keeps renames of display titles cheap without moving files.

## Article frontmatter (YAML-ish, parsed without dependency)

```md
---
title: "DNS A Records — Point a Domain at an IP"
description: "What A/AAAA records do, TTL, apex vs www, and how to verify with dig on example-dns."
category: dns
order: 10
tags: [dns, a-record, dig, example-dns]
updated: 2026-10-06
related: [dns/aaaa-records, dns/cname-records, domains/nameserver-glue]
draft: false
---

# ... body (GitHub-flavored Markdown subset)
```

Required: `title`, `description`, `category` (must match parent dir).
Optional: `order`, `tags`, `updated`, `related`, `draft` (`draft:true` → 404 in prod, visible with `APP_DEBUG=true`).

## Rendering subset (keep the parser small)

Support: headings, paragraphs, bold/italic/inline-code, fenced code blocks
(with language class), links, lists, tables, blockquotes, `---`, images
(relative → `/assets/wiki/...`, external must be `https:`), admonition
fences (`:::tip`, `:::warn`) mapped to existing card styles.

Explicitly NOT in v1: raw HTML passthrough (escape it — CSP + `e()` discipline),
iframes, math, mermaid, footnotes.

## i18n strategy

- File tree mirrored per lang; `/{lang}/wiki/{category}/{slug}` loads
  `content/wiki/{lang}/{category}/{slug}.md`.
- If DE file missing → serve EN body with a visible "translation missing —
  [read in English]" notice + `hreflang` still points at EN canonical.
  Never 404 a page that exists in the other language.
- Chrome strings (`Wiki`, `Search`, `On this page`, `Last updated`, …) go in
  `lang/en.php['wiki']` + `lang/de.php['wiki']`. Bodies never go in lang files.
- `lang_url($targetLang, $currentPath)` (existing `src/helpers.php:333`) already
  handles the language switcher — reuse as-is.

## Media

- Diagrams/screenshots → `public/assets/wiki/{category}/{slug}-*.{png,svg,webp}`.
  Served by the existing `/assets/{dir}/{file}` static route + immutable cache headers.
- Keep images local (no hotlinking) — privacy + CSP `img-src 'self' data: https:` stays valid.
