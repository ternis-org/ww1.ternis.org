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
        'linux-packages' => ['icon' => 'package', 'en' => 'Linux Packages', 'de' => 'Linux-Pakete', 'desc_en' => 'Essential CLI utilities: fail2ban, btop, tmux, certbot, caddy, nginx, curl & screenfetch.', 'desc_de' => 'Unverzichtbare CLI-Tools: fail2ban, btop, tmux, certbot, caddy, nginx, curl & screenfetch.', 'order' => 65],
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
function wiki_icon(string $name, string $extraClass = ''): string
{
    static $icons = [
        // Category icons
        'globe'        => '<circle cx="12" cy="12" r="8.5"/><path d="M3.5 12h17M12 3.5c3.2 3.6 3.2 13.4 0 17M12 3.5c-3.2 3.6-3.2 13.4 0 17"/>',
        'server'       => '<rect x="3" y="4" width="18" height="7" rx="1.5"/><rect x="3" y="13" width="18" height="7" rx="1.5"/><path d="M6.5 7.5h.01M6.5 16.5h.01"/>',
        'link'         => '<path d="M10 14a5 5 0 0 0 7.1 0l2.8-2.8a5 5 0 0 0-7-7.1l-1.6 1.6M14 10a5 5 0 0 0-7.1 0l-2.8 2.8a5 5 0 0 0 7 7.1l1.6-1.6"/>',
        'signal'       => '<path d="M5 10a10 10 0 0 1 14 0M8 13a6 6 0 0 1 8 0"/><path d="M12 17.2h.01"/>',
        'table'        => '<rect x="3" y="4" width="18" height="16" rx="1.5"/><path d="M3 9.5h18M9.5 9.5V20"/>',
        'terminal'     => '<rect x="3" y="4" width="18" height="16" rx="2"/><path d="M7 9.5l2.8 2.8L7 15M12.5 15H17"/>',
        'package'      => '<path d="M16.5 9.4L7.55 4.24M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/>',
        'orbit'        => '<circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="1.3"/><circle cx="12" cy="5.8" r="1.1"/><circle cx="17.4" cy="15.1" r="1.1"/><circle cx="6.6" cy="15.1" r="1.1"/>',
        'database'     => '<ellipse cx="12" cy="5.5" rx="8" ry="2.8"/><path d="M4 5.5v13c0 1.6 3.6 2.9 8 2.9s8-1.3 8-2.9v-13M4 12c0 1.6 3.6 2.9 8 2.9s8-1.3 8-2.9"/>',
        'sliders'      => '<path d="M4 8h9M17.5 8H20M4 16h3.5M12 16h8"/><circle cx="15.5" cy="8" r="2"/><circle cx="10" cy="16" r="2"/>',
        'code'         => '<path d="M8.5 7L3.5 12l5 5M15.5 7l5 5-5 5M13.2 4.5l-2.4 15"/>',
        'bolt'         => '<path d="M13 2.5L4.5 13.5H11l-1 8 8.5-11H12l1-8z"/>',
        'brush'        => '<path d="M12 3.5a8.5 8.5 0 1 0 .01 17c1.4 0 1.9-.9 1.4-1.9-.5-1.2.3-2.4 1.6-2.4h1.6a3.9 3.9 0 0 0 3.9-3.9C20.5 7.4 16.6 3.5 12 3.5z"/><path d="M7.6 11.4h.01M11 7.6h.01"/>',
        'cube'         => '<path d="M12 2.5l8.5 4.8v9.4L12 21.5l-8.5-4.8V7.3L12 2.5zM3.5 7.3L12 12l8.5-4.7M12 12v9.5"/>',
        'lock'         => '<rect x="5" y="10.5" width="14" height="10" rx="2"/><path d="M8 10.5V7.5a4 4 0 0 1 8 0v3"/>',
        'branch'       => '<circle cx="6" cy="5" r="2"/><circle cx="6" cy="19" r="2"/><circle cx="18" cy="7" r="2"/><path d="M6 7v10M18 9c0 4.5-6.5 3-9.5 5.5"/>',

        // Navigation & controls
        'search'       => '<circle cx="11" cy="11" r="7"/><path d="M20 20l-3.8-3.8"/>',
        'arrow'        => '<path d="M5 12h14M12 5l7 7-7 7"/>',
        'arrow-right'  => '<path d="M5 12h14M12 5l7 7-7 7"/>',
        'arrow-left'   => '<path d="M19 12H5M12 19l-7-7 7-7"/>',
        'arrow-up'     => '<path d="M12 19V5M5 12l7-7 7 7"/>',
        'chevron-right'=> '<path d="M9 18l6-6-6-6"/>',
        'chevron-left' => '<path d="M15 18l-6-6 6-6"/>',
        'chevron-down' => '<path d="M6 9l6 6 6-6"/>',
        'hash'         => '<line x1="4" y1="9" x2="20" y2="9"/><line x1="4" y1="15" x2="20" y2="15"/><line x1="10" y1="3" x2="8" y2="21"/><line x1="16" y1="3" x2="14" y2="21"/>',
        'copy'         => '<rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>',
        'check'        => '<polyline points="20 6 9 17 4 12"/>',
        'clock'        => '<circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 15.5 14"/>',
        'calendar'     => '<rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>',
        'tag'          => '<path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><circle cx="7" cy="7" r="1.5" fill="currentColor"/>',
        'book'         => '<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>',
        'home'         => '<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>',
        'external'     => '<path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/>',
        'sun'          => '<circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>',
        'moon'         => '<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>',
        'menu'         => '<line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/>',
        'x'            => '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>',
        'info'         => '<circle cx="12" cy="12" r="9"/><line x1="12" y1="16" x2="12" y2="12"/><circle cx="12" cy="8" r="1" fill="currentColor"/>',
        'alert'        => '<path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><circle cx="12" cy="17" r="1" fill="currentColor"/>',
        'lightbulb'    => '<path d="M9 18h6"/><path d="M10 22h4"/><path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 18 8 6 6 0 0 0 6 8c0 1 .23 2.23 1.5 3.5.76.76 1.23 1.52 1.41 2.5h6.18z"/>',
        'toc'          => '<line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>',
        'share'        => '<circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>',
        'sparkles'     => '<path d="M12 3l1.91 5.09L19 10l-5.09 1.91L12 17l-1.91-5.09L5 10l5.09-1.91L12 3z"/><path d="M5 3l.8 2.2L8 6l-2.2.8L5 9l-.8-2.2L2 6l2.2-.8L5 3z"/>',
        'github'       => '<path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>',
        'dot'          => '<circle cx="12" cy="12" r="3" fill="currentColor"/>',
    ];
    $inner = $icons[$name] ?? $icons['globe'];
    $classes = 'wiki-ico' . ($extraClass !== '' ? ' ' . $extraClass : '');
    $isFill = in_array($name, ['github', 'dot'], true);
    $attrs = $isFill
        ? 'fill="currentColor"'
        : 'fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"';
    return '<svg class="' . htmlspecialchars($classes, ENT_QUOTES, 'UTF-8') . '" viewBox="0 0 24 24" '
        . $attrs . ' aria-hidden="true">' . $inner . '</svg>';
}

