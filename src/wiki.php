<?php

declare(strict_types=1);

/**
 * Wiki engine for ternis.org — flat-file Markdown knowledge base at /wiki/.
 *
 * Storage: content/wiki/{lang}/{category}/{slug}.md with frontmatter.
 * No database, no Composer dependency. Fully separated assets:
 *   assets/css/wiki.css + assets/js/wiki.js (loaded only on wiki pages).
 */

const WIKI_CONTENT_DIR = ROOT_PATH . '/content/wiki';
const WIKI_SLUG_RE = '/^[a-z0-9-]+$/';

/**
 * Canonical wiki category registry. Slugs are stable English; display titles are bilingual.
 *
 * @return array<string, array{icon: string, en: string, de: string, desc_en: string, desc_de: string, order: int}>
 */
function wiki_categories(): array
{
    return [
        'networking'     => ['icon' => 'globe', 'en' => 'Networking', 'de' => 'Netzwerke', 'desc_en' => 'OSI, TCP/IP, subnetting, VLANs, NAT, firewalls, reverse proxies.', 'desc_de' => 'OSI, TCP/IP, Subnetting, VLANs, NAT, Firewalls, Reverse-Proxys.', 'order' => 10],
        'homelab'        => ['icon' => 'server', 'en' => 'Homelab', 'de' => 'Homelab', 'desc_en' => 'Proxmox, Docker, NAS, backups, UPS, remote access, monitoring.', 'desc_de' => 'Proxmox, Docker, NAS, Backups, USV, Fernzugriff, Monitoring.', 'order' => 20],
        'domains'        => ['icon' => 'link', 'en' => 'Domains', 'de' => 'Domains', 'desc_en' => 'How domains work, TLDs, dnbx.de, WHOIS, transfers, delegation.', 'desc_de' => 'Wie Domains funktionieren, TLDs, dnbx.de, WHOIS, Transfers, Delegierung.', 'order' => 30],
        'dns'            => ['icon' => 'signal', 'en' => 'DNS', 'de' => 'DNS', 'desc_en' => 'Records, DNSSEC, dig/host debugging, authoritative DNS with example-dns.', 'desc_de' => 'Records, DNSSEC, Debugging mit dig/host, autoritatives DNS mit example-dns.', 'order' => 40],
        'sql'            => ['icon' => 'table', 'en' => 'SQL', 'de' => 'SQL', 'desc_en' => 'SELECT, JOINs, indexes, transactions, backups.', 'desc_de' => 'SELECT, JOINs, Indizes, Transaktionen, Backups.', 'order' => 50],
        'linux'          => ['icon' => 'terminal', 'en' => 'Linux', 'de' => 'Linux', 'desc_en' => 'Filesystem, permissions, SSH, systemd, logs.', 'desc_de' => 'Dateisystem, Rechte, SSH, systemd, Logs.', 'order' => 60],
        'ubuntu'         => ['icon' => 'orbit', 'en' => 'Ubuntu', 'de' => 'Ubuntu', 'desc_en' => 'APT, UFW, users and sudo on Ubuntu.', 'desc_de' => 'APT, UFW, Benutzer und sudo unter Ubuntu.', 'order' => 70],
        'mysql-mariadb'  => ['icon' => 'database', 'en' => 'MySQL & MariaDB', 'de' => 'MySQL & MariaDB', 'desc_en' => 'Choosing, installing, users, backups, small-VPS tuning.', 'desc_de' => 'Auswahl, Installation, Benutzer, Backups, Tuning für kleine VPS.', 'order' => 80],
        'phpmyadmin'     => ['icon' => 'sliders', 'en' => 'phpMyAdmin', 'de' => 'phpMyAdmin', 'desc_en' => 'Install, daily workflows, hardening checklist.', 'desc_de' => 'Installation, Arbeitsabläufe, Hardening-Checkliste.', 'order' => 90],
        'php'            => ['icon' => 'code', 'en' => 'PHP', 'de' => 'PHP', 'desc_en' => 'Getting started, forms security, PDO with MySQL.', 'desc_de' => 'Einstieg, Formular-Sicherheit, PDO mit MySQL.', 'order' => 100],
        'javascript'     => ['icon' => 'bolt', 'en' => 'JavaScript', 'de' => 'JavaScript', 'desc_en' => 'fetch, framework-free DOM, theme-toggle pattern.', 'desc_de' => 'fetch, DOM ohne Framework, Theme-Toggle-Muster.', 'order' => 110],
        'css'            => ['icon' => 'brush', 'en' => 'CSS', 'de' => 'CSS', 'desc_en' => 'Grid vs flexbox, variables & dark mode, responsive basics.', 'desc_de' => 'Grid vs Flexbox, Variablen & Dark Mode, Responsive-Grundlagen.', 'order' => 120],
        'selfhosting'    => ['icon' => 'cube', 'en' => 'Self-Hosting', 'de' => 'Self-Hosting', 'desc_en' => 'Nginx reverse proxy, TLS, Docker Compose patterns.', 'desc_de' => 'Nginx Reverse-Proxy, TLS, Docker-Compose-Muster.', 'order' => 130],
        'security'       => ['icon' => 'lock', 'en' => 'Security', 'de' => 'Sicherheit', 'desc_en' => "Let's Encrypt, TLS, the 3-2-1 backup rule.", 'desc_de' => "Let's Encrypt, TLS, die 3-2-1-Backup-Regel.", 'order' => 140],
        'git-devops'     => ['icon' => 'branch', 'en' => 'Git & DevOps', 'de' => 'Git & DevOps', 'desc_en' => 'Git crash course, contributing to this wiki.', 'desc_de' => 'Git-Crashkurs, zu diesem Wiki beitragen.', 'order' => 150],
    ];
}

