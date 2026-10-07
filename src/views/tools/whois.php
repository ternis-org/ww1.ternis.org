<?php

declare(strict_types=1);

/**
 * WHOIS & RDAP Domain Explorer View
 * Path: /{lang}/tools/whois
 *
 * @var string $lang
 */

$lang = $lang ?? current_lang();
$isDe = $lang === 'de';

$title = $isDe ? 'WHOIS & RDAP Domain-Explorer — ternis.org' : 'WHOIS & RDAP Domain Explorer — ternis.org';
$metaDescription = $isDe
    ? 'Datensouveräne WHOIS- & RDAP-Domainabfrage in Echtzeit (RFC 9083). Prüfe Inhaberstatus, Registrar, DNSSEC und Nameserver ohne Tracking oder Frontrunning.'
    : 'Privacy-first real-time WHOIS & RDAP domain explorer (RFC 9083). Inspect domain registration, registrar, DNSSEC validation, and nameservers with zero tracking.';
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
        <span style="color:var(--text-main);font-weight:600;"><?= $isDe ? 'WHOIS & RDAP Explorer' : 'WHOIS & RDAP Explorer' ?></span>
    </nav>

    <!-- Header -->
    <header class="tool-header">
        <div class="tool-badge-pill">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
            <span>ICANN RDAP (RFC 9083) &bull; Zero Frontrunning &bull; No Tracking</span>
        </div>
        <h1 class="tool-title">
            <?= $isDe ? 'WHOIS & RDAP Domain-Explorer' : 'WHOIS & RDAP Domain Explorer' ?>
        </h1>
        <p class="tool-desc">
            <?= $isDe
                ? 'Frage Domain-Registrierungen, Registrar-Details, DNSSEC-Signierung, Nameserver und EPP-Statuscodes direkt über das moderne RDAP-Protokoll autoritativer Registries ab. 100% datensouverän ohne Zwischenspeicherung oder Suchhistorie.'
                : 'Inspect domain registration lifecycle, sponsoring registrar, cryptographic DNSSEC status, and nameservers directly via modern RDAP registries. 100% private with zero query logging or domain frontrunning.'
            ?>
        </p>
    </header>

    <!-- Search Card -->
    <div class="tool-card" style="margin-bottom:2rem;">
        <form id="whoisForm" onsubmit="executeWhoisLookup(event)">
            <div style="display:grid;grid-template-columns:1fr;gap:1.25rem;">
                <div class="tool-form-group" style="margin-bottom:0;">
                    <label class="tool-label" for="whoisDomainInput">
                        <?= $isDe ? 'Domainname eingeben' : 'Enter Domain Name' ?>
                    </label>
                    <div style="display:flex;gap:0.75rem;">
                        <input type="text" id="whoisDomainInput" class="tool-input mono" placeholder="ternis.org" value="ternis.org" required autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" style="font-size:1.0625rem;">
                        <button type="submit" id="whoisSubmitBtn" class="tool-btn-primary" style="flex-shrink:0;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <span><?= $isDe ? 'Abfragen' : 'Inspect' ?></span>
                        </button>
                    </div>
                </div>

                <!-- Presets -->
                <div style="display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap;">
                    <span style="font-size:0.75rem;color:var(--text-muted);font-weight:600;"><?= $isDe ? 'Vorschläge:' : 'Presets:' ?></span>
                    <button type="button" class="pill-choice" onclick="setWhoisQuery('ternis.org')">ternis.org</button>
                    <button type="button" class="pill-choice" onclick="setWhoisQuery('ternisdomains.de')">ternisdomains.de</button>
                    <button type="button" class="pill-choice" onclick="setWhoisQuery('denic.de')">denic.de</button>
                    <button type="button" class="pill-choice" onclick="setWhoisQuery('example.com')">example.com</button>
                    <button type="button" class="pill-choice" onclick="setWhoisQuery('kernel.org')">kernel.org</button>
                    <button type="button" class="pill-choice" onclick="setWhoisQuery('cloudflare.com')">cloudflare.com</button>
                </div>
            </div>
        </form>

        <!-- Privacy Callout -->
        <div style="margin-top:1.25rem;padding-top:1rem;border-top:1px solid var(--border-subtle);display:flex;align-items:center;gap:0.65rem;font-size:0.8125rem;color:var(--text-muted);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
            <span>
                <?= $isDe
                    ? '<strong>Kein Frontrunning:</strong> Deine Anfragen werden niemals an Dritte verkauft oder für Domain-Spekulationen protokolliert.'
                    : '<strong>Zero Frontrunning:</strong> Your lookups are never tracked, monetized, or logged. Complete European query privacy.'
                ?>
            </span>
        </div>
    </div>

    <!-- Loading Spinner -->
    <div id="whoisLoading" style="display:none;text-align:center;padding:3rem 1rem;">
        <div style="display:inline-block;width:38px;height:38px;border:3px solid var(--border-subtle);border-top-color:var(--primary);border-radius:50%;animation:whoisSpin 0.8s linear infinite;"></div>
        <p style="margin-top:1rem;color:var(--text-muted);font-size:0.9375rem;"><?= $isDe ? 'Autoritative RDAP-Registry wird abgefragt…' : 'Querying authoritative RDAP registry…' ?></p>
    </div>

    <style>
        @keyframes whoisSpin {
            to { transform: rotate(360deg); }
        }
    </style>

    <!-- Results Container -->
    <div id="whoisResults" style="display:none;">
        <!-- Status Banner -->
        <div id="whoisStatusBanner" class="whois-status-card registered">
            <div style="display:flex;align-items:center;gap:0.85rem;flex-wrap:wrap;">
                <span id="whoisBadgeState" class="whois-pill-tag secure" style="font-size:0.875rem;padding:0.35rem 0.85rem;">
                    Registered &bull; Active
                </span>
                <span id="whoisResultDomain" style="font-size:1.35rem;font-weight:700;font-family:var(--font-mono);color:var(--text-main);">
                    domain.com
                </span>
            </div>
            <div style="display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap;">
                <span id="whoisExpiryCountdown" class="tool-badge-pill" style="margin-bottom:0;">
                    Expires in ...
                </span>
                <span id="whoisDnssecBadge" class="whois-pill-tag secure">
                    DNSSEC Signed
                </span>
            </div>
        </div>

        <!-- Available Domain Callout (Shown when available) -->
        <div id="whoisAvailableBox" class="tool-card" style="display:none;margin-bottom:2rem;background:rgba(34,197,94,0.06);border-color:rgba(34,197,94,0.3);text-align:center;padding:2.5rem 1.5rem;">
            <div style="width:52px;height:52px;border-radius:50%;background:rgba(34,197,94,0.15);color:#16a34a;display:inline-flex;align-items:center;justify-content:center;margin-bottom:1rem;">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </div>
            <h3 style="font-size:1.5rem;font-weight:700;margin:0 0 0.5rem;color:var(--text-main);">
                <span id="whoisAvailableDomain">domain.de</span> <?= $isDe ? 'ist verfügbar!' : 'is available!' ?>
            </h3>
            <p style="color:var(--text-muted);font-size:0.95rem;max-width:550px;margin:0 auto 1.5rem;line-height:1.55;">
                <?= $isDe
                    ? 'Diese Domain ist aktuell in keinem Registry-Verzeichnis registriert und kann registriert werden.'
                    : 'This domain name is currently unregistered and available for registration.'
                ?>
            </p>
            <div style="display:flex;justify-content:center;gap:1rem;flex-wrap:wrap;">
                <a href="https://ternisdomains.de" target="_blank" rel="noopener noreferrer" class="tool-btn-primary">
                    <span>ternisdomains.de <?= $isDe ? 'öffnen' : 'Registration' ?> &rarr;</span>
                </a>
            </div>
        </div>

        <!-- Grid of 4 Detail Cards -->
        <div id="whoisDetailsGrid" class="whois-grid">
            <!-- Card 1: Registration Lifecycle -->
            <div class="whois-box">
                <div>
                    <div class="whois-box-title">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        <span><?= $isDe ? 'Lebenszyklus & Daten' : 'Registration Lifecycle' ?></span>
                    </div>
                    <div class="whois-meta-list">
                        <div class="whois-meta-item">
                            <span class="whois-meta-label"><?= $isDe ? 'Registriert am:' : 'Registered On:' ?></span>
                            <span id="whoisCreatedDate" class="whois-meta-val">-</span>
                        </div>
                        <div class="whois-meta-item">
                            <span class="whois-meta-label"><?= $isDe ? 'Ablaufdatum:' : 'Expires On:' ?></span>
                            <span id="whoisExpiryDate" class="whois-meta-val">-</span>
                        </div>
                        <div class="whois-meta-item">
                            <span class="whois-meta-label"><?= $isDe ? 'Zuletzt aktualisiert:' : 'Last Updated:' ?></span>
                            <span id="whoisUpdatedDate" class="whois-meta-val">-</span>
                        </div>
                        <div class="whois-meta-item">
                            <span class="whois-meta-label"><?= $isDe ? 'Registry-Kennung:' : 'Registry Handle:' ?></span>
                            <span id="whoisRegistryHandle" class="whois-meta-val">-</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Sponsoring Registrar -->
            <div class="whois-box">
                <div>
                    <div class="whois-box-title">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7.5" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>
                        <span><?= $isDe ? 'Registrar & IANA' : 'Sponsoring Registrar' ?></span>
                    </div>
                    <div class="whois-meta-list">
                        <div class="whois-meta-item">
                            <span class="whois-meta-label"><?= $isDe ? 'Registrar:' : 'Registrar Name:' ?></span>
                            <span id="whoisRegistrarName" class="whois-meta-val">-</span>
                        </div>
                        <div class="whois-meta-item">
                            <span class="whois-meta-label"><?= $isDe ? 'IANA ID:' : 'IANA ID:' ?></span>
                            <span id="whoisRegistrarIana" class="whois-meta-val">-</span>
                        </div>
                        <div class="whois-meta-item">
                            <span class="whois-meta-label"><?= $isDe ? 'Abuse E-Mail:' : 'Abuse Contact:' ?></span>
                            <span id="whoisRegistrarAbuse" class="whois-meta-val">-</span>
                        </div>
                        <div class="whois-meta-item">
                            <span class="whois-meta-label"><?= $isDe ? 'Website:' : 'Registrar URL:' ?></span>
                            <span id="whoisRegistrarUrl" class="whois-meta-val">-</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: DNSSEC & Security Status -->
            <div class="whois-box">
                <div>
                    <div class="whois-box-title">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        <span><?= $isDe ? 'DNSSEC & EPP Status' : 'DNSSEC & EPP Status' ?></span>
                    </div>
                    <div class="whois-meta-list" style="margin-bottom:0.85rem;">
                        <div class="whois-meta-item">
                            <span class="whois-meta-label">DNSSEC:</span>
                            <span id="whoisDnssecText" class="whois-meta-val">-</span>
                        </div>
                    </div>
                    <div class="whois-meta-label" style="margin-bottom:0.4rem;font-size:0.75rem;font-weight:600;text-transform:uppercase;">
                        <?= $isDe ? 'EPP-Statuscodes:' : 'EPP Status Codes:' ?>
                    </div>
                    <div id="whoisStatusesList" style="display:flex;flex-wrap:wrap;gap:0.35rem;">
                        <span class="epp-badge">active</span>
                    </div>
                </div>
            </div>

            <!-- Card 4: Nameservers -->
            <div class="whois-box">
                <div>
                    <div class="whois-box-title">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                        <span><?= $isDe ? 'Autoritative Nameserver' : 'Authoritative Nameservers' ?></span>
                    </div>
                    <div id="whoisNameserversList" style="display:flex;flex-direction:column;gap:0.5rem;margin-bottom:1rem;">
                        <span class="whois-meta-val">-</span>
                    </div>
                </div>
                <div style="padding-top:0.85rem;border-top:1px solid var(--border-subtle);display:flex;gap:0.5rem;">
                    <a id="whoisDnsGlassLink" href="/<?= e($lang) ?>/tools/dns" class="btn btn-secondary btn-sm" style="flex:1;justify-content:center;font-size:0.75rem;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <span>DNS Looking Glass</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Raw JSON Collapsible Card -->
        <details class="tool-card" style="margin-bottom:2.5rem;padding:1.25rem 1.5rem;">
            <summary style="cursor:pointer;font-weight:700;font-size:0.9375rem;color:var(--text-main);display:flex;align-items:center;justify-content:space-between;user-select:none;">
                <span style="display:flex;align-items:center;gap:0.5rem;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
                    <span><?= $isDe ? 'Rohdaten der RDAP-Registry (JSON)' : 'Raw RDAP Registry Response (JSON)' ?></span>
                </span>
                <span style="font-size:0.8125rem;color:var(--primary);font-weight:600;"><?= $isDe ? 'Anzeigen / Verbergen' : 'Toggle' ?></span>
            </summary>
            <div style="margin-top:1.25rem;">
                <div style="display:flex;justify-content:flex-end;gap:0.5rem;margin-bottom:0.75rem;">
                    <button type="button" class="tool-copy-btn" onclick="copyRawWhoisJson()">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        <span><?= $isDe ? 'JSON kopieren' : 'Copy JSON' ?></span>
                    </button>
                </div>
                <pre id="whoisRawJson" class="tool-terminal" style="max-height:420px;margin:0;"></pre>
            </div>
        </details>

        <!-- Educational & Related Wiki Guides -->
        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:1.25rem;margin-top:2rem;">
            <div class="tool-card" style="padding:1.5rem;">
                <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.75rem;color:var(--primary);font-weight:700;font-size:0.9375rem;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                    <span><?= $isDe ? 'Wiki: WHOIS & RDAP Guide' : 'Wiki: WHOIS & RDAP Guide' ?></span>
                </div>
                <p style="font-size:0.875rem;color:var(--text-muted);line-height:1.55;margin:0 0 1rem;">
                    <?= $isDe
                        ? 'Erfahre, wie das Registration Data Access Protocol (RDAP) das alte Port-43-Protokoll ablöst und wie DSGVO-Datenschutz bei TLDs umgesetzt wird.'
                        : 'Learn how RDAP replaced port-43 WHOIS, how tiered access works, and how GDPR privacy redaction protects registrants.'
                    ?>
                </p>
                <a href="/<?= e($lang) ?>/wiki/domains/whois-rdaps-privacy" class="btn btn-secondary btn-sm" style="font-size:0.8125rem;">
                    <span><?= $isDe ? 'Anleitung lesen' : 'Read Guide' ?> &rarr;</span>
                </a>
            </div>

            <div class="tool-card" style="padding:1.5rem;">
                <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.75rem;color:var(--primary);font-weight:700;font-size:0.9375rem;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                    <span><?= $isDe ? 'Wiki: Wie Domains funktionieren' : 'Wiki: How Domains Work' ?></span>
                </div>
                <p style="font-size:0.875rem;color:var(--text-muted);line-height:1.55;margin:0 0 1rem;">
                    <?= $isDe
                        ? 'Verstehe Root-Nameserver, TLD-Zonen, Registrars, Registries und die DNS-Auflösungskette im Detail.'
                        : 'Understand root servers, TLD zones, registry vs registrar roles, and authoritative nameserver delegations.'
                    ?>
                </p>
                <a href="/<?= e($lang) ?>/wiki/domains/how-domains-work" class="btn btn-secondary btn-sm" style="font-size:0.8125rem;">
                    <span><?= $isDe ? 'Anleitung lesen' : 'Read Guide' ?> &rarr;</span>
                </a>
            </div>

            <div class="tool-card" style="padding:1.5rem;">
                <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.75rem;color:var(--primary);font-weight:700;font-size:0.9375rem;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                    <span>ternisdomains.de</span>
                </div>
                <p style="font-size:0.875rem;color:var(--text-muted);line-height:1.55;margin:0 0 1rem;">
                    <?= $isDe
                        ? 'Registriere und verwalte Domains zu fairen Selbstkostenpreisen ohne versteckte Preiserhöhungen.'
                        : 'Register and manage domains with transparent at-cost pricing and instant Anycast DNS management.'
                    ?>
                </p>
                <a href="https://ternisdomains.de" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm" style="font-size:0.8125rem;">
                    <span>ternisdomains.de &rarr;</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    var currentWhoisData = null;
    var currentLang = '<?= e($lang) ?>';

    function setWhoisQuery(domain) {
        document.getElementById('whoisDomainInput').value = domain;
        executeWhoisLookup();
    }

    function formatDate(isoStr) {
        if (!isoStr) return '-';
        try {
            var d = new Date(isoStr);
            if (isNaN(d.getTime())) return isoStr;
            return d.toLocaleDateString(currentLang === 'de' ? 'de-DE' : 'en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
        } catch (e) {
            return isoStr;
        }
    }

    function calculateDaysLeft(isoStr) {
        if (!isoStr) return null;
        try {
            var exp = new Date(isoStr).getTime();
            var now = Date.now();
            var diffMs = exp - now;
            var days = Math.round(diffMs / (1000 * 60 * 60 * 24));
            return days;
        } catch (e) {
            return null;
        }
    }

    function executeWhoisLookup(ev) {
        if (ev) ev.preventDefault();
        var domainInput = document.getElementById('whoisDomainInput');
        var rawDomain = domainInput.value.trim().toLowerCase();
        
        // Clean input
        rawDomain = rawDomain.replace(/^https?:\/\//i, '').replace(/\/.*$/, '').replace(/:\d+$/, '').replace(/^\.+|\.+$/g, '');
        if (!rawDomain) return;

        var loadingEl = document.getElementById('whoisLoading');
        var resultsEl = document.getElementById('whoisResults');
        var submitBtn = document.getElementById('whoisSubmitBtn');

        loadingEl.style.display = 'block';
        resultsEl.style.display = 'none';
        submitBtn.disabled = true;

        // Update URL query
        try {
            var newUrl = new URL(window.location.href);
            newUrl.searchParams.set('domain', rawDomain);
            window.history.replaceState({}, '', newUrl.toString());
        } catch (e) {}

        fetch('/api/tools/whois?domain=' + encodeURIComponent(rawDomain))
            .then(function(res) {
                return res.json().then(function(json) {
                    return { ok: res.ok, status: res.status, data: json };
                });
            })
            .then(function(response) {
                loadingEl.style.display = 'none';
                submitBtn.disabled = false;
                resultsEl.style.display = 'block';
                currentWhoisData = response.data;
                renderWhoisResult(rawDomain, response.data);
            })
            .catch(function(err) {
                loadingEl.style.display = 'none';
                submitBtn.disabled = false;
                if (window.WikiToast) {
                    window.WikiToast.error('Network error during RDAP query', 'Error');
                } else {
                    alert('Network error while querying RDAP.');
                }
            });
    }

    function renderWhoisResult(domain, data) {
        var isRegistered = data && data.registered === true;
        var banner = document.getElementById('whoisStatusBanner');
        var availableBox = document.getElementById('whoisAvailableBox');
        var detailsGrid = document.getElementById('whoisDetailsGrid');

        document.getElementById('whoisResultDomain').textContent = domain;
        document.getElementById('whoisAvailableDomain').textContent = domain;

        if (!isRegistered) {
            // Available
            banner.className = 'whois-status-card available';
            document.getElementById('whoisBadgeState').className = 'whois-pill-tag secure';
            document.getElementById('whoisBadgeState').textContent = currentLang === 'de' ? 'Frei • Verfügbar' : 'Available • Unregistered';
            document.getElementById('whoisExpiryCountdown').textContent = currentLang === 'de' ? 'Nicht registriert' : 'Not registered';
            document.getElementById('whoisDnssecBadge').style.display = 'none';

            availableBox.style.display = 'block';
            detailsGrid.style.display = 'none';
        } else {
            // Registered
            banner.className = 'whois-status-card registered';
            document.getElementById('whoisBadgeState').className = 'whois-pill-tag secure';
            document.getElementById('whoisBadgeState').textContent = currentLang === 'de' ? 'Registriert • Aktiv' : 'Registered • Active';
            availableBox.style.display = 'none';
            detailsGrid.style.display = 'grid';

            // Lifecycle
            var events = data.events || {};
            var created = events.registration || events.created || '';
            var expires = events.expiration || events.expires || '';
            var updated = events['last changed'] || events['last update'] || events.updated || '';

            document.getElementById('whoisCreatedDate').textContent = formatDate(created);
            document.getElementById('whoisExpiryDate').textContent = formatDate(expires);
            document.getElementById('whoisUpdatedDate').textContent = formatDate(updated);
            document.getElementById('whoisRegistryHandle').textContent = data.handle || (domain.toUpperCase());

            var daysLeft = calculateDaysLeft(expires);
            var expiryCountdownEl = document.getElementById('whoisExpiryCountdown');
            if (daysLeft !== null && daysLeft > 0) {
                expiryCountdownEl.textContent = (currentLang === 'de' ? 'Läuft ab in ' : 'Expires in ') + daysLeft + (currentLang === 'de' ? ' Tagen' : ' days');
                expiryCountdownEl.style.display = 'inline-flex';
            } else if (daysLeft !== null && daysLeft <= 0) {
                expiryCountdownEl.textContent = currentLang === 'de' ? 'Abgelaufen' : 'Expired';
                expiryCountdownEl.style.display = 'inline-flex';
            } else {
                expiryCountdownEl.style.display = 'none';
            }

            // Registrar
            var reg = data.registrar || {};
            document.getElementById('whoisRegistrarName').textContent = reg.name || 'Authoritative Registry';
            document.getElementById('whoisRegistrarIana').textContent = reg.iana_id || '-';
            
            var abuseEl = document.getElementById('whoisRegistrarAbuse');
            if (reg.abuse) {
                abuseEl.innerHTML = '<a href="mailto:' + reg.abuse + '" style="color:var(--primary);text-decoration:none;">' + reg.abuse + '</a>';
            } else {
                abuseEl.textContent = '-';
            }

            var regUrlEl = document.getElementById('whoisRegistrarUrl');
            if (reg.url) {
                regUrlEl.innerHTML = '<a href="' + reg.url + '" target="_blank" rel="noopener noreferrer" style="color:var(--primary);text-decoration:none;">' + reg.url.replace(/^https?:\/\//i, '').replace(/\/.*$/, '') + ' &rarr;</a>';
            } else {
                regUrlEl.textContent = '-';
            }

            // DNSSEC
            var dnssecBadge = document.getElementById('whoisDnssecBadge');
            var dnssecText = document.getElementById('whoisDnssecText');
            if (data.dnssec) {
                dnssecBadge.className = 'whois-pill-tag secure';
                dnssecBadge.textContent = 'DNSSEC Signed';
                dnssecBadge.style.display = 'inline-flex';
                dnssecText.innerHTML = '<span style="color:#16a34a;font-weight:600;">Delegation Signed (DS in parent zone)</span>';
            } else {
                dnssecBadge.className = 'whois-pill-tag insecure';
                dnssecBadge.textContent = 'DNSSEC Unsigned';
                dnssecBadge.style.display = 'inline-flex';
                dnssecText.innerHTML = '<span style="color:var(--text-muted);">Unsigned / Insecure</span>';
            }

            // EPP Statuses
            var statusListEl = document.getElementById('whoisStatusesList');
            statusListEl.innerHTML = '';
            var statuses = data.statuses || ['active'];
            statuses.forEach(function(s) {
                var badge = document.createElement('span');
                badge.className = 'epp-badge';
                badge.textContent = s;
                statusListEl.appendChild(badge);
            });

            // Nameservers
            var nsListEl = document.getElementById('whoisNameserversList');
            nsListEl.innerHTML = '';
            var ns = data.nameservers || [];
            if (!ns.length) {
                nsListEl.innerHTML = '<span style="color:var(--text-muted);font-size:0.875rem;">None reported by registry</span>';
            } else {
                ns.forEach(function(item) {
                    var nsItem = document.createElement('div');
                    nsItem.style.display = 'flex';
                    nsItem.style.alignItems = 'center';
                    nsItem.style.justifyContent = 'space-between';
                    nsItem.style.gap = '0.5rem';
                    nsItem.innerHTML = '<span class="mono" style="font-size:0.8125rem;color:var(--text-main);font-weight:600;">' + item + '</span>' +
                        '<button type="button" class="tool-copy-btn" style="padding:0.15rem 0.4rem;font-size:0.7rem;" onclick="copySingleNs(\'' + item + '\')">Copy</button>';
                    nsListEl.appendChild(nsItem);
                });
            }

            // Looking glass button
            var dnsGlassLink = document.getElementById('whoisDnsGlassLink');
            dnsGlassLink.href = '/' + currentLang + '/tools/dns?domain=' + encodeURIComponent(domain);
        }

        // Raw JSON
        var rawJsonEl = document.getElementById('whoisRawJson');
        rawJsonEl.textContent = JSON.stringify(data, null, 2);
    }

    function copyRawWhoisJson() {
        if (!currentWhoisData) return;
        var text = JSON.stringify(currentWhoisData, null, 2);
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(function() {
                if (window.WikiToast) {
                    window.WikiToast.success('Raw RDAP JSON copied to clipboard', 'Copied');
                }
            });
        }
    }

    function copySingleNs(nsText) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(nsText).then(function() {
                if (window.WikiToast) {
                    window.WikiToast.success(nsText, 'Nameserver Copied');
                }
            });
        }
    }

    // Auto-inspect if query parameter present
    window.addEventListener('DOMContentLoaded', function() {
        var params = new URLSearchParams(window.location.search);
        var qDomain = params.get('domain');
        if (qDomain) {
            document.getElementById('whoisDomainInput').value = qDomain;
            executeWhoisLookup();
        } else {
            // Default initial lookup
            executeWhoisLookup();
        }
    });
</script>
