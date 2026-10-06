# 05 — Backend

## New module: `src/wiki.php`

Single home for wiki logic (keeps `bootstrap.php` + `helpers.php` lean):

```php
wiki_categories(): array                 // slug → {icon, title_en/de, desc_en/de, order}
wiki_list_articles(string $lang, string $category): array
wiki_get_article(string $lang, string $category, string $slug): ?array
  // → { title, description, category, slug, tags, updated, related, html, toc, reading_minutes, fallback_lang }
wiki_search(string $lang, string $q, int $limit = 20): array
wiki_build_index(string $lang): array    // for bin/wiki-index.php + sitemap
wiki_markdown_to_html(string $md): string
wiki_frontmatter_parse(string $raw): array{meta, body}
```

Validation rules:
- `$category`/`$slug` regex: `/^[a-z0-9-]+$/`, max 80 chars.
- Resolve path as `content/wiki/{lang}/{category}/{slug}.md`, then `realpath()` +
  `str_starts_with($real, realpath('content/wiki'))` — same traversal guard as
  `serve_static_file()` in `src/helpers.php:225-234`.
- `draft:true` → treat as missing unless `config('app_debug')` is true.

## Markdown rendering (no Composer)

Options, in order of preference:
1. **Vendored single-file parser** (e.g. Parsedown-style, MIT-licensed) dropped
   into `src/lib/` — auditable, no autoloader needed.
2. If licensing review blocks that: hand-rolled subset renderer (~150 lines,
   regex/block-based) covering the subset in `03-content-model.md`.

Either way: escape raw HTML, add `rel="noopener noreferrer"` + `target="_blank"`
to external links, add `loading="lazy"` to images, slug-generate heading `id`s
for the TOC. Code fences → `<pre><code class="language-x">` with `e()`-escaped body.

## Caching

- Render-once: `wiki_get_article()` caches HTML to
  `storage/cache/wiki/{lang}/{category}/{slug}.{hash}.html`
  (hash = `md5_file()` of source MD). Invalidate implicitly on content change.
- `Cache-Control: public, max-age=3600, stale-while-revalidate=86400` on article
  + category pages (mirrors `/sitemap.xml` headers in `bootstrap.php:175`).
- `ETag`/`Last-Modified` from source file mtime — reuse the conditional-GET
  pattern from `serve_static_file()` (`src/helpers.php:264-284`).
- Search JSON served immutable-ish (`max-age=3600`) via existing asset pipeline
  or a tiny `/​{lang}/wiki/index.json` route.

## Security & privacy

- `send_security_headers()` already covers CSP/X-Frame/Referrer — no change;
  verify wiki HTML output doesn't need `unsafe-*` additions (it must not).
- All dynamic segments escaped with `e()`; Markdown link URLs allow-listed
  (`http(s):`, `mailto:`, `#`, `/`); `javascript:`/`data:` dropped.
- No cookies, no localStorage writes except existing theme key; search runs
  fully client-side against a static JSON (nothing leaves the browser).
- `GET`-only routes (`$router->get(...)`); search `q` truncated to 200 chars,
  echoed back only via `e()`.

## SEO wiring

- `src/views/sitemap.php`: replace/augment static `$pages` array with a loop over
  `wiki_build_index('en')` + `('de')`, using file mtime as `<lastmod>`.
- `layouts/main.php` inputs per wiki page: `title` (`{Article} — ternis.org Wiki`),
  `metaDescription` (frontmatter `description`), `canonicalUrl`
  (`https://ternis.org/{lang}/wiki/{category}/{slug}`).
- Article + BreadcrumbList JSON-LD in `views/wiki/article.php`
  (copy the `views/legal.php:117-142` shape, `@type: Article` + author `ternis.org`).
