<?php

declare(strict_types=1);

/**
 * Projects Index: /{lang}/projects
 * Comprehensive searchable directory of all projects in the ternis-org ecosystem.
 * @var string $lang
 */

$lang = $lang ?? current_lang();
$isDe = $lang === 'de';

$projects = [
    [
        'id'          => 'httpclient',
        'title'       => 'httpclient.de',
        'category'    => 'tools',
        'cat_label'   => $isDe ? 'Web & APIs' : 'Web & APIs',
        'tagline'     => $isDe ? 'Kostenloser Online-HTTP-Client & API-Debugger' : 'Fast Online HTTP Client & REST API Debugger',
        'description' => $isDe
            ? 'Moderner, privatsphärefreundlicher Web-Client für HTTP-Header, REST-Anfragen und Payload-Inspektion. Läuft vollständig ohne Tracking oder Datenspeicherung.'
            : 'Privacy-first online REST client to test endpoints, craft headers, inspect payload responses, and debug webhooks with zero telemetry or tracking.',
        'tags'        => ['REST API', 'HTTP Client', 'Zero Telemetry', 'Developer Tool'],
        'url'         => 'https://httpclient.de',
        'repo_url'    => null,
        'status'      => 'Active • Production',
    ],
    [
        'id'          => 'example-dns',
        'title'       => 'example-dns (ternis.net)',
        'category'    => 'infra',
        'cat_label'   => $isDe ? 'Infrastruktur & DNS' : 'Infrastructure & DNS',
        'tagline'     => $isDe ? 'Autonome Anycast-Nameserver (one & two.ns.ternis.net)' : 'Authoritative Anycast Nameserver Backbone',
        'description' => $isDe
            ? 'Geografisch redundantes autoritatives Anycast-DNS-Netzwerk auf one.ns.ternis.net und two.ns.ternis.net mit DNSSEC ECDSA P-256 Validierung.'
            : 'Geographically dispersed Anycast authoritative nameservers running on one.ns.ternis.net and two.ns.ternis.net with full DNSSEC signing.',
        'tags'        => ['one.ns.ternis.net', 'two.ns.ternis.net', 'Anycast DNS', 'DNSSEC Alg 13'],
        'url'         => 'https://example-dns.com',
        'repo_url'    => 'https://github.com/example-dns/example-dns',
        'codeberg'    => 'https://codeberg.org/example-dns/example-dns',
        'status'      => 'Active • Production',
    ],
    [
        'id'          => 'mtex',
        'title'       => 'MTEX.dev',
        'category'    => 'tools',
        'cat_label'   => $isDe ? 'Entwickler-Tools' : 'Developer Tools',
        'tagline'     => $isDe ? 'Developer-Utilities & UI-Komponenten' : 'Developer Utilities & UI Components',
        'description' => $isDe
            ? 'Moderne UI-Toolsets, Webkomponenten und Bibliotheken, die Entwicklerprojekte im gesamten Ökosystem antreiben.'
            : 'Modular developer toolsets, lightweight UI components, and software libraries empowering ecosystem applications.',
        'tags'        => ['Developer Suite', 'UI Tools', 'Open Source', 'FOSS'],
        'url'         => 'https://mtex.dev',
        'repo_url'    => null,
        'status'      => 'Active • Production',
    ],
    [
        'id'          => 'getmyname',
        'title'       => 'getmy.name',
        'category'    => 'tools',
        'cat_label'   => $isDe ? 'Web & APIs' : 'Web & APIs',
        'tagline'     => $isDe ? 'Kostenlose Entwickler-Portfolio-API' : 'Free Developer Portfolio & Profile API',
        'description' => $isDe
            ? 'Schlanke JSON/REST API zur Pflege und Bereitstellung strukturierter Entwicklerprofile, Lebensläufe und Projekte.'
            : 'Lightweight headless REST API to query and render developer profiles, public keys, and project portfolios in clean JSON.',
        'tags'        => ['JSON API', 'Developer Profiles', 'Portfolio API', 'Headless'],
        'url'         => 'https://getmy.name',
        'docs_url'    => 'https://getmy.name/api-docs',
        'repo_url'    => null,
        'status'      => 'Active • Production',
    ],
    [
        'id'          => 'websearch',
        'title'       => 'web-search.org',
        'category'    => 'privacy',
        'cat_label'   => $isDe ? 'Privatsphäre & Suche' : 'Privacy & Search',
        'tagline'     => $isDe ? 'Selbst-hostbare, privatsphärefreundliche Suchmaschine' : 'Self-Hostable Privacy Search Engine',
        'description' => $isDe
            ? 'Schnelle Metasuchmaschine ohne Profiling, ohne Werbetracking und ohne Datenweitergabe an Werbenetzwerke.'
            : 'High-speed, privacy-first meta search engine with zero user profiling, no cookie tracking, and zero advertising pixels.',
        'tags'        => ['Search Engine', 'Privacy First', 'Self-Hostable', 'No Tracking'],
        'url'         => 'https://web-search.org',
        'repo_url'    => null,
        'status'      => 'Active • Production',
    ],
    [
        'id'          => 'mailfree',
        'title'       => 'mail-free.eu & mail-free.uk',
        'category'    => 'privacy',
        'cat_label'   => $isDe ? 'Privatsphäre & E-Mail' : 'Privacy & Email',
        'tagline'     => $isDe ? 'Wegwerf-E-Mail-Adressen & Souveräne Relays' : 'Disposable Email Inboxes & European Mail Relays',
        'description' => $isDe
            ? 'Automatisch generierte E-Mail-Aliasse und souveräne europäische Mail-Gateways zum Schutz des persönlichen Postfachs vor Spam.'
            : 'Instantly generated disposable mail aliases and sovereign European mail relays keeping your primary inbox spam-free.',
        'tags'        => ['Email Privacy', 'Spam Defense', 'EU Sovereign', 'Free'],
        'url'         => 'https://mail-free.eu',
        'url_alt'     => 'https://mail-free.uk',
        'repo_url'    => null,
        'status'      => 'Active • Production',
    ],
    [
        'id'          => 'staticre',
        'title'       => 'static.re',
        'category'    => 'hosting',
        'cat_label'   => $isDe ? 'Hosting & Storage' : 'Hosting & Storage',
        'tagline'     => $isDe ? 'S3 & Cloudflare R2 Speicherplattform' : 'S3 & Cloudflare R2 Object Storage Platform',
        'description' => $isDe
            ? 'Verwaltete Bereitstellungs- und Speicherplattform für S3-kompatible Backends und Cloudflare R2 Object Storage.'
            : 'Software platform and management delivery service for S3-compatible endpoints and Cloudflare R2 object storage.',
        'tags'        => ['S3 Compatible', 'Cloudflare R2', 'Object Storage', 'Asset CDN'],
        'url'         => 'https://static.re',
        'repo_url'    => null,
        'status'      => 'Active • Production',
    ],
    [
        'id'          => 'drophtml',
        'title'       => 'drophtml.de',
        'category'    => 'hosting',
        'cat_label'   => $isDe ? 'Hosting & Storage' : 'Hosting & Storage',
        'tagline'     => $isDe ? 'Kostenloses Drag-and-Drop Webhosting' : 'Zero-Config Drag-and-Drop HTML Web Hosting',
        'description' => $isDe
            ? 'Statische HTML-, CSS- und JS-Seiten einfach per Drag-and-Drop im Browser hochladen und sofort weltweit online stellen.'
            : 'Instant static web hosting: drop an HTML file or ZIP archive into your browser to deploy a live, secure website in seconds.',
        'tags'        => ['HTML Hosting', 'Drag & Drop', 'Static Sites', 'Instant Deploy'],
        'url'         => 'https://drophtml.de',
        'repo_url'    => null,
        'status'      => 'Active • Production',
    ],
    [
        'id'          => 'ternisdomains',
        'title'       => 'ternisdomains.de',
        'category'    => 'infra',
        'cat_label'   => $isDe ? 'Infrastruktur & DNS' : 'Infrastructure & DNS',
        'tagline'     => $isDe ? 'Transparente Domain-Registrierung & DNS-Zonen' : 'Transparent Flat-Rate Domain Registration',
        'description' => $isDe
            ? 'Faire Domain-Registrierungen ohne Lockpreise und ohne Preisfallen bei Verlängerungen, mit nativer Unterstützung für ternis.net Nameserver.'
            : 'Fair flat-rate domain registration and DNS zone management without first-year promo traps or renewal price hikes.',
        'tags'        => ['Domain Registrar', 'DNS Control', 'DNSSEC Ready', 'Flat Pricing'],
        'url'         => 'https://ternisdomains.de',
        'repo_url'    => null,
        'status'      => 'Active • Production',
    ],
    [
        'id'          => 'ternisorg',
        'title'       => 'ternis.org & Technical Wiki',
        'category'    => 'infra',
        'cat_label'   => $isDe ? 'Infrastruktur & Doku' : 'Infrastructure & Docs',
        'tagline'     => $isDe ? 'Open-Source-Hub & 60+ Artikel Tech-Wiki' : 'Official Open Source Hub & 60+ Article Wiki',
        'description' => $isDe
            ? 'Das zentrale Open-Source-Repository und praxisorientierte Technik-Wiki für Linux, DNS, DevOps, MySQL und Homelab-Architektur.'
            : 'The official open-source website and comprehensive technical knowledge base covering Linux, DNS, DevOps, and networking.',
        'tags'        => ['Open Source', 'Technical Wiki', 'Atom Feed', '100% SVG'],
        'url'         => 'https://ternis.org/' . $lang,
        'repo_url'    => 'https://github.com/ternis-org/ww1.ternis.org',
        'status'      => 'Active • Production',
    ],
];
?>
<div class="projects-index-page">
    <div class="container" style="padding-top: 2rem; padding-bottom: 5rem;">

        <!-- Breadcrumb Navigation -->
        <nav aria-label="Breadcrumb" class="infra-crumbs" style="display:flex;align-items:center;gap:0.5rem;font-size:0.875rem;color:var(--text-muted);margin-bottom:2rem;">
            <a href="/<?= e($lang) ?>" style="display:inline-flex;align-items:center;gap:0.35rem;color:var(--text-muted);text-decoration:none;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                <span>ternis.org</span>
            </a>
            <span aria-hidden="true">&rsaquo;</span>
            <span style="color:var(--text-main);font-weight:600;"><?= $isDe ? 'Projekte-Index' : 'Projects Index' ?></span>
        </nav>

        <!-- Header -->
        <header class="section-header scroll-reveal" style="text-align:left;margin-bottom:3rem;">
            <div style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.35rem 0.85rem;border-radius:9999px;background:rgba(234,88,12,0.1);border:1px solid rgba(234,88,12,0.3);color:var(--primary);font-size:0.8125rem;font-weight:600;font-family:var(--font-mono);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:1rem;">
                <span>Ecosystem Directory // <?= count($projects) ?> Active Services</span>
            </div>
            <h1 style="font-size:clamp(2rem, 4vw, 3.25rem);font-weight:800;letter-spacing:-0.03em;margin-bottom:1rem;line-height:1.15;">
                <?= $isDe ? 'Alle Projekte & Dienste im Überblick' : 'Open Source Projects & Hosted Services' ?>
            </h1>
            <p style="font-size:1.125rem;color:var(--text-muted);max-width:800px;line-height:1.65;margin:0;">
                <?= $isDe
                    ? 'Verzeichnis aller aktiven Open-Source-Initiativen, Entwickler-Werkzeuge, DNS-Infrastrukturen und datensouveränen Webdienste von ternis.org und MTEX.dev.'
                    : 'Searchable directory of all open-source software, developer tools, authoritative DNS infrastructure, and privacy services maintained by ternis.org.'
                ?>
            </p>
        </header>

        <!-- Filter & Search Controls -->
        <div style="background:var(--surface);border:1px solid var(--border-subtle);border-radius:14px;padding:1.25rem;margin-bottom:2.5rem;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:1rem;">
            <!-- Category Filter Tabs -->
            <div id="project-filters" style="display:flex;flex-wrap:wrap;gap:0.5rem;">
                <button type="button" class="btn btn-outline btn-sm is-active" data-cat="all"><?= $isDe ? 'Alle Projekte' : 'All Projects' ?> (<?= count($projects) ?>)</button>
                <button type="button" class="btn btn-outline btn-sm" data-cat="infra"><?= $isDe ? 'Infrastruktur & DNS' : 'Infrastructure & DNS' ?></button>
                <button type="button" class="btn btn-outline btn-sm" data-cat="tools"><?= $isDe ? 'Entwickler-Tools' : 'Developer Tools' ?></button>
                <button type="button" class="btn btn-outline btn-sm" data-cat="privacy"><?= $isDe ? 'Privatsphäre & Mail' : 'Privacy & Email' ?></button>
                <button type="button" class="btn btn-outline btn-sm" data-cat="hosting"><?= $isDe ? 'Hosting & Storage' : 'Hosting & Storage' ?></button>
            </div>

            <!-- Live Search Filter -->
            <div style="position:relative;min-width:240px;flex:1;max-width:340px;">
                <input type="text" id="project-search-input" placeholder="<?= $isDe ? 'Projekte durchsuchen…' : 'Search projects…' ?>" style="width:100%;padding:0.5rem 0.85rem 0.5rem 2.25rem;border-radius:8px;border:1px solid var(--border-subtle);background:var(--bg-color);color:var(--text-main);font-size:0.875rem;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="position:absolute;left:0.85rem;top:50%;transform:translateY(-50%);color:var(--text-muted);pointer-events:none;" aria-hidden="true"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </div>
        </div>

        <!-- Projects Grid -->
        <div id="projects-container" style="display:grid;grid-template-columns:repeat(auto-fill, minmax(340px, 1fr));gap:1.5rem;">
            <?php foreach ($projects as $proj): ?>
                <div class="project-item-card" data-category="<?= e($proj['category']) ?>" data-search="<?= e(strtolower($proj['title'] . ' ' . $proj['tagline'] . ' ' . $proj['description'] . ' ' . implode(' ', $proj['tags']))) ?>" style="background:var(--surface);border:1px solid var(--border-subtle);border-radius:16px;padding:1.75rem;display:flex;flex-direction:column;justify-content:space-between;transition:border-color 0.15s ease, transform 0.15s ease;">
                    <div>
                        <!-- Card Header -->
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.75rem;">
                            <span style="font-family:var(--font-mono);font-size:0.75rem;padding:0.25rem 0.6rem;background:rgba(234,88,12,0.1);color:var(--primary);border-radius:6px;font-weight:600;">
                                <?= e($proj['cat_label']) ?>
                            </span>
                            <span style="display:inline-flex;align-items:center;gap:0.35rem;font-size:0.75rem;color:#22c55e;font-weight:500;">
                                <span style="width:6px;height:6px;border-radius:50%;background:#22c55e;"></span>
                                <?= e($proj['status']) ?>
                            </span>
                        </div>

                        <!-- Title & Tagline -->
                        <h3 style="font-size:1.35rem;font-weight:700;margin:0 0 0.35rem;letter-spacing:-0.01em;">
                            <a href="<?= e($proj['url']) ?>" target="_blank" rel="noopener noreferrer" style="color:var(--text-main);text-decoration:none;">
                                <?= e($proj['title']) ?>
                            </a>
                        </h3>
                        <div style="font-size:0.875rem;font-weight:500;color:var(--primary);margin-bottom:0.75rem;font-family:var(--font-mono);">
                            <?= e($proj['tagline']) ?>
                        </div>
                        <p style="font-size:0.875rem;color:var(--text-muted);line-height:1.55;margin:0 0 1.25rem;">
                            <?= e($proj['description']) ?>
                        </p>

                        <!-- Tags -->
                        <div style="display:flex;flex-wrap:wrap;gap:0.4rem;margin-bottom:1.5rem;">
                            <?php foreach ($proj['tags'] as $tag): ?>
                                <span style="font-size:0.6875rem;padding:0.2rem 0.5rem;background:var(--bg-color);border:1px solid var(--border-subtle);border-radius:4px;color:var(--text-muted);font-family:var(--font-mono);">
                                    <?= e($tag) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Action Links -->
                    <div style="display:flex;flex-wrap:wrap;gap:0.5rem;padding-top:1rem;border-top:1px solid var(--border-subtle);">
                        <a href="<?= e($proj['url']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-sm" style="flex:1;justify-content:center;font-size:0.8125rem;">
                            <span><?= $isDe ? 'Website öffnen' : 'Launch Service' ?></span>
                        </a>
                        <?php if (!empty($proj['repo_url'])): ?>
                            <a href="<?= e($proj['repo_url']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline btn-sm" title="Source Code">
                                <svg fill="currentColor" viewBox="0 0 24 24" style="width:14px;height:14px;" aria-hidden="true"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"></path></svg>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- No results message -->
        <div id="no-projects-msg" style="display:none;text-align:center;padding:4rem 1rem;color:var(--text-muted);">
            <p style="font-size:1.125rem;margin-bottom:0.5rem;"><?= $isDe ? 'Keine Projekte gefunden.' : 'No projects matched your criteria.' ?></p>
            <p style="font-size:0.875rem;"><?= $isDe ? 'Versuche einen anderen Suchbegriff oder setze die Filter zurück.' : 'Try adjusting your search terms or reset the category filters.' ?></p>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var filterBtns = document.querySelectorAll('#project-filters button');
    var searchInput = document.getElementById('project-search-input');
    var cards = document.querySelectorAll('.project-item-card');
    var noMsg = document.getElementById('no-projects-msg');

    var currentCat = 'all';
    var currentQuery = '';

    function applyFilter() {
        var visibleCount = 0;
        cards.forEach(function (card) {
            var cat = card.getAttribute('data-category') || '';
            var searchData = card.getAttribute('data-search') || '';

            var catMatch = (currentCat === 'all' || cat === currentCat);
            var searchMatch = (!currentQuery || searchData.indexOf(currentQuery) !== -1);

            if (catMatch && searchMatch) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (noMsg) {
            noMsg.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    filterBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            filterBtns.forEach(function (b) { b.classList.remove('is-active'); });
            btn.classList.add('is-active');
            currentCat = btn.getAttribute('data-cat') || 'all';
            applyFilter();
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            currentQuery = searchInput.value.trim().toLowerCase();
            applyFilter();
        });
    }
});
</script>
