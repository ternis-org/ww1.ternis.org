<?php

/**
 * Application bootstrap — loads helpers, wires up the router, and registers routes.
 */

// ── Helpers ────────────────────────────────────────────────────────────────
require ROOT_PATH . '/src/helpers.php';
require ROOT_PATH . '/src/wiki.php';

// Send modern security headers across all responses
send_security_headers();

// ── Exception Handler ──────────────────────────────────────────────────────
set_exception_handler(function (Throwable $e) {
    error_log('[ternis.org exception] ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
    if (http_response_code() === 200) {
        http_response_code(500);
    }
    $lang = defined('LANG') ? LANG : (defined('DEFAULT_LANG') ? DEFAULT_LANG : 'en');
    if (!defined('LANG')) {
        define('LANG', $lang);
    }
    load_lang($lang);
    render('error', [
        'lang'    => $lang,
        'code'    => 500,
        'message' => 'Internal Server Error',
        'title'   => '500 — Server Error — ternis.org',
    ], 'main');
    exit;
});

// ── Router ─────────────────────────────────────────────────────────────────
require ROOT_PATH . '/src/router.php';

$router = new Router();

// ── Supported languages ────────────────────────────────────────────────────
const SUPPORTED_LANGS = ['en', 'de'];
const DEFAULT_LANG    = 'en';

// ── Static assets ──────────────────────────────────────────────────────────

// /assets/{file}  (e.g. /assets/favicon.ico)
$router->get('/assets/{file}', function (array $p) {
    serve_static_file(PUBLIC_PATH . '/assets/' . $p['file'], PUBLIC_PATH . '/assets');
});

// /assets/{dir}/{file}  (e.g. /assets/css/app.css, /assets/js/app.js)
$router->get('/assets/{dir}/{file}', function (array $p) {
    serve_static_file(PUBLIC_PATH . '/assets/' . $p['dir'] . '/' . $p['file'], PUBLIC_PATH . '/assets');
});

// /og.jpg  — OG image served from public root
$router->get('/og.jpg', function () {
    serve_static_file(PUBLIC_PATH . '/og.jpg', PUBLIC_PATH);
});

// /favicon.ico — served from public root
$router->get('/favicon.ico', function () {
    serve_static_file(PUBLIC_PATH . '/favicon.ico', PUBLIC_PATH);
});

// /favicon.svg — vector favicon served from public root
$router->get('/favicon.svg', function () {
    serve_static_file(PUBLIC_PATH . '/favicon.svg', PUBLIC_PATH);
});

// /apple-touch-icon.png — apple touch icon served from public root
$router->get('/apple-touch-icon.png', function () {
    serve_static_file(PUBLIC_PATH . '/apple-touch-icon.png', PUBLIC_PATH);
});

// /manifest.json — PWA manifest served from public root
$router->get('/manifest.json', function () {
    serve_static_file(PUBLIC_PATH . '/manifest.json', PUBLIC_PATH);
});

// ── Routes ─────────────────────────────────────────────────────────────────

// Root: redirect to preferred language based on Accept-Language header
$router->get('/', function () {
    header('Vary: Accept-Language');
    $targetLang = detect_preferred_lang(SUPPORTED_LANGS, DEFAULT_LANG);
    redirect('/' . $targetLang, 302);
});

// Language homepage routes: /en  /de
foreach (SUPPORTED_LANGS as $lang) {
    $router->get('/' . $lang, function () use ($lang) {
        if (!defined('LANG')) {
            define('LANG', $lang);
        }
        load_lang($lang);
        render('index', [
            'lang'         => $lang,
            'canonicalUrl' => 'https://ternis.org/' . $lang,
        ], 'main');
    });
}

// Legal routes without locale: /legal and /legal/{slug}
$router->get('/legal', function () {
    header('Vary: Accept-Language');
    $targetLang = detect_preferred_lang(SUPPORTED_LANGS, DEFAULT_LANG);
    redirect('/' . $targetLang . '/legal/imprint', 302);
});

$router->get('/legal/{slug}', function (array $p) {
    header('Vary: Accept-Language');
    $targetLang = detect_preferred_lang(SUPPORTED_LANGS, DEFAULT_LANG);
    redirect('/' . $targetLang . '/legal/' . $p['slug'], 302);
});

// Dynamic legal pages: /{lang}/legal and /{lang}/legal/{slug}
foreach (SUPPORTED_LANGS as $lang) {
    $router->get('/' . $lang . '/legal', function () use ($lang) {
        redirect('/' . $lang . '/legal/imprint', 302);
    });

    $router->get('/' . $lang . '/legal/{slug}', function (array $p) use ($lang) {
        if (!defined('LANG')) {
            define('LANG', $lang);
        }
        load_lang($lang);
        $slug     = $p['slug'] ?? '';
        $langData = $GLOBALS['_lang_data'] ?? [];

        if (empty($slug) || !isset($langData['legal'][$slug]) || !is_array($langData['legal'][$slug])) {
            http_response_code(404);
            header('X-Robots-Tag: noindex, nofollow');
            render('error', [
                'lang'    => $lang,
                'code'    => 404,
                'message' => t('error.not_found'),
            ], 'main');
            return;
        }

        $canonicalUrl = 'https://ternis.org/' . $lang . '/legal/' . $slug;

        render('legal', [
            'lang'         => $lang,
            'slug'         => $slug,
            'doc'          => $langData['legal'][$slug],
            'title'        => ($langData['legal'][$slug]['title'] ?? 'Legal') . ' — ternis.org',
            'canonicalUrl' => $canonicalUrl,
        ], 'main');
    });
}

// ── Wiki ───────────────────────────────────────────────────────────────────
// Canonical home: /wiki → /{preferred-lang}/wiki
$router->get('/wiki', function () {
    header('Vary: Accept-Language');
    redirect('/' . detect_preferred_lang(SUPPORTED_LANGS, DEFAULT_LANG) . '/wiki', 302);
});
$router->get('/wiki/search', function () {
    header('Vary: Accept-Language');
    $q = $_SERVER['QUERY_STRING'] ?? '';
    $target = '/' . detect_preferred_lang(SUPPORTED_LANGS, DEFAULT_LANG) . '/wiki/search';
    redirect($target . ($q !== '' ? '?' . $q : ''), 302);
});
// /wiki/feed.xml — Atom syndication feed for search engines and RSS readers
$router->get('/wiki/feed.xml', function () {
    header('Content-Type: application/atom+xml; charset=utf-8');
    header('X-Content-Type-Options: nosniff');
    header('Cache-Control: public, max-age=3600, stale-while-revalidate=86400');
    header('Access-Control-Allow-Origin: *');
    render('wiki/feed');
});

// OpenGraph dynamic preview cards generator
$ogWikiHandler = function (array $p, string $lang = 'en') {
    require_once ROOT_PATH . '/src/helpers/og_image.php';
    $slug = preg_replace('/\.png$/i', '', (string) ($p['slug'] ?? ''));
    $cat = (string) ($p['category'] ?? '');
    $article = wiki_get_article($lang, $cat, $slug);
    if ($article === null && $lang !== 'en') {
        $article = wiki_get_article('en', $cat, $slug);
    }
    if ($article !== null) {
        generate_og_image(
            $article['title'],
            $article['description'],
            $cat,
            $article['updated'] ?? ''
        );
    } else {
        generate_og_image(
            ucwords(str_replace('-', ' ', $slug)),
            'Technical documentation and guides on ternis.org',
            $cat
        );
    }
};

$router->get('/wiki/og/{category}/{slug}', function (array $p) use ($ogWikiHandler) {
    $ogWikiHandler($p, 'en');
});

$router->get('/wiki/{category}', function (array $p) {
    header('Vary: Accept-Language');
    redirect('/' . detect_preferred_lang(SUPPORTED_LANGS, DEFAULT_LANG) . '/wiki/' . $p['category'], 302);
});
$router->get('/wiki/{category}/{slug}', function (array $p) {
    header('Vary: Accept-Language');
    redirect('/' . detect_preferred_lang(SUPPORTED_LANGS, DEFAULT_LANG) . '/wiki/' . $p['category'] . '/' . $p['slug'], 302);
});

$wikiAssets = [];

foreach (SUPPORTED_LANGS as $lang) {
    // Wiki home
    $router->get('/' . $lang . '/wiki', function () use ($lang, $wikiAssets) {
        if (!defined('LANG')) {
            define('LANG', $lang);
        }
        load_lang($lang);
        $catsWithCounts = wiki_categories_with_counts($lang);
        $featured = array_slice(wiki_build_index($lang), 0, 8);
        render('wiki/home', [
            'lang' => $lang,
            'categories' => $catsWithCounts,
            'featured' => $featured,
            'title' => t('wiki.meta_title'),
            'metaDescription' => t('wiki.meta_description'),
            'canonicalUrl' => 'https://ternis.org/' . $lang . '/wiki',
        ] + $wikiAssets, 'wiki');
    });

    // Wiki JSON index (powers instant client-side search)
    $router->get('/' . $lang . '/wiki/index.json', function () use ($lang) {
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: public, max-age=3600, stale-while-revalidate=86400');
        header('Access-Control-Allow-Origin: *');
        header('X-Content-Type-Options: nosniff');
        echo json_encode(wiki_build_index($lang), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        exit;
    });

    // Wiki search
    $router->get('/' . $lang . '/wiki/search', function () use ($lang, $wikiAssets) {
        if (!defined('LANG')) {
            define('LANG', $lang);
        }
        load_lang($lang);
        $q = mb_substr(trim((string) ($_GET['q'] ?? '')), 0, 200);
        $catsWithCounts = wiki_categories_with_counts($lang);
        header('X-Robots-Tag: noindex, follow');
        render('wiki/search', [
            'lang' => $lang,
            'query' => $q,
            'results' => wiki_search($lang, $q),
            'categories' => $catsWithCounts,
            'title' => t('wiki.search_title') . ' — ternis.org Wiki',
            'canonicalUrl' => 'https://ternis.org/' . $lang . '/wiki/search',
        ] + $wikiAssets, 'wiki');
    });

    // Wiki Feed
    $router->get('/' . $lang . '/wiki/feed.xml', function () {
        header('Content-Type: application/atom+xml; charset=utf-8');
        header('X-Content-Type-Options: nosniff');
        header('Cache-Control: public, max-age=3600, stale-while-revalidate=86400');
        header('Access-Control-Allow-Origin: *');
        render('wiki/feed');
    });

    // Wiki dynamic OpenGraph image
    $router->get('/' . $lang . '/wiki/og/{category}/{slug}', function (array $p) use ($lang, $ogWikiHandler) {
        $ogWikiHandler($p, $lang);
    });

    // Wiki category
    $router->get('/' . $lang . '/wiki/{category}', function (array $p) use ($lang, $wikiAssets) {
        if (!defined('LANG')) {
            define('LANG', $lang);
        }
        load_lang($lang);
        $cats = wiki_categories();
        if (!isset($cats[$p['category']])) {
            wiki_404($lang);
            return;
        }
        $catsWithCounts = wiki_categories_with_counts($lang);
        $catTitle = $lang === 'de' ? $cats[$p['category']]['de'] : $cats[$p['category']]['en'];
        render('wiki/category', [
            'lang' => $lang,
            'category' => $p['category'],
            'meta' => $cats[$p['category']],
            'articles' => wiki_list_articles($lang, $p['category']),
            'categories' => $catsWithCounts,
            'title' => $catTitle . ' — ternis.org Wiki',
            'canonicalUrl' => 'https://ternis.org/' . $lang . '/wiki/' . $p['category'],
        ] + $wikiAssets, 'wiki');
    });

    // Wiki article
    $router->get('/' . $lang . '/wiki/{category}/{slug}', function (array $p) use ($lang, $wikiAssets) {
        if (!defined('LANG')) {
            define('LANG', $lang);
        }
        // 301 Redirect for renamed article
        if ($p['category'] === 'domains' && $p['slug'] === 'register-manage-dnbx') {
            header('Location: /' . $lang . '/wiki/domains/register-manage-ternisdomains', true, 301);
            exit;
        }

        $article = wiki_get_article($lang, $p['category'], $p['slug']);
        if ($article === null) {
            wiki_404($lang);
            return;
        }
        $articles = wiki_list_articles($lang, $p['category']);
        $prev = null;
        $next = null;
        foreach ($articles as $i => $a) {
            if ($a['slug'] === $p['slug']) {
                $prev = $articles[$i - 1] ?? null;
                $next = $articles[$i + 1] ?? null;
                break;
            }
        }
        $relatedArticles = [];
        foreach (array_slice($article['related'], 0, 4) as $ref) {
            if (!str_contains($ref, '/')) {
                continue;
            }
            [$rc, $rs] = explode('/', $ref, 2);
            $rel = wiki_get_article($lang, $rc, $rs);
            if ($rel !== null) {
                $relatedArticles[] = $rel;
            }
        }
        $catsWithCounts = wiki_categories_with_counts($lang);
        header('Cache-Control: public, max-age=3600, stale-while-revalidate=86400');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $article['source_mtime']) . ' GMT');
        render('wiki/article', [
            'lang' => $lang,
            'category' => $p['category'],
            'slug' => $p['slug'],
            'article' => $article,
            'prev' => $prev,
            'next' => $next,
            'relatedArticles' => $relatedArticles,
            'categoryMeta' => wiki_categories()[$p['category']],
            'categoryArticles' => $articles,
            'categories' => $catsWithCounts,
            'title' => $article['title'] . ' — ternis.org Wiki',
            'metaDescription' => $article['description'] !== '' ? $article['description'] : null,
            'metaKeywords' => $article['tags'] !== [] ? implode(', ', $article['tags']) . ', ternis.org wiki' : null,
            'canonicalUrl' => 'https://ternis.org/' . $lang . '/wiki/' . $p['category'] . '/' . $p['slug'],
        ] + $wikiAssets, 'wiki');
    });
}