/**
 * Returns categories with article count populated.
 *
 * @return array<string, array{icon: string, en: string, de: string, desc_en: string, desc_de: string, order: int, count: int}>
 */
function wiki_categories_with_counts(string $lang): array
{
    static $cache = [];
    if (isset($cache[$lang])) {
        return $cache[$lang];
    }
    $cats = wiki_categories();
    $out = [];
    foreach ($cats as $slug => $meta) {
        $out[$slug] = $meta + ['count' => count(wiki_list_articles($lang, $slug))];
    }
    return $cache[$lang] = $out;
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
            $label = $admonKind === 'warn' ? 'Warning' : ($admonKind === 'tip' ? 'Tip' : 'Note');
            $icon = $admonKind === 'warn' ? wiki_icon('alert') : ($admonKind === 'tip' ? wiki_icon('lightbulb') : wiki_icon('info'));
            $html .= '<div class="wiki-admon wiki-admon-' . e($admonKind) . '" role="note">'
                . '<div class="wiki-admon-head">' . $icon . '<strong class="wiki-admon-title">' . $label . '</strong></div>'
                . '<div class="wiki-admon-content"><p>' . wiki_inline(implode(' ', $admonBuf)) . "</p></div></div>\n";
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
            $copyIcon = wiki_icon('copy');
            $checkIcon = wiki_icon('check');
            $html .= '<div class="wiki-codeblock"><div class="wiki-codeblock-bar"><span class="wiki-codeblock-lang">'
                . e($codeLang !== '' ? $codeLang : 'code')
                . '</span><button type="button" class="wiki-copy-btn" data-copy="' . $copy
                . '" aria-label="Copy code">'
                . '<span class="wiki-copy-icon">' . $copyIcon . '</span>'
                . '<span class="wiki-copy-check">' . $checkIcon . '</span>'
                . '<span class="wiki-copy-label">Copy</span>'
                . '</button></div><pre><code class="language-'
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
        // Tables: any row starting with `|` (separator rows are skipped).
        // Detection is intentionally content-agnostic so umlauts, €, → etc. work.
        if (str_starts_with($t, '|') && str_contains(substr($t, 1), '|')) {
            if (preg_match('/^\|[\s:\-|]+\|$/', $t)) {
                $inTable = true;
                continue;
            }
            $flushParagraph();
            $closeList();
            $inTable = true;
            $tableRows[] = $t;
            continue;
        }
        $flushTable();
        // Headings
        if (preg_match('/^(#{1,4})\s+(.+)$/', $t, $m)) {
            $flushParagraph();
            $closeList();
            $level = strlen($m[1]);
            $text = trim($m[2]);
            $id = wiki_heading_id($text);
            $anchorIcon = wiki_icon('hash', 'wiki-anchor-icon');
            $html .= "<h{$level} id=\"" . e($id) . '"><a class="wiki-anchor" href="#' . e($id) . '" aria-label="Permalink to ' . e($text) . '">' . $anchorIcon . '</a> ' . wiki_inline($text) . "</h{$level}>\n";
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
                $checked = strtolower($tm[1]) === 'x';
                $checkIcon = $checked ? wiki_icon('check', 'wiki-task-check') : '';
                $html .= '<li class="wiki-task' . ($checked ? ' is-checked' : '') . '">'
                    . '<span class="wiki-task-box" aria-hidden="true">' . $checkIcon . '</span> '
                    . wiki_inline($tm[2]) . "</li>\n";
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

    // Convert unicode arrows outside <code> to inline SVGs
    $parts = preg_split('/(<code>.*?<\/code>)/s', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
    if ($parts !== false) {
        $arrowRight = '<span class="wiki-inline-arrow" aria-hidden="true">' . wiki_icon('arrow-right', 'wiki-ico-xs') . '</span>';
        $arrowLeft = '<span class="wiki-inline-arrow" aria-hidden="true">' . wiki_icon('arrow-left', 'wiki-ico-xs') . '</span>';
        foreach ($parts as $idx => $part) {
            if (!str_starts_with($part, '<code>')) {
                $part = str_replace('→', $arrowRight, $part);
                $part = str_replace('←', $arrowLeft, $part);
                $part = str_replace('↔', $arrowLeft . ' ' . $arrowRight, $part);
                $parts[$idx] = $part;
            }
        }
        $text = implode('', $parts);
    }

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
