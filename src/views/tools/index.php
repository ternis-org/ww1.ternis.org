<?php

declare(strict_types=1);

/**
 * Tools Index View: /{lang}/tools
 * Main directory for developer and infrastructure utilities.
 * @var string $lang
 */

$lang = $lang ?? current_lang();
$isDe = $lang === 'de';

$toolsList = [
    [
        'id'          => 'shortlink',
        'url'         => '/' . $lang . '/tools/shortlink',
        'title'       => $isDe ? 'Shortlink & QR Studio' : 'Shortlink & QR Code Studio',
        'tagline'     => 'https://links.t-api.de/v1 • href.nz',
        'description' => $isDe
            ? 'Kostenlose Kurzlinks erstellen, Klick-Parameter analysieren und hochauflösende SVG/PNG-QR-Codes mit benutzerdefinierten Farben generieren.'
            : 'Create instant guest shortlinks via links.t-api.de, capture dynamic tags, and generate customized SVG/PNG QR codes.',
        'badge'       => 't-api.de v1',
        'tags'        => ['Shortlink', 'QR Code', 'SVG / PNG', 'REST API'],
        'icon'        => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>',
    ],
    [
        'id'          => 'shortlink-api',
        'url'         => '/' . $lang . '/tools/shortlink/api',
        'title'       => $isDe ? 'Shortlink API Guide' : 'Shortlink API Developer Guide',
        'tagline'     => 'OpenAPI 3.1 • Human Reference',
        'description' => $isDe
            ? 'Vollständige Dokumentation der HTTPS-API auf links.t-api.de/v1 mit curl-Beispielen, Dynamic Tracking, Bio Pages und Webhooks.'
            : 'Complete human-friendly API documentation for links.t-api.de/v1 with cURL examples, dynamic click tags, bio pages, and webhooks.',
        'badge'       => 'Developer Docs',
        'tags'        => ['API Reference', 'cURL Snippets', 'Webhooks', 'Bio Pages'],
        'icon'        => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>',
    ],
    [
        'id'          => 'dns',
        'url'         => '/' . $lang . '/tools/dns',
        'title'       => $isDe ? 'Live DNS Looking Glass' : 'Live DNS Looking Glass & Inspector',
        'tagline'     => 'Real-time DNS Resolution • DoH',
        'description' => $isDe
            ? 'Echtzeit-Abfrage von A, AAAA, MX, TXT, NS, SOA und CAA Records mit DNSSEC-Validierung und Latenzvergleich.'
            : 'Real-time DNS resolver querying A, AAAA, MX, TXT, NS, SOA, and CAA records with DNSSEC validation flags and latency telemetry.',
        'badge'       => 'Live Resolver',
        'tags'        => ['DNS Lookup', 'DNSSEC', 'DoH', 'one.ns.ternis.net'],
        'icon'        => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>',
    ],
    [
        'id'          => 'secret-gen',
        'url'         => '/' . $lang . '/tools/secret-generator',
        'title'       => $isDe ? 'Token & Passwort Generator' : 'Cryptographic Token & Secret Generator',
        'tagline'     => 'Web Crypto API • 100% Client-Side',
        'description' => $isDe
            ? 'Kryptografisch sichere Passwörter, API-Token (tl_...), UUIDv4 und Hash-Secrets direkt im Browser ohne Serverübertragung generieren.'
            : 'Generate cryptographically secure API tokens (tl_...), high-entropy passwords, and UUIDs locally in your browser with zero network transmission.',
        'badge'       => 'Client-Side',
        'tags'        => ['Crypto API', 'UUIDv4', 'API Tokens', 'Zero Network'],
        'icon'        => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>',
    ],
];
?>
<div class="tools-index-page">
    <div class="container" style="padding-top: 2rem; padding-bottom: 5rem;">

        <!-- Breadcrumbs -->
        <nav aria-label="Breadcrumb" class="infra-crumbs" style="display:flex;align-items:center;gap:0.5rem;font-size:0.875rem;color:var(--text-muted);margin-bottom:2rem;">
            <a href="/<?= e($lang) ?>" style="display:inline-flex;align-items:center;gap:0.35rem;color:var(--text-muted);text-decoration:none;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                <span>ternis.org</span>
            </a>
            <span aria-hidden="true">&rsaquo;</span>
            <span style="color:var(--text-main);font-weight:600;"><?= $isDe ? 'Entwickler-Werkzeuge' : 'Developer Tools' ?></span>
        </nav>

        <!-- Hero Header -->
        <header class="section-header scroll-reveal" style="text-align:left;margin-bottom:3rem;">
            <div style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.35rem 0.85rem;border-radius:9999px;background:rgba(234,88,12,0.1);border:1px solid rgba(234,88,12,0.3);color:var(--primary);font-size:0.8125rem;font-weight:600;font-family:var(--font-mono);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:1rem;">
                <span>ternis.org // Developer Utilities & API Suite</span>
            </div>
            <h1 style="font-size:clamp(2rem, 4vw, 3.25rem);font-weight:800;letter-spacing:-0.03em;margin-bottom:1rem;line-height:1.15;">
                <?= $isDe ? 'Entwickler- & Netzwerk-Werkzeuge' : 'Developer & Network Tools' ?>
            </h1>
            <p style="font-size:1.125rem;color:var(--text-muted);max-width:800px;line-height:1.65;margin:0;">
                <?= $isDe
                    ? 'Kostenlose, datensouveräne Werkzeuge für Entwickler, Sysadmins und Webmaster: Shortlink-Erstellung, QR-Code-Studio, Live-DNS-Inspektor und API-Dokumentation.'
                    : 'Fast, privacy-respecting online utilities: Create shortlinks, generate customized vector QR codes, inspect live DNS records, and integrate via the t-api.de REST API.'
                ?>
            </p>
        </header>

        <!-- Tools Grid -->
        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(320px, 1fr));gap:1.5rem;">
            <?php foreach ($toolsList as $t): ?>
                <div class="tool-card" style="background:var(--surface);border:1px solid var(--border-subtle);border-radius:16px;padding:1.75rem;display:flex;flex-direction:column;justify-content:space-between;transition:border-color 0.15s ease, transform 0.15s ease;">
                    <div>
                        <!-- Header row -->
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                            <div style="width:44px;height:44px;border-radius:10px;background:rgba(234,88,12,0.1);color:var(--primary);display:flex;align-items:center;justify-content:center;">
                                <?= $t['icon'] ?>
                            </div>
                            <span style="font-family:var(--font-mono);font-size:0.75rem;padding:0.25rem 0.6rem;background:var(--bg-color);border:1px solid var(--border-subtle);border-radius:6px;color:var(--text-muted);">
                                <?= e($t['badge']) ?>
                            </span>
                        </div>

                        <!-- Title & Tagline -->
                        <h2 style="font-size:1.35rem;font-weight:700;margin:0 0 0.35rem;letter-spacing:-0.01em;">
                            <a href="<?= e($t['url']) ?>" style="color:var(--text-main);text-decoration:none;">
                                <?= e($t['title']) ?>
                            </a>
                        </h2>
                        <div style="font-size:0.8125rem;color:var(--primary);margin-bottom:0.85rem;font-family:var(--font-mono);font-weight:500;">
                            <?= e($t['tagline']) ?>
                        </div>
                        <p style="font-size:0.875rem;color:var(--text-muted);line-height:1.55;margin:0 0 1.25rem;">
                            <?= e($t['description']) ?>
                        </p>

                        <!-- Tags -->
                        <div style="display:flex;flex-wrap:wrap;gap:0.4rem;margin-bottom:1.5rem;">
                            <?php foreach ($t['tags'] as $tag): ?>
                                <span style="font-size:0.6875rem;padding:0.2rem 0.5rem;background:var(--bg-color);border:1px solid var(--border-subtle);border-radius:4px;color:var(--text-muted);font-family:var(--font-mono);">
                                    <?= e($tag) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Action link -->
                    <div style="padding-top:1rem;border-top:1px solid var(--border-subtle);">
                        <a href="<?= e($t['url']) ?>" class="btn btn-primary btn-sm" style="width:100%;justify-content:center;font-size:0.8125rem;">
                            <span><?= $isDe ? 'Werkzeug öffnen' : 'Open Tool' ?> &rarr;</span>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>