/**
 * Inline SVG icon set for the wiki (no emoji, no external assets).
 * 24×24 outline icons, currentColor. Returns an <svg> string.
 */
function wiki_icon(string $name): string
{
    static $icons = [
        'globe'    => '<circle cx="12" cy="12" r="8.5"/><path d="M3.5 12h17M12 3.5c3.2 3.6 3.2 13.4 0 17M12 3.5c-3.2 3.6-3.2 13.4 0 17"/>',
        'server'   => '<rect x="3" y="4" width="18" height="7" rx="1.5"/><rect x="3" y="13" width="18" height="7" rx="1.5"/><path d="M6.5 7.5h.01M6.5 16.5h.01"/>',
        'link'     => '<path d="M10 14a5 5 0 0 0 7.1 0l2.8-2.8a5 5 0 0 0-7-7.1l-1.6 1.6M14 10a5 5 0 0 0-7.1 0l-2.8 2.8a5 5 0 0 0 7 7.1l1.6-1.6"/>',
        'signal'   => '<path d="M5 10a10 10 0 0 1 14 0M8 13a6 6 0 0 1 8 0"/><path d="M12 17.2h.01"/>',
        'table'    => '<rect x="3" y="4" width="18" height="16" rx="1.5"/><path d="M3 9.5h18M9.5 9.5V20"/>',
        'terminal' => '<rect x="3" y="4" width="18" height="16" rx="2"/><path d="M7 9.5l2.8 2.8L7 15M12.5 15H17"/>',
        'orbit'    => '<circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="1.3"/><circle cx="12" cy="5.8" r="1.1"/><circle cx="17.4" cy="15.1" r="1.1"/><circle cx="6.6" cy="15.1" r="1.1"/>',
        'database' => '<ellipse cx="12" cy="5.5" rx="8" ry="2.8"/><path d="M4 5.5v13c0 1.6 3.6 2.9 8 2.9s8-1.3 8-2.9v-13M4 12c0 1.6 3.6 2.9 8 2.9s8-1.3 8-2.9"/>',
        'sliders'  => '<path d="M4 8h9M17.5 8H20M4 16h3.5M12 16h8"/><circle cx="15.5" cy="8" r="2"/><circle cx="10" cy="16" r="2"/>',
        'code'     => '<path d="M8.5 7L3.5 12l5 5M15.5 7l5 5-5 5M13.2 4.5l-2.4 15"/>',
        'bolt'     => '<path d="M13 2.5L4.5 13.5H11l-1 8 8.5-11H12l1-8z"/>',
        'brush'    => '<path d="M12 3.5a8.5 8.5 0 1 0 .01 17c1.4 0 1.9-.9 1.4-1.9-.5-1.2.3-2.4 1.6-2.4h1.6a3.9 3.9 0 0 0 3.9-3.9C20.5 7.4 16.6 3.5 12 3.5z"/><path d="M7.6 11.4h.01M11 7.6h.01"/>',
        'cube'     => '<path d="M12 2.5l8.5 4.8v9.4L12 21.5l-8.5-4.8V7.3L12 2.5zM3.5 7.3L12 12l8.5-4.7M12 12v9.5"/>',
        'lock'     => '<rect x="5" y="10.5" width="14" height="10" rx="2"/><path d="M8 10.5V7.5a4 4 0 0 1 8 0v3"/>',
        'branch'   => '<circle cx="6" cy="5" r="2"/><circle cx="6" cy="19" r="2"/><circle cx="18" cy="7" r="2"/><path d="M6 7v10M18 9c0 4.5-6.5 3-9.5 5.5"/>',
        'search'   => '<circle cx="11" cy="11" r="7"/><path d="M20 20l-3.8-3.8"/>',
        'arrow'    => '<path d="M4 12h15M13 6l6 6-6 6"/>',
    ];
    $inner = $icons[$name] ?? $icons['globe'];
    return '<svg class="wiki-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" '
        . 'stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'
        . $inner . '</svg>';
}

