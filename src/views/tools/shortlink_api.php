<?php

declare(strict_types=1);

/**
 * Shortlink API Developer Guide View
 * Path: /{lang}/tools/shortlink/api
 *
 * @var string $lang
 */

require_once ROOT_PATH . '/src/wiki.php';

$lang = $lang ?? current_lang();
$isDe = $lang === 'de';

$mdFile = ROOT_PATH . '/content/docs/shortlink_api.md';
$rawMd = file_exists($mdFile) ? (string) file_get_contents($mdFile) : '# API guide';

$articleHtml = wiki_markdown_to_html($rawMd);
$toc = wiki_toc($articleHtml);

$title = $isDe ? 'Shortlink API Entwickler-Leitfaden — links.t-api.de — ternis.org' : 'Shortlink REST API Developer Guide — links.t-api.de — ternis.org';
$metaDescription = $isDe
    ? 'Vollständige HTTP-Referenz für die t-api.de API: Kurzlinks, Dynamic Tracking, Privatsphäre-Filter, QR-Codes, Domains und Bio Pages.'
    : 'Complete HTTPS reference for links.t-api.de/v1: link creation, dynamic click tags, privacy analytics, QR engine, and bio pages.';
?>

<div class="tools-container">
    <!-- Breadcrumb -->
    <nav aria-label="Breadcrumb" class="tools-breadcrumb">
        <a href="/<?= e($lang) ?>">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            <span>ternis.org</span>
        </a>
        <span aria-hidden="true">&rsaquo;</span>
        <a href="/<?= e($lang) ?>/tools">
            <span><?= $isDe ? 'Werkzeuge' : 'Tools' ?></span>
        </a>
        <span aria-hidden="true">&rsaquo;</span>
        <a href="/<?= e($lang) ?>/tools/shortlink">
            <span><?= $isDe ? 'Shortlink Studio' : 'Shortlink Studio' ?></span>
        </a>
        <span aria-hidden="true">&rsaquo;</span>
        <span style="color:var(--text-main);font-weight:600;"><?= $isDe ? 'API-Leitfaden' : 'API Guide' ?></span>
    </nav>

    <!-- Header -->
    <header class="tool-header">
        <div style="display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap;margin-bottom:1rem;">
            <div class="tool-badge-pill">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                <span>REST API v1 &bull; OpenAPI 3.1</span>
            </div>
            <a href="https://dash.ternis.link/api-keys" target="_blank" rel="noopener noreferrer" style="display:inline-flex;align-items:center;gap:0.4rem;font-size:0.8125rem;font-family:var(--font-mono);color:var(--text-muted);text-decoration:none;padding:0.3rem 0.75rem;border-radius:9999px;border:1px solid var(--border-subtle);background:var(--surface);">
                <span>dash.ternis.link/api-keys</span>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
            </a>
        </div>

        <h1 class="tool-title">
            <?= $isDe ? 'Shortlink API Entwickler-Leitfaden' : 'Shortlink API Developer Guide' ?>
        </h1>
        <p class="tool-desc">
            <?= $isDe
                ? 'Vollständige technische Dokumentation der HTTPS-Schnittstelle auf links.t-api.de/v1. Mit cURL-Beispielen für Links, Dynamic Tracking, Click Analytics, QR-Generierung und Bio Pages.'
                : 'Complete human-friendly reference for the HTTPS API at links.t-api.de/v1 with copy-paste examples for links, dynamic tracking, click analytics, QR studio, and bio pages.'
            ?>
        </p>
    </header>

    <!-- Quick Info Cards -->
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(260px, 1fr));gap:1rem;margin-bottom:2.5rem;">
        <div style="background:var(--surface);border:1px solid var(--border-subtle);border-radius:12px;padding:1.25rem;">
            <div style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);margin-bottom:0.35rem;font-weight:600;"><?= $isDe ? 'Basis-Endpunkt' : 'Base Endpoint' ?></div>
            <div style="font-family:var(--font-mono);font-size:0.9375rem;font-weight:700;color:var(--primary);">https://links.t-api.de/v1</div>
            <div style="font-size:0.75rem;color:var(--text-muted);margin-top:0.35rem;"><?= $isDe ? 'HTTPS Only &bull; TLS 1.3' : 'HTTPS Only &bull; TLS 1.3' ?></div>
        </div>
        <div style="background:var(--surface);border:1px solid var(--border-subtle);border-radius:12px;padding:1.25rem;">
            <div style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);margin-bottom:0.35rem;font-weight:600;"><?= $isDe ? 'Authentifizierung' : 'Authentication' ?></div>
            <div style="font-family:var(--font-mono);font-size:0.9375rem;font-weight:700;color:var(--text-main);">Bearer tl_&lt;token&gt;</div>
            <div style="font-size:0.75rem;color:var(--text-muted);margin-top:0.35rem;"><?= $isDe ? 'Oder Ternis Auth SSO Token' : 'Or Ternis Auth SSO Bearer token' ?></div>
        </div>
        <div style="background:var(--surface);border:1px solid var(--border-subtle);border-radius:12px;padding:1.25rem;">
            <div style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);margin-bottom:0.35rem;font-weight:600;"><?= $isDe ? 'Öffentlicher Gast-Endpunkt' : 'Guest Public Access' ?></div>
            <div style="font-family:var(--font-mono);font-size:0.9375rem;font-weight:700;color:var(--text-main);">POST /v1/links/public</div>
            <div style="font-size:0.75rem;color:var(--text-muted);margin-top:0.35rem;"><?= $isDe ? 'Kein Auth-Key notwendig' : 'No authentication required' ?></div>
        </div>
    </div>

    <!-- Layout: Content + Sticky Sidebar TOC -->
    <div style="display:grid;grid-template-columns:1fr;gap:2.5rem;align-items:start;" class="api-guide-layout">
        <style>
            @media (min-width: 1024px) {
                .api-guide-layout {
                    grid-template-columns: 280px 1fr !important;
                }
            }
            .api-toc-container {
                position: sticky;
                top: 5.5rem;
                max-height: calc(100vh - 7rem);
                overflow-y: auto;
                background: var(--surface);
                border: 1px solid var(--border-subtle);
                border-radius: 14px;
                padding: 1.25rem;
            }
            .api-toc-list {
                list-style: none;
                margin: 0;
                padding: 0;
            }
            .api-toc-item {
                margin: 0.25rem 0;
            }
            .api-toc-item.level-3 {
                padding-left: 0.85rem;
                font-size: 0.8125rem;
            }
            .api-toc-link {
                display: block;
                padding: 0.35rem 0.5rem;
                border-radius: 6px;
                color: var(--text-muted);
                text-decoration: none;
                font-size: 0.875rem;
                line-height: 1.35;
                transition: color 0.15s ease, background 0.15s ease;
            }
            .api-toc-link:hover {
                color: var(--primary);
                background: rgba(234, 88, 12, 0.05);
            }
        </style>

        <!-- Sidebar TOC -->
        <aside class="api-toc-container" aria-label="Table of contents">
            <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.85rem;padding-bottom:0.5rem;border-bottom:1px solid var(--border-subtle);font-weight:700;font-size:0.875rem;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="21" y1="10" x2="3" y2="10"></line><line x1="21" y1="6" x2="3" y2="6"></line><line x1="21" y1="14" x2="3" y2="14"></line><line x1="21" y1="18" x2="3" y2="18"></line></svg>
                <span><?= $isDe ? 'Inhaltsverzeichnis' : 'On This Page' ?></span>
            </div>
            <ul class="api-toc-list">
                <?php foreach ($toc as $item): ?>
                    <li class="api-toc-item level-<?= (int) $item['level'] ?>">
                        <a href="#<?= e($item['id']) ?>" class="api-toc-link">
                            <?= e($item['text']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </aside>

        <!-- Main Documentation Body -->
        <main class="wiki-content" style="background:var(--surface);border:1px solid var(--border-subtle);border-radius:16px;padding:2.5rem;box-shadow:0 4px 20px -2px rgba(0, 0, 0, 0.05);">
            <?= $articleHtml ?>
        </main>
    </div>
</div>
