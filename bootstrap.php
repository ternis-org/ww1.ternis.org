<?php

/**
 * Application bootstrap — loads helpers, wires up the router, and registers routes.
 */

// ── Helpers ────────────────────────────────────────────────────────────────
require ROOT_PATH . '/src/helpers.php';

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
        render('index', ['lang' => $lang]);
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
            render('error', [
                'lang'    => $lang,
                'code'    => 404,
                'message' => t('error.not_found'),
            ]);
            return;
        }

        render('legal', [
            'lang' => $lang,
            'slug' => $slug,
            'doc'  => $langData['legal'][$slug],
        ]);
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
        echo "User-agent: *\nAllow: /\nSitemap: https://ternis.dev/sitemap.xml\n";
    }
});

// sitemap.xml — dynamically generated
$router->get('/sitemap.xml', function () {
    header('Content-Type: application/xml; charset=utf-8');
    header('X-Content-Type-Options: nosniff');
    header('X-Robots-Tag: noindex, follow');
    header('X-Sitemap: true');
    header('X-Sitemap-Format: XML');
    header('X-Sitemap-Type: urlset');
    header('X-Sitemap-Version: 0.9');
    header('Cache-Control: public, max-age=3600, stale-while-revalidate=86400');
    header('Access-Control-Allow-Origin: *');
    render('sitemap');
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
    render('error', [
        'lang'    => $lang,
        'code'    => 404,
        'message' => t('error.not_found'),
    ]);
});