// robots.txt — serve static file
$router->get('/robots.txt', function () {
    $file = ROOT_PATH . '/static/robots.txt';
    header('Content-Type: text/plain; charset=utf-8');
    header('X-Content-Type-Options: nosniff');
    header('Access-Control-Allow-Origin: *');
    header('Cache-Control: public, max-age=86400');
    if (file_exists($file)) {
        readfile($file);
    } else {
        echo "User-agent: *\nAllow: /\nSitemap: https://ternis.org/sitemap.xml\n";
    }
});

// sitemap.xml — dynamically generated
$router->get('/sitemap.xml', function () {
    header('Content-Type: application/xml; charset=utf-8');
    header('X-Content-Type-Options: nosniff');
    header('Cache-Control: public, max-age=3600, stale-while-revalidate=86400');
    header('Access-Control-Allow-Origin: *');
    render('sitemap');
});

// sitemap.xsl — browser stylesheet for human-friendly viewing
$router->get('/sitemap.xsl', function () {
    $xslPath = PUBLIC_PATH . '/sitemap.xsl';
    if (file_exists($xslPath)) {
        header('Content-Type: text/xsl; charset=utf-8');
        header('X-Content-Type-Options: nosniff');
        header('Cache-Control: public, max-age=86400, stale-while-revalidate=604800');
        header('Access-Control-Allow-Origin: *');
        readfile($xslPath);
        exit;
    }
    http_response_code(404);
});

