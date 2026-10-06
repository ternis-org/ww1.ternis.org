---
title: PHP 8.3 Erste Schritte — Installation, CLI-Server, Routing und OPcache
description: Einsteigerfreundliche Anleitung zu modernem PHP 8.3, Paketinstallation, Flags des integrierten Entwicklungsservers, Bau eines Front-Controller-Routers und OPcache.
category: php
order: 10
tags: [php, backend, webentwicklung, router, opcache, einsteiger]
updated: 2026-10-06
related: [php/pdo-mysql-guide, selfhosting/nginx-reverse-proxy-tls]
---

## Modernes PHP: Schnell, typsicher und robust

Modernes **PHP 8.3+** hat nichts mehr mit altem PHP-Code aus den 2000ern gemein. Mit strikter Typisierung (`declare(strict_types=1);`), JIT-Compiler, Match-Expressions, Readonly-Klassen und Enums gehört PHP heute zu den schnellsten Skriptsprachen der Webentwicklung.

---

## 1. Installation unter Debian und Ubuntu

```bash
sudo apt update
sudo apt install -y php8.3-cli php8.3-common php8.3-mbstring php8.3-xml php8.3-curl php8.3-opcache
```

### Die Pakete im Überblick

- `php8.3-cli`: Der Befehlszeilen-Interpreter für die Ausführung im Terminal und den integrierten Server.
- `php8.3-mbstring`: Multibyte-Unterstützung für UTF-8 und Sonderzeichen.
- `php8.3-curl`: Für HTTP-Anfragen an externe REST-APIs.
- `php8.3-opcache`: Cacht vorkompilierten Bytecode direkt im Arbeitsspeicher.

### Version und Module prüfen

```bash
# Version und Zend-Engine anzeigen
php -v

# Installierte Module auflisten
php -m | grep -i mbstring
```

---

## 2. Der integrierte Entwicklungsserver

Für die lokale Entwicklung auf deinem Rechner brauchst du weder Apache noch Nginx. PHP bringt einen eigenen Webserver mit:

```bash
php -S 127.0.0.1:8000 -t public/ public/index.php
```

### Erklärung der Flags

- `-S 127.0.0.1:8000`: Startet den Server auf der lokalen IP 127.0.0.1 und Port 8000.
- `-t public/`: Legt das Verzeichnis `public/` als **Document Root** fest (statische CSS/JS-Dateien werden direkt ausgeliefert).
- `public/index.php`: Das Router-Skript, an das alle dynamischen URLs weitergeleitet werden.

---

## 3. Ein minimalistischer Micro-Router

Erstelle `public/index.php`:

```php
<?php
declare(strict_types=1);

$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($requestUri, PHP_URL_PATH);

if ($path === '/') {
    echo '<h1>Willkommen bei ternis.org!</h1>';
} elseif (preg_match('#^/hello/(?P<name>[a-zA-Z0-9_-]+)$#', $path, $matches)) {
    // Vor Ausgabe zwingend maskieren, um Cross-Site Scripting (XSS) zu verhindern:
    $name = htmlspecialchars($matches['name'], ENT_QUOTES, 'UTF-8');
    echo "<h1>Hallo, {$name}!</h1>";
} else {
    http_response_code(404);
    echo '<h1>404 Nicht gefunden</h1>';
}
```

:::warn
Niemals ungefilterte Nutzereingaben direkt ausgeben (`echo $_GET['name'];`). Nutze immer `htmlspecialchars()`, um XSS-Angriffe abzuwehren.
:::

---

## 4. OPcache: Maximale Geschwindigkeit im Produktivbetrieb

Normalerweise parst PHP Skripte bei jeder Anfrage neu. **OPcache** kompiliert den Code einmalig in Maschinencode (Opcode) und speichert ihn im RAM. Nachfolgende Anfragen werden ohne erneutes Kompilieren extrem schnell beantwortet.
