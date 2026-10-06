# 01 — Goals & Scope

## Goal
Add a gigantic, long-lived knowledge wiki at `/wiki/` covering practical
engineering knowledge used across the ternis.org ecosystem:

> networking, homelabbing, domains, DNS, SQL, Linux, Ubuntu,
> MySQL + MariaDB, phpMyAdmin, PHP, JavaScript, CSS **and more**.

The wiki reinforces ternis.org's mission: open-source tooling + European
digital sovereignty + developer ergonomics.

## In scope
- Public, SEO-friendly wiki at `/wiki/` with EN (`/en/wiki/...`) + DE (`/de/wiki/...`).
- Category index, article pages, breadcrumbs, prev/next, related articles.
- Local search (no tracker), sitemap + robots integration.
- Bilingual content from day one (EN primary, DE full parity for core articles).
- Organic green-tech design system reuse (`assets/css/app.css`, `layouts/main.php`).
- Zero cookies / zero trackers / GDPR-compliant (same bar as the rest of the site).
- Mobile-first, dark-mode, PWA-cacheable pages.

## Non-goals (v1)
- No user accounts, comments, or editing UI (Git PRs are the edit flow).
- No MediaWiki / DokuWiki / headless CMS import — native flat-file engine.
- No DB (MySQL/MariaDB) for wiki content itself (ironic but intentional:
  wiki *documents* MySQL, it doesn't *require* it).
- No versioned docs (e.g. `/wiki/php/8.3/...`) in v1 — add only if needed.
- No AI chatbot / RAG in v1 — clean Markdown + search ships first.

## Success criteria
1. `GET /wiki` 302-redirects to `/{preferred-lang}/wiki` (uses existing
   `detect_preferred_lang()` + `SUPPORTED_LANGS`).
2. `GET /en/wiki` and `/de/wiki` render < 100ms TTFB locally (flat-file + cache).
3. Every article has: title, description, canonical URL, hreflang alternates,
   BreadcrumbList JSON-LD, lastmod in sitemap.
4. Trailing-slash 301 behavior preserved (existing `Router::dispatch()` rule).
5. `php -S 127.0.0.1:8000 public/index.php` serves wiki with no extra setup.
6. Lighthouse: no new render-blocking assets, CSP still passes.
