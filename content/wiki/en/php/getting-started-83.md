---
title: PHP Getting Started — Install, Serve, Route
description: Install PHP 8.3, run the built-in server, enable OPcache, and build a first micro-router like ternis.org uses.
category: php
order: 10
tags: [php, getting-started, router]
updated: 2026-10-06
related: [php/pdo-mysql-guide]
---

## Install

```bash
sudo apt install php8.3 php8.3-cli php8.3-mbstring php8.3-xml
php -v
```

## Serve a folder instantly

```bash
php -S 127.0.0.1:8000 public/index.php
```

This is exactly how ternis.org runs locally — no Apache needed for development.

## Your first router

```php
<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if ($path === '/') {
    echo 'Hello, web!';
} elseif (preg_match('#^/hello/(?P<name>[a-z-]+)$#', $path, $m)) {
    echo 'Hello, ' . htmlspecialchars($m['name']) . '!';
} else {
    http_response_code(404);
    echo 'Not found';
}
```

## Enable OPcache

```bash
sudo apt install php8.3-opcache
php -m | grep -i opcache
```

:::tip
Always escape output with `htmlspecialchars()` (this site wraps it in an `e()`
helper in `src/helpers.php`). Unescaped output is an XSS vulnerability.
:::