/**
 * Validates a category/slug segment.
 */
function wiki_valid_segment(string $segment): bool
{
    return strlen($segment) > 0 && strlen($segment) <= 80 && (bool) preg_match(WIKI_SLUG_RE, $segment);
}

/**
 * Resolves a wiki markdown file with traversal protection.
 */
function wiki_source_file(string $lang, string $category, string $slug): ?string
{
    if (!wiki_valid_segment($category) || !wiki_valid_segment($slug)) {
        return null;
    }
    $base = realpath(WIKI_CONTENT_DIR);
    if ($base === false) {
        return null;
    }
    $candidate = WIKI_CONTENT_DIR . '/' . $lang . '/' . $category . '/' . $slug . '.md';
    $real = realpath($candidate);
    if ($real === false || !str_starts_with($real, $base) || !is_file($real) || !is_readable($real)) {
        return null;
    }
    return $real;
}

/**
 * Parses frontmatter (--- block) + body. Returns [meta, body].
 */
function wiki_frontmatter_parse(string $raw): array
{
    $meta = [];
    $body = $raw;
    if (str_starts_with($raw, "---\n") || str_starts_with($raw, "---\r\n")) {
        $end = strpos($raw, "\n---", 3);
        if ($end !== false) {
            $front = substr($raw, 4, $end - 4);
            $body = ltrim(substr($raw, $end + 4));
            foreach (preg_split('/\r?\n/', $front) as $line) {
                $line = trim($line);
                if ($line === '' || str_starts_with($line, '#') || !str_contains($line, ':')) {
                    continue;
                }
                [$k, $v] = explode(':', $line, 2);
                $k = trim($k);
                $v = trim($v, " \t\"'");
                if (in_array($k, ['tags', 'related'], true) && str_starts_with($v, '[')) {
                    $v = array_values(array_filter(array_map(
                        static fn($s) => trim($s, " \t\"'"),
                        explode(',', trim($v, '[]'))
                    )));
                }
                if ($k === 'draft') {
                    $v = filter_var($v, FILTER_VALIDATE_BOOLEAN);
                }
                if ($k === 'order') {
                    $v = (int) $v;
                }
                $meta[$k] = $v;
            }
        }
    }
    return [$meta, $body];
}

/**
 * Minimal Markdown → HTML renderer (subset). Escapes raw HTML by design.
 */
