<?php

declare(strict_types=1);

/**
 * Live DNS Looking Glass & Inspector View
 * Path: /{lang}/tools/dns
 *
 * @var string $lang
 */

$lang = $lang ?? current_lang();
$isDe = $lang === 'de';

$title = $isDe ? 'Live DNS Looking Glass & Inspektor — ternis.org' : 'Live DNS Looking Glass & Inspector — ternis.org';
$metaDescription = $isDe
    ? 'Echtzeit-DNS-Resolver mit DNSSEC-Validierung: Frage A, AAAA, MX, TXT, NS, SOA und CAA Records über Cloudflare und Google DoH ab.'
    : 'Real-time DNS looking glass with DNSSEC validation: Query A, AAAA, MX, TXT, NS, SOA, and CAA records via Cloudflare & Google DoH.';
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
        <span style="color:var(--text-main);font-weight:600;"><?= $isDe ? 'Live DNS Looking Glass' : 'Live DNS Looking Glass' ?></span>
    </nav>

    <!-- Header -->
    <header class="tool-header">
        <div class="tool-badge-pill">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
            <span>DNS over HTTPS (DoH) &bull; DNSSEC Validated</span>
        </div>
        <h1 class="tool-title">
            <?= $isDe ? 'Live DNS Looking Glass' : 'Live DNS Looking Glass' ?>
        </h1>
        <p class="tool-desc">
            <?= $isDe
                ? 'Inspiziere autoritative Zoneneinträge weltweit in Echtzeit. Unterstützt DNSSEC Authenticated Data (AD), Latenz-Telemetrie und standardisierte DNS-Recordtypen.'
                : 'Inspect authoritative zone records globally in real time. Features cryptographic DNSSEC Authenticated Data (AD) verification, latency telemetry, and raw JSON export.'
            ?>
        </p>
    </header>

    <!-- Main Tool Card -->
    <div class="tool-card" style="margin-bottom:2rem;">
        <form id="dnsForm" onsubmit="executeDnsLookup(event)">
            <div style="display:grid;grid-template-columns:1fr;gap:1.25rem;">
                <!-- Hostname input -->
                <div class="tool-form-group" style="margin-bottom:0;">
                    <label class="tool-label" for="dnsDomainInput">
                        <?= $isDe ? 'Domain oder Hostname' : 'Domain or Hostname' ?>
                    </label>
                    <div style="display:flex;gap:0.75rem;">
                        <input type="text" id="dnsDomainInput" class="tool-input mono" placeholder="ternis.net" value="ternis.net" required autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" style="font-size:1.0625rem;">
                        <button type="submit" id="dnsSubmitBtn" class="tool-btn-primary" style="flex-shrink:0;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <span><?= $isDe ? 'Abfragen' : 'Resolve' ?></span>
                        </button>
                    </div>
                </div>

                <!-- Presets -->
                <div style="display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap;">
                    <span style="font-size:0.75rem;color:var(--text-muted);font-weight:600;"><?= $isDe ? 'Vorschläge:' : 'Presets:' ?></span>
                    <button type="button" class="pill-choice" onclick="setDnsQuery('ternis.net', 'A')">ternis.net</button>
                    <button type="button" class="pill-choice" onclick="setDnsQuery('one.ns.ternis.net', 'A')">one.ns.ternis.net</button>
                    <button type="button" class="pill-choice" onclick="setDnsQuery('href.nz', 'A')">href.nz</button>
                    <button type="button" class="pill-choice" onclick="setDnsQuery('ternis.org', 'MX')">ternis.org (MX)</button>
                    <button type="button" class="pill-choice" onclick="setDnsQuery('ternisdomains.de', 'TXT')">ternisdomains.de (TXT)</button>
                </div>

                <!-- Record Type Pills -->
                <div class="tool-form-group" style="margin-bottom:0;">
                    <label class="tool-label"><?= $isDe ? 'Record-Typ' : 'Record Type' ?></label>
                    <div class="pills-group" id="dnsRecordTypeGroup">
                        <button type="button" class="pill-choice active" onclick="setRecordType('A')">A (IPv4)</button>
                        <button type="button" class="pill-choice" onclick="setRecordType('AAAA')">AAAA (IPv6)</button>
                        <button type="button" class="pill-choice" onclick="setRecordType('MX')">MX (Mail)</button>
                        <button type="button" class="pill-choice" onclick="setRecordType('TXT')">TXT (SPF/DKIM)</button>
                        <button type="button" class="pill-choice" onclick="setRecordType('NS')">NS (Nameserver)</button>
                        <button type="button" class="pill-choice" onclick="setRecordType('SOA')">SOA (Zone Auth)</button>
                        <button type="button" class="pill-choice" onclick="setRecordType('CAA')">CAA (TLS Cert)</button>
                        <button type="button" class="pill-choice" onclick="setRecordType('CNAME')">CNAME</button>
                        <button type="button" class="pill-choice" onclick="setRecordType('PTR')">PTR (Reverse)</button>
                    </div>
                </div>

                <!-- Upstream Resolver Options -->
                <div style="display:flex;align-items:center;gap:1.5rem;flex-wrap:wrap;padding-top:0.75rem;border-top:1px solid var(--border-subtle);">
                    <div style="display:flex;align-items:center;gap:0.5rem;">
                        <label class="tool-label" for="dnsResolverSelect" style="margin:0;font-size:0.8125rem;color:var(--text-muted);"><?= $isDe ? 'Upstream Resolver:' : 'Upstream Resolver:' ?></label>
                        <select id="dnsResolverSelect" class="tool-select" style="width:auto;padding:0.45rem 0.75rem;font-size:0.8125rem;" onchange="executeDnsLookup()">
                            <option value="cloudflare">Cloudflare DoH (1.1.1.1)</option>
                            <option value="google">Google DoH (8.8.8.8)</option>
                            <option value="backend">ternis.org Backend Resolver</option>
                        </select>
                    </div>
                    <label style="display:inline-flex;align-items:center;gap:0.4rem;font-size:0.8125rem;color:var(--text-muted);cursor:pointer;">
                        <input type="checkbox" id="dnssecCheck" checked onchange="executeDnsLookup()">
                        <span><?= $isDe ? 'DNSSEC-Prüfung anfordern (DO)' : 'Require DNSSEC validation (DO)' ?></span>
                    </label>
                </div>
            </div>
        </form>
    </div>

    <!-- Results Section -->
    <div id="dnsResultSection" style="display:none;" class="tool-card">
        <!-- Telemetry Header -->
        <div class="tool-card-header" style="flex-wrap:wrap;gap:0.75rem;">
            <div style="display:flex;align-items:center;gap:0.75rem;">
                <h2 class="tool-card-title" id="dnsResultTitle" style="font-family:var(--font-mono);">
                    ternis.net
                </h2>
                <span class="dns-type-badge" id="dnsResultTypeBadge">A</span>
            </div>

            <div style="display:flex;align-items:center;gap:0.6rem;flex-wrap:wrap;">
                <!-- Latency Badge -->
                <span style="font-family:var(--font-mono);font-size:0.75rem;padding:0.25rem 0.6rem;border-radius:6px;background:var(--bg-color);border:1px solid var(--border-subtle);color:var(--text-muted);display:inline-flex;align-items:center;gap:0.35rem;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    <span id="dnsLatencyVal">21 ms</span>
                </span>

                <!-- DNSSEC Badge -->
                <span class="dns-sec-badge" id="dnssecBadge">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    <span id="dnssecBadgeText">DNSSEC Validated</span>
                </span>

                <!-- Status Badge -->
                <span id="dnsStatusBadge" style="font-family:var(--font-mono);font-size:0.75rem;padding:0.25rem 0.6rem;border-radius:6px;background:rgba(22,163,74,0.1);color:#16a34a;border:1px solid rgba(22,163,74,0.3);font-weight:700;">
                    NOERROR
                </span>

                <button type="button" class="tool-copy-btn" onclick="toggleRawJson()">
                    <span id="rawJsonBtnText">Raw JSON</span>
                </button>
            </div>
        </div>

        <!-- Answers Table -->
        <div class="dns-table-container">
            <table class="dns-table">
                <thead>
                    <tr>
                        <th style="width:28%;"><?= $isDe ? 'Name' : 'Name' ?></th>
                        <th style="width:12%;"><?= $isDe ? 'Typ' : 'Type' ?></th>
                        <th style="width:12%;">TTL</th>
                        <th style="width:48%;"><?= $isDe ? 'Daten / Wert' : 'Data / Target' ?></th>
                    </tr>
                </thead>
                <tbody id="dnsAnswerRows">
                    <!-- Populated dynamically -->
                </tbody>
            </table>
        </div>

        <!-- Empty / No records message -->
        <div id="dnsEmptyMsg" style="display:none;padding:2rem;text-align:center;color:var(--text-muted);font-size:0.875rem;">
            <?= $isDe ? 'Keine Records für diesen Typ gefunden (NODATA).' : 'No records returned for this query type (NODATA).' ?>
        </div>

        <!-- Raw JSON Container -->
        <div id="dnsRawJsonContainer" style="display:none;margin-top:1.5rem;">
            <div class="tool-result-header">
                <span>DNS Protocol Response (JSON)</span>
                <button type="button" class="tool-copy-btn" onclick="copyRawDnsJson()">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                    <span><?= $isDe ? 'Kopieren' : 'Copy' ?></span>
                </button>
            </div>
            <pre class="tool-terminal" id="dnsRawJsonOutput" style="font-size:0.8125rem;max-height:350px;"></pre>
        </div>
    </div>

    <!-- Informational Footer -->
    <div style="background:var(--surface);border:1px solid var(--border-subtle);border-radius:14px;padding:1.5rem;display:flex;align-items:center;justify-content:space-between;gap:1.5rem;flex-wrap:wrap;">
        <div style="display:flex;align-items:center;gap:0.85rem;">
            <div style="width:40px;height:40px;border-radius:8px;background:rgba(234,88,12,0.1);color:var(--primary);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="7" rx="1.5"></rect><rect x="3" y="13" width="18" height="7" rx="1.5"></rect><path d="M6.5 7.5h.01"></path><path d="M6.5 16.5h.01"></path></svg>
            </div>
            <div>
                <h3 style="font-size:0.9375rem;font-weight:700;margin:0 0 0.2rem;">
                    <?= $isDe ? 'Souveräne Nameserver auf ternis.net' : 'Autonomous Nameservers on ternis.net' ?>
                </h3>
                <p style="margin:0;font-size:0.8125rem;color:var(--text-muted);">
                    <?= $isDe
                        ? 'Unsere Anycast-Nameserver one.ns.ternis.net und two.ns.ternis.net bieten kryptografische DNSSEC-Validierung (ECDSA P-256).'
                        : 'Our authoritative nameservers one.ns.ternis.net and two.ns.ternis.net provide ECDSA P-256 DNSSEC signing.'
                    ?>
                </p>
            </div>
        </div>
        <a href="/<?= e($lang) ?>/infrastructure" class="tool-btn-secondary" style="font-size:0.8125rem;padding:0.45rem 0.85rem;">
            <span><?= $isDe ? 'Infrastruktur ansehen &rarr;' : 'View Infrastructure &rarr;' ?></span>
        </a>
    </div>
