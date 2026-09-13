<?php

declare(strict_types=1);

/**
 * Global helper functions for ternis.org
 */

/**
 * Sends standard modern security headers across all responses.
 */
function send_security_headers(): void
{
    if (headers_sent()) {
        return;
    }

    header_remove('X-Powered-By');
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=()');
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com data:; img-src 'self' data: https:; connect-src 'self' https://api.getmy.name; base-uri 'self'; form-action 'self'; frame-ancestors 'self';");
}

/**
 * Returns full absolute canonical URL for a given relative path or current request.
 */
function canonical_url(?string $path = null): string
{
    $base = rtrim((string) config('app_url', 'https://ternis.org'), '/');
    if ($path === null) {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
    }
    return $base . '/' . ltrim($path, '/');
}

/**
 * Escapes HTML entities safely for strings, integers, floats or null.
 */
function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Loads language dictionary file and stores in global state.
 */
function load_lang(string $lang): array
{
    $file = ROOT_PATH . '/lang/' . $lang . '.php';
    if (file_exists($file)) {
        $GLOBALS['_lang_data'] = require $file;
    } else {
        $GLOBALS['_lang_data'] = [];
    }
    return $GLOBALS['_lang_data'];
}

/**
 * Returns current language dictionary.
 */
function lang_data(): array
{
    return $GLOBALS['_lang_data'] ?? [];
}

/**
 * Returns active language code.
 */
function current_lang(): string
{
    return defined('LANG') ? LANG : (defined('DEFAULT_LANG') ? DEFAULT_LANG : 'en');
}

/**
 * Translates a key with dot-notation support and token replacements.
 * Returns array if key references an array, or string if key references a string.
 * Example: t('hero.title', ['name' => 'ternis'])
 */
function t(string $key, array $replacements = [], mixed $default = null): mixed
{
    $data = $GLOBALS['_lang_data'] ?? [];
    $keys = explode('.', $key);
    $current = $data;

    foreach ($keys as $k) {
        if (!is_array($current) || !array_key_exists($k, $current)) {
            return $default ?? $key;
        }
        $current = $current[$k];
    }

    if (is_array($current)) {
        return $current;
    }

    if (!is_string($current)) {
        return $default ?? (string) $current;
    }

    foreach ($replacements as $placeholder => $replacement) {
        $current = str_replace(
            ['{{' . $placeholder . '}}', ':' . $placeholder, '{' . $placeholder . '}'],
            (string) $replacement,
            $current
        );
    }

    return $current;
}

/**
 * Returns translation array safely, or empty array if not array.
 */
function t_array(string $key, array $default = []): array
{
    $val = t($key, [], $default);
    return is_array($val) ? $val : $default;
}

/**
 * Detects preferred language from Accept-Language header.
 */
function detect_preferred_lang(array $supported, string $default): string
{
    $header = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';
    if (empty($header)) {
        return $default;
    }

    $langs = [];
    $parts = explode(',', $header);
    foreach ($parts as $part) {
        $sub = explode(';', trim($part));
        $langCode = strtolower(trim($sub[0]));
        $q = 1.0;
        if (isset($sub[1]) && preg_match('/q=([0-9.]+)/i', $sub[1], $m)) {
            $q = (float) $m[1];
        }
        // Extract 2-letter primary subtag
        $primary = explode('-', $langCode)[0];
        $langs[$primary] = max($langs[$primary] ?? 0.0, $q);
    }

    arsort($langs);

    foreach (array_keys($langs) as $candidate) {
        if (in_array($candidate, $supported, true)) {
            return $candidate;
        }
    }

    return $default;
}

/**
 * Redirects to a new URL and terminates.
 */
function redirect(string $url, int $statusCode = 302): void
{
    header('Location: ' . $url, true, $statusCode);
    exit;
}

/**
 * Renders a reusable UI component with data extracted into scope.
 */
function component(string $name, array $data = []): void
{
    $componentFile = ROOT_PATH . '/src/views/components/' . $name . '.php';
    if (!file_exists($componentFile)) {
        echo '<!-- Component not found: ' . e($name) . ' -->';
        return;
    }

    extract($data, EXTR_SKIP);
    require $componentFile;
}

/**
 * Renders content wrapped inside a layout template.
 */
function render_layout(string $layout, string $content, array $data = []): void
{
    $layoutFile = ROOT_PATH . '/src/views/layouts/' . $layout . '.php';
    if (!file_exists($layoutFile)) {
        echo $content;
        return;
    }

    $data['slot'] = $content;
    extract($data, EXTR_SKIP);
    require $layoutFile;
}

/**
 * Renders a view file with data extracted into scope.
 */
function render(string $view, array $data = [], ?string $layout = null): void
{
    $viewFile = ROOT_PATH . '/src/views/' . $view . '.php';
    if (!file_exists($viewFile)) {
        http_response_code(500);
        echo 'View not found: ' . e($view);
        exit;
    }

    if ($layout !== null) {
        ob_start();
        extract($data, EXTR_SKIP);
        require $viewFile;
        $content = (string) ob_get_clean();
        render_layout($layout, $content, $data);
        return;
    }

    extract($data, EXTR_SKIP);
    require $viewFile;
}