function wiki_markdown_to_html(string $md): string
{
    $lines = preg_split('/\r?\n/', $md);
    $html = '';
    $inCode = false;
    $codeLang = '';
    $codeBuf = [];
    $inList = false;
    $listTag = '';
    $inTable = false;
    $tableRows = [];
    $inAdmonition = false;
    $admonKind = '';
    $admonBuf = [];
    $paragraph = [];

    $flushParagraph = static function () use (&$html, &$paragraph) {
        if ($paragraph !== []) {
            $html .= '<p>' . wiki_inline(implode(' ', $paragraph)) . "</p>\n";
            $paragraph = [];
        }
    };
    $closeList = static function () use (&$html, &$inList, &$listTag) {
        if ($inList) {
            $html .= $listTag === 'ol' ? "</ol>\n" : "</ul>\n";
            $inList = false;
            $listTag = '';
        }
    };
    $flushTable = static function () use (&$html, &$inTable, &$tableRows) {
        if ($inTable && $tableRows !== []) {
            $html .= "<div class=\"wiki-table-wrap\"><table>\n";
            foreach ($tableRows as $i => $row) {
                $cells = array_map('trim', explode('|', trim($row, " \t|")));
                $tag = $i === 0 ? 'th' : 'td';
                $html .= '<tr>';
                foreach ($cells as $c) {
                    $html .= "<{$tag}>" . wiki_inline($c) . "</{$tag}>";
                }
                $html .= "</tr>\n";
            }
            $html .= "</table></div>\n";
            $tableRows = [];
            $inTable = false;
        }
    };
    $flushAdmonition = static function () use (&$html, &$inAdmonition, &$admonKind, &$admonBuf) {
        if ($inAdmonition) {
            $label = $admonKind === 'warn' ? 'Note' : 'Tip';
            $html .= '<div class="wiki-admon wiki-admon-' . e($admonKind) . '" role="note"><strong>' . $label . ':</strong> '
                . wiki_inline(implode(' ', $admonBuf)) . "</div>\n";
            $inAdmonition = false;
            $admonKind = '';
            $admonBuf = [];
        }
    };

    foreach ($lines as $line) {
        // Fenced code blocks
        if (preg_match('/^```(\w[\w+-]*)\s*$/', trim($line), $m) && !$inCode) {
            $flushParagraph();
            $closeList();
            $flushTable();
            $inCode = true;
            $codeLang = $m[1];
            $codeBuf = [];
            continue;
        }
        if (trim($line) === '```' && $inCode) {
            $code = htmlspecialchars(implode("\n", $codeBuf), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
            $copy = htmlspecialchars(implode("\n", $codeBuf), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
            $html .= '<div class="wiki-codeblock"><div class="wiki-codeblock-bar"><span class="wiki-codeblock-lang">'
                . e($codeLang !== '' ? $codeLang : 'code')
                . '</span><button type="button" class="wiki-copy-btn" data-copy="' . $copy
                . '" aria-label="Copy code">Copy</button></div><pre><code class="language-'
                . e($codeLang !== '' ? $codeLang : 'text') . '">' . $code . "</code></pre></div>\n";
            $inCode = false;
            $codeLang = '';
            $codeBuf = [];
            continue;
        }
        if ($inCode) {
            $codeBuf[] = $line;
            continue;
        }

        $t = trim($line);

        // Admonitions: :::tip ... ::: / :::warn ... :::
        if (preg_match('/^:::(tip|warn)\s*$/', $t, $m)) {
            $flushParagraph();
            $closeList();
            $inAdmonition = true;
            $admonKind = $m[1];
            $admonBuf = [];
            continue;
        }
        if ($t === ':::' && $inAdmonition) {
            $flushAdmonition();
            continue;
        }
        if ($inAdmonition) {
            if ($t !== '') {
                $admonBuf[] = $t;
            }
            continue;
        }

        if ($t === '') {
            $flushParagraph();
            $closeList();
            $flushTable();
            continue;
        }
        if ($t === '---') {
            $flushParagraph();
            $closeList();
            $flushTable();
            $html .= "<hr>\n";
            continue;
        }
        // Tables
        if (str_contains($t, '|') && preg_match('/^\|?[\s\w`.*\-\|:?.()@\/]+\|?$/', $t)) {
            $next = true;
            if (preg_match('/^\|?[\s:\-|]+\|?$/', $t)) {
                $inTable = true;
                continue;
            }
            if ($next) {
                $flushParagraph();
                $closeList();
                $inTable = true;
                $tableRows[] = $t;
                continue;
            }
        } else {
            $flushTable();
        }
        // Headings
        if (preg_match('/^(#{1,4})\s+(.+)$/', $t, $m)) {
            $flushParagraph();
            $closeList();
            $level = strlen($m[1]);
            $text = trim($m[2]);
            $id = wiki_heading_id($text);
            $html .= "<h{$level} id=\"" . e($id) . '"><a class="wiki-anchor" href="#' . e($id) . '" aria-hidden="true">#</a> ' . wiki_inline($text) . "</h{$level}>\n";
            continue;
        }
        // Blockquote
        if (str_starts_with($t, '>')) {
            $flushParagraph();
            $closeList();
            $html .= '<blockquote>' . wiki_inline(ltrim($t, '> ')) . "</blockquote>\n";
            continue;
        }
        // Lists
        if (preg_match('/^([-*]|\d+\.)\s+(.+)$/', $t, $m)) {
            $flushParagraph();
            $flushTable();
            $tag = $m[1] === '-' || $m[1] === '*' ? 'ul' : 'ol';
            if (!$inList || $listTag !== $tag) {
                $closeList();
                $html .= $tag === 'ol' ? "<ol>\n" : "<ul>\n";
                $inList = true;
                $listTag = $tag;
            }
            $item = $m[2];
            // Task list
            if (preg_match('/^\[([ xX])\]\s+(.+)$/', $item, $tm)) {
                $checked = strtolower($tm[1]) === 'x' ? ' checked disabled' : ' disabled';
                $html .= '<li class="wiki-task"><input type="checkbox"' . $checked . '> ' . wiki_inline($tm[2]) . "</li>\n";
            } else {
                $html .= '<li>' . wiki_inline($item) . "</li>\n";
            }
            continue;
        }
        $paragraph[] = $t;
    }
    $flushParagraph();
    $closeList();
    $flushTable();
    $flushAdmonition();

    return $html;
}

/**
 * Inline Markdown: code, bold, italic, links, images.
 */
function wiki_inline(string $text): string
{
    $text = htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    // Inline code
    $text = (string) preg_replace('/`([^`]+)`/', '<code>$1</code>', $text);
    // Bold + italic
    $text = (string) preg_replace('/\*\*([^*]+)\*\*/', '<strong>$1</strong>', $text);
    $text = (string) preg_replace('/(?<!\*)\*([^*]+)\*(?!\*)/', '<em>$1</em>', $text);
    // Images ![alt](src)
    $text = (string) preg_replace_callback('/!\[([^\]]*)\]\(([^)]+)\)/', static function ($m) {
        $src = trim($m[2]);
        if (!preg_match('#^(https://|/|#)#', $src)) {
            $src = '/' . ltrim($src, '/');
        }
        return '<img src="' . htmlspecialchars($src, ENT_QUOTES, 'UTF-8') . '" alt="' . $m[1] . '" loading="lazy">';
    }, $text);
    // Links [text](url)
    $text = (string) preg_replace_callback('/\[([^\]]+)\]\(([^)]+)\)/', static function ($m) {
        $url = trim($m[2]);
        if (preg_match('#^javascript:#i', $url) || str_starts_with($url, 'data:')) {
            return $m[1];
        }
        $external = str_starts_with($url, 'http://') || str_starts_with($url, 'https://');
        $attrs = $external ? ' target="_blank" rel="noopener noreferrer"' : '';
        return '<a href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '"' . $attrs . '>' . $m[1] . '</a>';
    }, $text);
    return $text;
}

/**
 * Slugifies heading text for anchor ids.
 */
function wiki_heading_id(string $text): string
{
    $text = strtolower(strip_tags($text));
    $text = (string) preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-') ?: 'section';
}

/**
 * Extracts h2/h3 TOC entries from article HTML.
 *
 * @return array<int, array{id: string, level: int, text: string}>
 */
function wiki_toc(string $html): array
{
    $toc = [];
    if (preg_match_all('/<h([23]) id="([^"]+)">(?:<a[^>]*>.*?<\/a>\s*)?(.*?)<\/h[23]>/s', $html, $m, PREG_SET_ORDER)) {
        foreach ($m as $match) {
            $toc[] = ['level' => (int) $match[1], 'id' => $match[2], 'text' => strip_tags($match[3])];
        }
    }
    return $toc;
}

/**
 * Loads one article, with EN fallback when DE is missing.
 *
 * @return array{title: string, description: string, category: string, slug: string, tags: array, updated: string, related: array, order: int, draft: bool, html: string, toc: array, reading_minutes: int, fallback_lang: ?string, source_mtime: int}|null
 */
function wiki_get_article(string $lang, string $category, string $slug): ?array
{
    $cats = wiki_categories();
    if (!isset($cats[$category])) {
        return null;
    }
    $fallbackLang = null;
    $file = wiki_source_file($lang, $category, $slug);
    if ($file === null && $lang !== 'en') {
        $file = wiki_source_file('en', $category, $slug);
        if ($file !== null) {
            $fallbackLang = 'en';
        }
    }
    if ($file === null) {
        return null;
    }
    [$meta, $body] = wiki_frontmatter_parse((string) file_get_contents($file));
    $draft = !empty($meta['draft']);
    if ($draft && !config('app_debug', false)) {
        return null;
    }
    $html = wiki_markdown_to_html($body);
    $words = str_word_count(strip_tags($body));
    return [
        'title' => (string) ($meta['title'] ?? ucfirst(str_replace('-', ' ', $slug))),
        'description' => (string) ($meta['description'] ?? ''),
        'category' => $category,
        'slug' => $slug,
        'tags' => is_array($meta['tags'] ?? null) ? $meta['tags'] : [],
        'updated' => (string) ($meta['updated'] ?? date('Y-m-d', (int) filemtime($file))),
        'related' => is_array($meta['related'] ?? null) ? $meta['related'] : [],
        'order' => (int) ($meta['order'] ?? 100),
        'draft' => $draft,
        'html' => $html,
        'toc' => wiki_toc($html),
        'reading_minutes' => max(1, (int) ceil($words / 200)),
        'fallback_lang' => $fallbackLang,
        'source_mtime' => (int) filemtime($file),
    ];
}

/**
 * Lists articles of a category (ordered by `order`, then title).
 */
function wiki_list_articles(string $lang, string $category): array
{
    $dir = WIKI_CONTENT_DIR . '/' . $lang . '/' . $category;
    $out = [];
    if (!is_dir($dir)) {
        return $out;
    }
    foreach (glob($dir . '/*.md') ?: [] as $file) {
        $slug = basename($file, '.md');
        $article = wiki_get_article($lang, $category, $slug);
        if ($article !== null) {
            $out[] = $article;
        }
    }
    usort($out, static fn($a, $b) => [$a['order'], $a['title']] <=> [$b['order'], $b['title']]);
    return $out;
}

/**
 * Builds the flat search/sitemap index for a language.
 */
function wiki_build_index(string $lang): array
{
    $index = [];
    foreach (array_keys(wiki_categories()) as $category) {
        foreach (wiki_list_articles($lang, $category) as $a) {
            $index[] = [
                'title' => $a['title'],
                'description' => $a['description'],
                'category' => $category,
                'slug' => $a['slug'],
                'url' => '/' . $lang . '/wiki/' . $category . '/' . $a['slug'],
                'tags' => $a['tags'],
                'updated' => $a['updated'],
            ];
        }
    }
    return $index;
}

/**
 * Case-insensitive substring search over the index.
 */
function wiki_search(string $lang, string $q, int $limit = 20): array
{
    $q = mb_strtolower(trim(mb_substr($q, 0, 200)));
    if ($q === '') {
        return [];
    }
    $hits = [];
    foreach (wiki_build_index($lang) as $entry) {
        $hay = mb_strtolower($entry['title'] . ' ' . $entry['description'] . ' ' . $entry['category'] . ' ' . implode(' ', $entry['tags']));
        if (str_contains($hay, $q)) {
            $hits[] = $entry;
        }
        if (count($hits) >= $limit) {
            break;
        }
    }
    return $hits;
}

/**
 * Renders a 404 through the shared error view.
 */
function wiki_404(string $lang): void
{
    http_response_code(404);
    header('X-Robots-Tag: noindex, nofollow');
    render('error', [
        'lang' => $lang,
        'code' => 404,
        'message' => t('error.not_found'),
        'title' => '404 — ' . t('error.not_found') . ' — ternis.org Wiki',
    ], 'main');
}