</div>

<script>
let currentRecordType = 'A';
let lastDnsResponse = null;

const DNS_TYPE_CODES = {
    1: 'A',
    28: 'AAAA',
    15: 'MX',
    16: 'TXT',
    2: 'NS',
    6: 'SOA',
    257: 'CAA',
    5: 'CNAME',
    12: 'PTR'
};

const RCODE_NAMES = {
    0: 'NOERROR',
    1: 'FORMERR',
    2: 'SERVFAIL',
    3: 'NXDOMAIN',
    4: 'NOTIMP',
    5: 'REFUSED',
    6: 'YXDOMAIN',
    7: 'YXRRSET',
    8: 'NXRRSET',
    9: 'NOTAUTH',
    10: 'NOTZONE'
};

function setRecordType(type) {
    currentRecordType = type;
    const btns = document.querySelectorAll('#dnsRecordTypeGroup .pill-choice');
    btns.forEach(b => {
        const text = b.textContent.trim().split(' ')[0];
        b.classList.toggle('active', text === type);
    });
    executeDnsLookup();
}

function setDnsQuery(domain, type) {
    document.getElementById('dnsDomainInput').value = domain;
    setRecordType(type);
}

async function executeDnsLookup(e) {
    if (e) e.preventDefault();
    const domain = document.getElementById('dnsDomainInput').value.trim();
    if (!domain) return;

    const submitBtn = document.getElementById('dnsSubmitBtn');
    const resolver = document.getElementById('dnsResolverSelect').value;
    const dnssecRequired = document.getElementById('dnssecCheck').checked;

    submitBtn.disabled = true;
    const startTime = performance.now();

    try {
        let data;
        if (resolver === 'backend') {
            const res = await fetch(`/api/tools/dns?name=${encodeURIComponent(domain)}&type=${currentRecordType}`);
            data = await res.json();
        } else if (resolver === 'google') {
            const url = `https://dns.google/resolve?name=${encodeURIComponent(domain)}&type=${currentRecordType}&do=${dnssecRequired ? '1' : '0'}`;
            const res = await fetch(url);
            data = await res.json();
        } else {
            // Cloudflare DoH
            const url = `https://cloudflare-dns.com/dns-query?name=${encodeURIComponent(domain)}&type=${currentRecordType}&do=${dnssecRequired ? '1' : '0'}`;
            const res = await fetch(url, { headers: { 'Accept': 'application/dns-json' } });
            data = await res.json();
        }

        const elapsed = Math.round(performance.now() - startTime);
        renderDnsResults(domain, data, elapsed);
    } catch (err) {
        // Fallback to internal backend if browser fetch blocked by CORS or extension
        try {
            const res = await fetch(`/api/tools/dns?name=${encodeURIComponent(domain)}&type=${currentRecordType}`);
            const data = await res.json();
            const elapsed = Math.round(performance.now() - startTime);
            renderDnsResults(domain, data, elapsed);
        } catch (innerErr) {
            alert('DNS query failed: ' + err.message);
        }
    } finally {
        submitBtn.disabled = false;
    }
}