// /og.png and /og.jpg — Root OpenGraph branding card
$router->get('/og.png', function () {
    require_once ROOT_PATH . '/src/helpers/og_image.php';
    generate_og_image(
        'ternis.org — Infrastructure, DNS & Systems Hub',
        'Redundant Authoritative Anycast DNS, Technical Wiki, and Open Infrastructure by Fabian Ternis.',
        'INFRASTRUCTURE'
    );
});
$router->get('/og.jpg', function () {
    require_once ROOT_PATH . '/src/helpers/og_image.php';
    generate_og_image(
        'ternis.org — Infrastructure, DNS & Systems Hub',
        'Redundant Authoritative Anycast DNS, Technical Wiki, and Open Infrastructure by Fabian Ternis.',
        'INFRASTRUCTURE'
    );
});

// /api/ver — Version hash API
$router->get('/api/ver', function () {
    $shortHash = app_version_hash(true);
    $fullHash  = app_version_hash(false);

    $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
    $plain  = isset($_GET['plain']) || (str_contains($accept, 'text/plain') && !str_contains($accept, 'application/json'));

    if ($plain) {
        header('Content-Type: text/plain; charset=utf-8');
        header('Cache-Control: public, max-age=60, stale-while-revalidate=300');
        header('Access-Control-Allow-Origin: *');
        header('X-Content-Type-Options: nosniff');
        echo $shortHash . "\n";
        exit;
    }

    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: public, max-age=60, stale-while-revalidate=300');
    header('Access-Control-Allow-Origin: *');
    header('X-Content-Type-Options: nosniff');
    echo json_encode([
        'version' => $shortHash,
        'commit'  => $fullHash,
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . "\n";
    exit;
});

// /sw.js — Service Worker script
$router->get('/sw.js', function () {
    $file = PUBLIC_PATH . '/sw.js';
    header('Content-Type: application/javascript; charset=utf-8');
    header('Service-Worker-Allowed: /');
    header('X-Content-Type-Options: nosniff');
    header('Cache-Control: no-cache, no-store, must-revalidate');
    if (file_exists($file)) {
        readfile($file);
    } else {
        http_response_code(404);
    }
    exit;
});

// 404 fallback — detect language from URI prefix
$router->fallback(function () {
    $uri  = ltrim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/', '/');
    $lang = DEFAULT_LANG;

    foreach (SUPPORTED_LANGS as $supported) {
        if (str_starts_with($uri, $supported)) {
            $lang = $supported;
            break;
        }
    }

    if (!defined('LANG')) {
        define('LANG', $lang);
    }
    load_lang($lang);
    http_response_code(404);
    header('X-Robots-Tag: noindex, nofollow');
    render('error', [
        'lang'    => $lang,
        'code'    => 404,
        'message' => t('error.not_found'),
        'title'   => '404 — ' . t('error.not_found') . ' — ternis.org',
    ], 'main');
});
