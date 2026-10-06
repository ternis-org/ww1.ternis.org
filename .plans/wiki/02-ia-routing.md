# 02 — IA & Routing (`/wiki/`)

## URL scheme (locale-prefixed, like `/en`, `/{lang}/legal/{slug}`)

| URL | Behavior |
|-----|----------|
| `/wiki` | 302 → `/{preferred-lang}/wiki` (`Accept-Language`, `Vary: Accept-Language`) |
| `/wiki/{anything}` | 302 → `/{preferred-lang}/wiki/{anything}` (same detection) |
| `/{lang}/wiki` | Wiki home: category grid + featured + search entry |
| `/{lang}/wiki/{category}` | Category index (e.g. `/en/wiki/dns`) |
| `/{lang}/wiki/{category}/{slug}` | Article (e.g. `/en/wiki/dns/a-records`) |
| `/{lang}/wiki/search?q=...` | Server-rendered fallback results page (JS enhances it) |
| `/wiki/search` etc. | Redirect variant of the above |

Rules:
- `{lang}` ∈ `SUPPORTED_LANGS` (`en`, `de`) — reuse the `foreach (SUPPORTED_LANGS ...)` registration pattern in `bootstrap.php:89-150`.
- `{category}` and `{slug}` = `[a-z0-9-]+` only; validate in handler, 404 otherwise.
- Preserve existing trailing-slash 301 (`src/router.php:75-82`).
- Unknown category/slug → localized 404 via existing `views/error.php` + `X-Robots-Tag: noindex, nofollow` (same as legal 404 in `bootstrap.php:129-138`).

## Router changes (`bootstrap.php`)

Add after the legal routes, before `/robots.txt`:

```php
// Wiki: /wiki → /{lang}/wiki
$router->get('/wiki', fn() => redirect('/' . detect_preferred_lang(...) . '/wiki', 302));
$router->get('/wiki/{category}', fn($p) => redirect('/' . $lang . '/wiki/' . $p['category'], 302));
$router->get('/wiki/{category}/{slug}', ...same, 2 segments...);
$router->get('/wiki/search', ... preserve ?q= ...);

foreach (SUPPORTED_LANGS as $lang) {
  $router->get('/'.$lang.'/wiki',            /* WikiController::index */);
  $router->get('/'.$lang.'/wiki/search',     /* WikiController::search */);
  $router->get('/'.$lang.'/wiki/{category}', /* WikiController::category */);
  $router->get('/'.$lang.'/wiki/{category}/{slug}', /* WikiController::article */);
}
```

Optional: extract to `src/wiki.php` (`WikiController` functions) so `bootstrap.php`
stays thin — same way `src/helpers.php` + `src/router.php` are separated today.

## Navbar / footer / cross-links

- `src/views/components/navbar.php`: add `Wiki` link (`t('nav.wiki')`) → `/{lang}/wiki`.
- `src/views/components/footer.php`: add Wiki column (Home, all categories, search).
- Homepage (`src/views/index.php`): optional wiki teaser band (3 featured articles) — keep out of v1 critical path.
- `lang/en.php` + `lang/de.php`: add only `nav.wiki`, `wiki.*` chrome strings
  (titles, search placeholder, breadcrumbs). Article *bodies* do NOT go in lang files.

## SEO / sitemap / robots

- `src/views/sitemap.php`: iterate the wiki content index and emit
  `/{lang}/wiki/{category}/{slug}` + `/{lang}/wiki/{category}` URLs with
  `changefreq: weekly`, `priority: 0.7` (articles) / `0.8` (wiki home).
  Keep existing `hreflang` `en`/`de`/`x-default` triple per URL.
- `static/robots.txt`: keep `Allow: /`; add explicit
  `Allow: /en/wiki` + `Allow: /de/wiki` documentation comment (no disallow needed).
- Every wiki page via `layouts/main.php`: `canonicalUrl`,
  `title`, `metaDescription` from article frontmatter; Article JSON-LD +
  BreadcrumbList JSON-LD (mirror `views/legal.php:117-142` pattern).
- `/{lang}/wiki/search` sends `X-Robots-Tag: noindex, follow` (like `/sitemap.xml` does).
