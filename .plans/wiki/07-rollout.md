# 07 — Rollout

## Phase 0 — Confirm (no code)
- [ ] Approve URL scheme (`/{lang}/wiki/...`) + flat-file Markdown decision in this plan.
- [ ] Approve category slugs (`03-content-model.md`) — renames later = redirects, so lock them now.
- [ ] Pick Markdown parser: vendored single-file (preferred) vs hand-rolled subset.

## Phase 1 — Skeleton (no articles yet)
- [ ] `src/wiki.php` with `wiki_categories()`, frontmatter parse, subset renderer stub, index builder.
- [ ] `bootstrap.php`: `/wiki*` redirects + `/{lang}/wiki*` routes (see `02-ia-routing.md`).
- [ ] `src/views/wiki/{home,category,article,search}.php` + `wiki_card.php`, wired to `layouts/main.php`.
- [ ] `lang/en.php` + `lang/de.php`: `nav.wiki` + `wiki.*` chrome strings only.
- [ ] `assets/css/app.css`: `/* Wiki */` section; navbar (`component navbar`) + footer links.
- [ ] Smoke test: placeholder "Wiki coming soon" pages return 200 at `/en/wiki`, `/de/wiki`.

## Phase 2 — Engine
- [ ] Real Markdown → HTML (escaped, TOC ids, copy buttons, lazy images, external-link attrs).
- [ ] Traversal-safe file loading + `draft` handling + EN-fallback banner for missing DE.
- [ ] `ETag`/`Last-Modified` + file HTML cache (`storage/cache/wiki/...`).
- [ ] `/{lang}/wiki/search` SSR + `index.{en,de}.json` + client-side search JS (extend `assets/js/app.js` or new `wiki.js` via existing asset route).
- [ ] `src/views/sitemap.php` includes wiki URLs; `robots.txt` comment; JSON-LD on article pages.
- [ ] `sw.js` precache additions for wiki home + search index.

## Phase 3 — Seed content (~60 articles, `06-articles.md`)
- [ ] Write EN batch 1: `dns` (8) + `domains` (6) — closest to ternis.org/example-dns identity.
- [ ] Write EN batch 2: `networking` (6) + `homelab` (6) + `linux` (4) + `ubuntu` (3).
- [ ] Write EN batch 3: `sql` (5) + `mysql-mariadb` (5) + `phpmyadmin` (3) + `php` (3) + `javascript` (3) + `css` (3) + overflow (5).
- [ ] DE translations for at least batch 1; remaining DE tracked per-article (fallback banner covers the gap).
- [ ] Each article: frontmatter complete, `related` links valid, code blocks tested by copy-paste.

## Phase 4 — Harden & launch
- [ ] `php -l` on all touched PHP; manual matrix: `/wiki`, trailing slashes, bad slugs → 404, `?q=` XSS probe, language switcher, dark mode, mobile, no-JS search.
- [ ] CSP check (no new violations), PWA offline check for cached wiki pages.
- [ ] Update `README.md` repo structure (add `content/wiki/`, `src/wiki.php`, `src/views/wiki/`).
- [ ] Merge, deploy, submit `sitemap.xml` re-crawl; announce via ternis.dev channels.

## Acceptance criteria (launch gate)
1. `/wiki` → `/{lang}/wiki` 302 with `Vary: Accept-Language`; articles 200 with canonical + hreflang.
2. Unknown slug → localized 404 (`views/error.php`), `X-Robots-Tag: noindex, nofollow`.
3. Sitemap contains all non-draft articles in both langs with file-mtime `<lastmod>`.
4. Search works with JS disabled (SSR) and enabled (instant filter), zero external requests.
5. No new cookies/trackers; CSP unchanged; theme + PWA behavior intact.
