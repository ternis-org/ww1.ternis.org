---
title: PHP 8.3 Getting Started — Installation, CLI Server, Routing, and OPcache
description: Complete beginner guide to modern PHP 8.3, package installation, CLI development server flags, building a front controller micro-router, and OPcache.
category: php
order: 10
tags: [php, backend, web-development, router, opcache, beginner]
updated: 2026-10-06
related: [php/pdo-mysql-guide, selfhosting/nginx-reverse-proxy-tls]
---

## Modern PHP: What has changed

Forget outdated stereotypes of PHP from 2005. Modern **PHP 8.3+** is a fast, strictly-typed, modern language featuring JIT compilation, match expressions, readonly classes, first-class callables, and strong typing.

PHP powers over 75% of the web's content management systems and countless high-performance APIs. It requires no complex build steps or compilation phases—edit a file, save it, and refresh your browser.

---

## Step 1: Installing PHP 8.3 and essential extensions

On modern Debian or Ubuntu systems:

```bash
sudo apt update
sudo apt install -y php8.3-cli php8.3-common php8.3-mbstring php8.3-xml php8.3-curl php8.3-opcache
```

### Package breakdown

- `php8.3-cli`: The Command Line Interface binary (`/usr/bin/php`), required for terminal scripts and running the built-in development server.
- `php8.3-common`: Core shared documentation and configuration files.
- `php8.3-mbstring`: Multibyte string support, essential for international UTF-8 characters and emojis.
- `php8.3-xml`: XML and DOM document parsing extensions.
- `php8.3-curl`: High-performance HTTP client library for calling external REST APIs.
- `php8.3-opcache`: The bytecode caching engine that accelerates production execution by up to 300%.

### Verification commands & flag breakdown

```bash
# Check installed PHP version and Zend Engine
php -v

# List all compiled and active PHP modules
php -m

# Search for a specific module (e.g. mbstring)
php -m | grep -i mbstring
```

- `-v` (version): Prints the exact PHP release, compilation date, and active JIT/Zend engine details.
- `-m` (modules): Displays an alphabetical list of every loaded extension module.

---

## Step 2: Instant local development with the built-in server

You do not need Apache or Nginx to develop PHP locally on your laptop. PHP includes a lightweight web server built directly into the CLI binary:

```bash
php -S 127.0.0.1:8000 -t public/ public/index.php
```

### Command & flag breakdown

- `php`: The PHP CLI executable.
- `-S 127.0.0.1:8000`: Launches the built-in development web server listening on localhost port 8000.
- `-t public/`: Sets the **document root** directory. Static files (CSS, JS, images) inside this directory are served directly.
- `public/index.php`: The optional **router script**. Any HTTP request that does not match an existing static file is routed through this single entry file. This matches the exact production architecture of `ww1.ternis.org`!

---

## Step 3: Building a Front Controller Micro-Router

In modern web development, all HTTP requests flow through a single entry file (`public/index.php`). This is the **Front Controller pattern**:

Create `public/index.php`:

```php
<?php
declare(strict_types=1);

// 1. Extract the clean URL path without query parameters (?page=2)
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($requestUri, PHP_URL_PATH);

// 2. Simple route matching
if ($path === '/') {
    echo '<h1>Welcome to ternis.org!</h1>';
} elseif (preg_match('#^/hello/(?P<name>[a-zA-Z0-9_-]+)$#', $path, $matches)) {
    // Sanitize user input before outputting to prevent Cross-Site Scripting (XSS)
    $name = htmlspecialchars($matches['name'], ENT_QUOTES, 'UTF-8');
    echo "<h1>Hello, {$name}!</h1>";
} else {
    // Return standard HTTP 404 header
    http_response_code(404);
    echo '<h1>404 Not Found</h1>';
}
```

### Security rule: Always escape HTML output

:::warn
**Never echo raw user input directly into HTML!**
`echo $_GET['name'];` allows attackers to inject malicious JavaScript (`<script>alert(1)</script>`), stealing user sessions. Always wrap output in `htmlspecialchars($var, ENT_QUOTES, 'UTF-8')`.
:::

---

## Step 4: Turbocharging performance with OPcache

In traditional interpreted execution, PHP reads `.php` files from disk, parses syntax, and compiles them into machine bytecode on **every single HTTP request**.

**OPcache** eliminates this overhead completely:
1. When a script runs for the first time, OPcache compiles it into opcode and caches the compiled result directly in server RAM.
2. Subsequent requests execute pre-compiled opcode straight from memory without touching the disk.

Verify OPcache is active in your terminal:

```bash
php -i | grep -i "opcache.enable"
```
