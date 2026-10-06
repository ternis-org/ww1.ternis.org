# ternis.org Wiki — Plan Index (`/wiki/`)

Gigantic, bilingual (EN/DE), open-knowledge wiki for networking, homelabbing,
domains, DNS, SQL, Linux, Ubuntu, MySQL/MariaDB, phpMyAdmin, PHP, JavaScript,
CSS and more — living at `/wiki/`.

Planned as a native extension of the existing zero-framework PHP micro-router
(`bootstrap.php`, `src/router.php`, `src/helpers.php`, `src/views/`,
`lang/en.php`, `lang/de.php`), not a third-party wiki engine.

## Files in this plan

| File | Covers |
|------|--------|
| `01-goals-scope.md` | Goals, non-goals, success criteria |
| `02-ia-routing.md` | URL scheme, router changes, redirects, sitemap/robots/SEO |
| `03-content-model.md` | Categories, article schema, storage format, i18n strategy |
| `04-ui-ux.md` | Layouts, views, components, styling, search, nav, PWA |
| `05-backend.md` | Helpers, Markdown rendering, caching, security, privacy |
| `06-articles.md` | Full initial article inventory (all requested topics + more) |
| `07-rollout.md` | Phased implementation checklist + acceptance criteria |

## TL;DR decision log (proposed, to confirm during build)

1. **Routes are locale-prefixed**, matching the rest of the site:
   `/wiki` → 302 to `/{lang}/wiki` (via `Accept-Language` detection).
   Canonical article URL: `/{lang}/wiki/{category}/{slug}` (e.g. `/en/wiki/dns/a-records`).
2. **Content stored as Markdown + frontmatter** under `content/wiki/{lang}/{category}/{slug}.md`
   (not inside `lang/*.php` — those files would explode at wiki scale).
3. **Zero new runtime dependencies.** Markdown rendering = one small vendored
   parser or ~150-line custom renderer in `src/wiki.php` (no Composer required).
4. **No DB.** Flat files + OPcache / file-cache for HTML. Fits EU-sovereign,
   zero-tracker, static-friendly hosting.
5. **Search is local-first:** build-time JSON index + client-side filter,
   no external search API.