function renderDnsResults(domain, data, latency) {
    lastDnsResponse = data;
    const section = document.getElementById('dnsResultSection');
    section.style.display = 'block';

    document.getElementById('dnsResultTitle').textContent = domain;
    document.getElementById('dnsResultTypeBadge').textContent = currentRecordType;
    document.getElementById('dnsLatencyVal').textContent = `${latency} ms`;

    // DNSSEC Status
    const isAd = Boolean(data.AD);
    const dnssecBadge = document.getElementById('dnssecBadge');
    const dnssecText = document.getElementById('dnssecBadgeText');
    if (isAd) {
        dnssecBadge.className = 'dns-sec-badge secure';
        dnssecText.textContent = 'DNSSEC Validated (AD=1)';
    } else {
        dnssecBadge.className = 'dns-sec-badge insecure';
        dnssecText.textContent = 'DNSSEC Unvalidated (AD=0)';
    }

    // Status code
    const rcode = data.Status ?? 0;
    const statusText = RCODE_NAMES[rcode] || `RCODE ${rcode}`;
    const statusBadge = document.getElementById('dnsStatusBadge');
    statusBadge.textContent = statusText;
    if (rcode === 0) {
        statusBadge.style.background = 'rgba(22,163,74,0.1)';
        statusBadge.style.color = '#16a34a';
        statusBadge.style.borderColor = 'rgba(22,163,74,0.3)';
    } else {
        statusBadge.style.background = 'rgba(239,68,68,0.1)';
        statusBadge.style.color = '#dc2626';
        statusBadge.style.borderColor = 'rgba(239,68,68,0.3)';
    }

    // Answers
    const answers = data.Answer || [];
    const tbody = document.getElementById('dnsAnswerRows');
    const emptyMsg = document.getElementById('dnsEmptyMsg');
    tbody.innerHTML = '';

    if (answers.length === 0) {
        emptyMsg.style.display = 'block';
    } else {
        emptyMsg.style.display = 'none';
        answers.forEach(record => {
            const tr = document.createElement('tr');
            const typeStr = DNS_TYPE_CODES[record.type] || record.type;
            tr.innerHTML = `
                <td style="color:var(--text-main);font-weight:600;">${escapeHtml(record.name)}</td>
                <td><span class="dns-type-badge">${escapeHtml(typeStr)}</span></td>
                <td style="color:var(--text-muted);">${record.TTL}s</td>
                <td style="font-weight:500;color:var(--text-main);">${escapeHtml(record.data)}</td>
            `;
            tbody.appendChild(tr);
        });
    }

    // Raw JSON output
    document.getElementById('dnsRawJsonOutput').textContent = JSON.stringify(data, null, 2);
}

function toggleRawJson() {
    const rawBox = document.getElementById('dnsRawJsonContainer');
    const isShown = rawBox.style.display === 'block';
    rawBox.style.display = isShown ? 'none' : 'block';
}

function copyRawDnsJson() {
    if (!lastDnsResponse) return;
    navigator.clipboard.writeText(JSON.stringify(lastDnsResponse, null, 2)).then(() => {
        alert('<?= $isDe ? 'JSON in die Zwischenablage kopiert!' : 'JSON copied to clipboard!' ?>');
    });
}

function escapeHtml(str) {
    if (typeof str !== 'string') return String(str);
    return str.replace(/[&<>'"]/g, tag => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        "'": '&#39;',
        '"': '&quot;'
    }[tag] || tag));
}

// Initial resolution on page load
document.addEventListener('DOMContentLoaded', () => {
    executeDnsLookup();
});
</script>