/**
 * Serves a static asset safely with cache headers, MIME detection, and traversal protection.
 */
function serve_static_file(string $filePath, string $allowedDir): void
{
    $realAllowed = realpath($allowedDir);
    $realPath    = realpath($filePath);

    if ($realAllowed === false || $realPath === false || !str_starts_with($realPath, $realAllowed)) {
        http_response_code(404);
        echo '404 File Not Found';
        exit;
    }

    if (!is_file($realPath) || !is_readable($realPath)) {
        http_response_code(404);
        echo '404 File Not Found';
        exit;
    }

    $extension = strtolower(pathinfo($realPath, PATHINFO_EXTENSION));
    $mimeTypes = [
        'css'         => 'text/css; charset=utf-8',
        'js'          => 'application/javascript; charset=utf-8',
        'mjs'         => 'application/javascript; charset=utf-8',
        'json'        => 'application/json; charset=utf-8',
        'webmanifest' => 'application/manifest+json; charset=utf-8',
        'xml'         => 'application/xml; charset=utf-8',
        'txt'         => 'text/plain; charset=utf-8',
        'svg'         => 'image/svg+xml',
        'png'         => 'image/png',
        'jpg'         => 'image/jpeg',
        'jpeg'        => 'image/jpeg',
        'webp'        => 'image/webp',
        'gif'         => 'image/gif',
        'ico'         => 'image/x-icon',
        'woff2'       => 'font/woff2',
        'woff'        => 'font/woff',
        'ttf'         => 'font/ttf',
    ];

    $mime = $mimeTypes[$extension] ?? 'application/octet-stream';

    $lastModified = filemtime($realPath);
    $etag         = '"' . md5($lastModified . filesize($realPath)) . '"';

    header_remove('X-Powered-By');
    header('Content-Type: ' . $mime);
    header('Cache-Control: public, max-age=31536000, immutable');
    header('ETag: ' . $etag);
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $lastModified) . ' GMT');
    header('X-Content-Type-Options: nosniff');
    header('Access-Control-Allow-Origin: *');

    if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && trim($_SERVER['HTTP_IF_NONE_MATCH']) === $etag) {
        http_response_code(304);
        exit;
    }

    if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $lastModified) {
        http_response_code(304);
        exit;
    }

    if (strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'HEAD') {
        exit;
    }

    readfile($realPath);
    exit;
}

/**
 * Returns version hash for cache-busting and API.
 */
function app_version_hash(bool $short = true): string
{
    static $hash = null;
    if ($hash === null) {
        $gitHead = ROOT_PATH . '/.git/HEAD';
        if (file_exists($gitHead)) {
            $headContent = trim((string) file_get_contents($gitHead));
            if (str_starts_with($headContent, 'ref: ')) {
                $refFile = ROOT_PATH . '/.git/' . substr($headContent, 5);
                if (file_exists($refFile)) {
                    $hash = trim((string) file_get_contents($refFile));
                }
            } else {
                $hash = $headContent;
            }
        }
        if (empty($hash)) {
            $hash = 'v1.0.' . date('Ymd');
        }
    }

    return $short ? substr($hash, 0, 7) : $hash;
}

/**
 * Generates an asset URL with cache-busting query param.
 */
function asset_url(string $path): string
{
    $version = app_version_hash(true);
    return '/' . ltrim($path, '/') . '?v=' . $version;
}

/**
 * Switch language URL generator while preserving current path.
 */
function lang_url(string $targetLang, ?string $currentPath = null): string
{
    $path = $currentPath ?? parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
    $segments = explode('/', trim($path, '/'));

    if (!empty($segments) && in_array($segments[0], ['en', 'de'], true)) {
        $segments[0] = $targetLang;
        return '/' . implode('/', $segments);
    }

    return '/' . $targetLang;
}

/**
 * Retrieves configuration values by key with dot notation and default fallback.
 */
function config(?string $key = null, mixed $default = null): mixed
{
    static $config = null;
    if ($config === null) {
        $configFile = ROOT_PATH . '/src/config.php';
        $config = file_exists($configFile) ? require $configFile : [];
    }

    if ($key === null) {
        return $config;
    }

    $keys = explode('.', $key);
    $current = $config;
    foreach ($keys as $segment) {
        if (!is_array($current) || !array_key_exists($segment, $current)) {
            return $default;
        }
        $current = $current[$segment];
    }

    return $current;
}

/**
 * Returns repository URL from configuration.
 */
function app_repo_url(): string
{
    return (string) config('repo_url', 'https://github.com/ternis-org/ww1.ternis.org');
}

/**
 * Returns repository commit URL for a given hash.
 */
function app_repo_commit_url(?string $hash = null): string
{
    $repo = rtrim(app_repo_url(), '/');
    if ($hash === null || $hash === '') {
        $hash = app_version_hash(false);
    }
    // If hash is a fallback e.g. v1.0.2026..., link to the main repo page
    if (str_starts_with($hash, 'v1.0.')) {
        return $repo;
    }
    return $repo . '/commit/' . $hash;
}

