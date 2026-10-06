---
title: PHP-Einstieg — Installieren, Serven, Routen
description: PHP 8.3 installieren, Built-in-Server starten, OPcache aktivieren und einen ersten Micro-Router bauen wie ternis.org.
category: php
order: 10
tags: [php, einstieg, router]
updated: 2026-10-06
related: [php/pdo-mysql-guide]
---

## Installieren

```bash
sudo apt install php8.3 php8.3-cli php8.3-mbstring php8.3-xml
php -v
```

## Ein Verzeichnis sofort ausliefern

```bash
php -S 127.0.0.1:8000 public/index.php
```

Genau so läuft ternis.org lokal — kein Apache für die Entwicklung nötig.

## Dein erster Router

```php
<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if ($path === '/') {
    echo 'Hallo, Web!';
} elseif (preg_match('#^/hallo/(?P<name>[a-z-]+)$#', $path, $m)) {
    echo 'Hallo, ' . htmlspecialchars($m['name']) . '!';
} else {
    http_response_code(404);
    echo 'Nicht gefunden';
}
```

## OPcache aktivieren

```bash
sudo apt install php8.3-opcache
php -m | grep -i opcache
```

:::tip
Ausgaben immer mit `htmlspecialchars()` escapen (diese Seite nutzt dafür den
`e()`-Helper in `src/helpers.php`). Unescapte Ausgabe ist eine XSS-Lücke.
:::
