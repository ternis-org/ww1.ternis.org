<?php

declare(strict_types=1);

/**
 * Cryptographic Token & Secret Generator View
 * Path: /{lang}/tools/secret-generator
 *
 * @var string $lang
 */

$lang = $lang ?? current_lang();
$isDe = $lang === 'de';

$title = $isDe ? 'Kryptografischer Token- & Passwort-Generator — ternis.org' : 'Cryptographic Token & Secret Generator — ternis.org';
$metaDescription = $isDe
    ? '100% browserbasierte Generierung von sicheren API-Tokens (tl_...), Passwörtern, Hex-Secrets und UUIDv4 mit der Web Crypto API.'
    : '100% client-side cryptographic token and password generator using the Web Crypto API. Generates API keys (tl_...), UUIDs, and hex secrets.';
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
        <span style="color:var(--text-main);font-weight:600;"><?= $isDe ? 'Token- & Secret-Generator' : 'Token & Secret Generator' ?></span>
    </nav>

    <!-- Header -->
    <header class="tool-header">
        <div class="tool-badge-pill">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            <span>Web Crypto API &bull; 100% Client-Side</span>
        </div>
        <h1 class="tool-title">
            <?= $isDe ? 'Token- & Secret-Generator' : 'Cryptographic Secret Generator' ?>
        </h1>
        <p class="tool-desc">
            <?= $isDe
                ? 'Erzeuge kryptografisch sichere Passwörter, API-Keys (tl_...), Hex-Hashes und UUIDv4 direkt in der Web Crypto Sandbox deines Browsers. Keine Daten verlassen dein Gerät.'
                : 'Generate high-entropy passwords, t-api.de keys (tl_...), hex secrets, and UUIDv4 tokens securely in your browser sandbox with zero network transmission.'
            ?>
        </p>
    </header>

    <!-- Main Grid -->
    <div class="tool-grid">
        <!-- Left: Configuration Form -->
        <div class="tool-card">
            <div class="tool-card-header">
                <h2 class="tool-card-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    <span><?= $isDe ? 'Konfiguration' : 'Token Parameters' ?></span>
                </h2>
                <span style="font-size:0.75rem;font-family:var(--font-mono);color:var(--text-muted);">
                    crypto.getRandomValues()
                </span>
            </div>

            <!-- Mode Selector -->
            <div class="tool-form-group">
                <label class="tool-label"><?= $isDe ? 'Token-Format' : 'Format / Type' ?></label>
                <div class="pills-group" id="tokenModeGroup">
                    <button type="button" class="pill-choice active" onclick="setTokenMode('api-key')">API Key (tl_...)</button>
                    <button type="button" class="pill-choice" onclick="setTokenMode('password')"><?= $isDe ? 'Passwort' : 'Password' ?></button>
                    <button type="button" class="pill-choice" onclick="setTokenMode('hex')">Hex (HMAC)</button>
                    <button type="button" class="pill-choice" onclick="setTokenMode('uuid')">UUID v4</button>
                    <button type="button" class="pill-choice" onclick="setTokenMode('base64')">Base64</button>
                </div>
            </div>

            <!-- Length slider (for password & api-key & hex) -->
            <div id="lengthContainer" class="tool-form-group">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.45rem;">
                    <label class="tool-label" for="tokenLengthInput" style="margin:0;"><?= $isDe ? 'Länge / Zeichen' : 'Length' ?></label>
                    <span id="tokenLengthVal" style="font-family:var(--font-mono);font-weight:700;color:var(--primary);font-size:0.9375rem;">36</span>
                </div>
                <input type="range" id="tokenLengthInput" min="8" max="128" value="36" style="width:100%;" oninput="document.getElementById('tokenLengthVal').textContent = this.value; generateTokens()">
            </div>

            <!-- Password Character Options -->
            <div id="passwordOptions" style="display:none;margin-bottom:1.25rem;padding:1rem;background:var(--bg-color);border-radius:10px;border:1px solid var(--border-subtle);">
                <span class="tool-label" style="font-size:0.8125rem;margin-bottom:0.75rem;"><?= $isDe ? 'Zeichensätze:' : 'Character Sets:' ?></span>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.6rem;font-size:0.8125rem;">
                    <label style="display:inline-flex;align-items:center;gap:0.45rem;cursor:pointer;">
                        <input type="checkbox" id="optUpper" checked onchange="generateTokens()">
                        <span>Großbuchstaben (A-Z)</span>
                    </label>
                    <label style="display:inline-flex;align-items:center;gap:0.45rem;cursor:pointer;">
                        <input type="checkbox" id="optLower" checked onchange="generateTokens()">
                        <span>Kleinbuchstaben (a-z)</span>
                    </label>
                    <label style="display:inline-flex;align-items:center;gap:0.45rem;cursor:pointer;">
                        <input type="checkbox" id="optDigits" checked onchange="generateTokens()">
                        <span>Zahlen (0-9)</span>
                    </label>
                    <label style="display:inline-flex;align-items:center;gap:0.45rem;cursor:pointer;">
                        <input type="checkbox" id="optSymbols" checked onchange="generateTokens()">
                        <span>Sonderzeichen (!@#$%)</span>
                    </label>
                    <label style="display:inline-flex;align-items:center;gap:0.45rem;cursor:pointer;grid-column:1/-1;">
                        <input type="checkbox" id="optExcludeAmbiguous" onchange="generateTokens()">
                        <span>Ähnliche ausschließen (1, l, I, 0, O)</span>
                    </label>
                </div>
            </div>

            <!-- Batch Count -->
            <div class="tool-form-group">
                <label class="tool-label" for="batchCountSelect"><?= $isDe ? 'Anzahl generieren' : 'Batch Count' ?></label>
                <select id="batchCountSelect" class="tool-select" onchange="generateTokens()">
                    <option value="1">1 Token</option>
                    <option value="5" selected>5 Tokens</option>
                    <option value="10">10 Tokens</option>
                    <option value="25">25 Tokens</option>
                </select>
            </div>

            <div style="margin-top:1.5rem;display:flex;gap:0.75rem;">
                <button type="button" class="tool-btn-primary" onclick="generateTokens()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/></svg>
                    <span><?= $isDe ? 'Neu generieren' : 'Regenerate' ?></span>
                </button>
            </div>
        </div>

        <!-- Right: Output List & Security Callout -->
        <div style="display:flex;flex-direction:column;gap:1.5rem;">
            <div class="tool-card">
                <div class="tool-card-header">
                    <h2 class="tool-card-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="4 17 10 11 4 5"></polyline><line x1="12" y1="19" x2="20" y2="19"></line></svg>
                        <span><?= $isDe ? 'Generierte Tokens' : 'Generated Secrets' ?></span>
                    </h2>
                    <button type="button" class="tool-copy-btn" id="copyAllBtn" onclick="copyAllTokens()">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        <span id="copyAllLabel"><?= $isDe ? 'Alle kopieren' : 'Copy All' ?></span>
                    </button>
                </div>

                <!-- Entropy Meter (shown for passwords & keys) -->
                <div id="entropyContainer" style="margin-bottom:1rem;">
                    <div style="display:flex;justify-content:space-between;font-size:0.75rem;margin-bottom:0.35rem;font-family:var(--font-mono);">
                        <span style="color:var(--text-muted);"><?= $isDe ? 'Geschätzte Entropie:' : 'Estimated Entropy:' ?></span>
                        <span id="entropyScore" style="color:#16a34a;font-weight:700;">216 bits &bull; High Security</span>
                    </div>
                    <div style="height:6px;border-radius:3px;background:var(--border-subtle);overflow:hidden;">
                        <div id="entropyBar" style="height:100%;width:90%;background:#16a34a;transition:width 0.2s ease;"></div>
                    </div>
                </div>

                <!-- Token List -->
                <div id="tokensList" style="max-height:460px;overflow-y:auto;padding-right:0.25rem;">
                    <!-- Injected dynamically -->
                </div>
            </div>

            <!-- Zero-Knowledge Callout -->
            <div class="tool-card" style="background:rgba(22,163,74,0.03);border-color:rgba(22,163,74,0.2);">
                <div style="display:flex;align-items:flex-start;gap:0.75rem;">
                    <div style="color:#16a34a;margin-top:0.15rem;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    </div>
                    <div>
                        <h4 style="margin:0 0 0.25rem;font-size:0.9375rem;font-weight:700;color:var(--text-main);">
                            <?= $isDe ? '100% Lokale Browser-Verschlüsselung' : '100% Client-Side Cryptography' ?>
                        </h4>
                        <p style="margin:0;font-size:0.8125rem;color:var(--text-muted);line-height:1.55;">
                            <?= $isDe
                                ? 'Dieser Generator verwendet die browser-eigene Web Cryptography API (CSPRNG). Die erzeugten Schlüssel existieren ausschließlich im Arbeitsspeicher deines Browsers und werden niemals über ein Netzwerk übertragen oder protokolliert.'
                                : 'All entropy is sourced from the browser’s CSPRNG (Web Crypto API). Generated keys reside strictly in memory and are never transmitted over the network or persisted anywhere.'
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentMode = 'api-key';

function setTokenMode(mode) {
    currentMode = mode;
    const btns = document.querySelectorAll('#tokenModeGroup .pill-choice');
    btns.forEach(b => b.classList.toggle('active', b.getAttribute('onclick').includes(mode)));

    const lenContainer = document.getElementById('lengthContainer');
    const passOptions = document.getElementById('passwordOptions');
    const entropyContainer = document.getElementById('entropyContainer');

    if (mode === 'uuid') {
        lenContainer.style.display = 'none';
        passOptions.style.display = 'none';
        entropyContainer.style.display = 'none';
    } else if (mode === 'password') {
        lenContainer.style.display = 'block';
        passOptions.style.display = 'block';
        entropyContainer.style.display = 'block';
        document.getElementById('tokenLengthInput').value = 32;
        document.getElementById('tokenLengthVal').textContent = '32';
    } else if (mode === 'api-key') {
        lenContainer.style.display = 'block';
        passOptions.style.display = 'none';
        entropyContainer.style.display = 'block';
        document.getElementById('tokenLengthInput').value = 36;
        document.getElementById('tokenLengthVal').textContent = '36';
    } else {
        // hex or base64
        lenContainer.style.display = 'block';
        passOptions.style.display = 'none';
        entropyContainer.style.display = 'block';
        document.getElementById('tokenLengthInput').value = 32;
        document.getElementById('tokenLengthVal').textContent = '32';
    }

    generateTokens();
}

function getRandomBytes(len) {
    const arr = new Uint8Array(len);
    window.crypto.getRandomValues(arr);
    return arr;
}

function generateApiKey(len) {
    const chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const bytes = getRandomBytes(len);
    let str = 'tl_';
    for (let i = 0; i < len; i++) {
        str += chars[bytes[i] % chars.length];
    }
    return str;
}

function generatePassword(len) {
    let chars = '';
    if (document.getElementById('optUpper').checked) chars += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if (document.getElementById('optLower').checked) chars += 'abcdefghijklmnopqrstuvwxyz';
    if (document.getElementById('optDigits').checked) chars += '0123456789';
    if (document.getElementById('optSymbols').checked) chars += '!@#$%^&*()_+-=[]{}|;:,.<>?';

    if (document.getElementById('optExcludeAmbiguous').checked) {
        chars = chars.replace(/[1lI0O]/g, '');
    }

    if (!chars) chars = 'abcdefghijklmnopqrstuvwxyz0123456789';

    const bytes = getRandomBytes(len);
    let str = '';
    for (let i = 0; i < len; i++) {
        str += chars[bytes[i] % chars.length];
    }
    return str;
}

function generateHex(bytesCount) {
    const bytes = getRandomBytes(bytesCount);
    return Array.from(bytes).map(b => b.toString(16).padStart(2, '0')).join('');
}

function generateUuid() {
    if (crypto.randomUUID) {
        return crypto.randomUUID();
    }
    const b = getRandomBytes(16);
    b[6] = (b[6] & 0x0f) | 0x40;
    b[8] = (b[8] & 0x3f) | 0x80;
    const h = Array.from(b).map(x => x.toString(16).padStart(2, '0')).join('');
    return `${h.slice(0,8)}-${h.slice(8,12)}-${h.slice(12,16)}-${h.slice(16,20)}-${h.slice(20)}`;
}

function generateBase64(bytesCount) {
    const bytes = getRandomBytes(bytesCount);
    let binary = '';
    for (let i = 0; i < bytes.byteLength; i++) {
        binary += String.fromCharCode(bytes[i]);
    }
    return btoa(binary);
}

function generateTokens() {
    const count = parseInt(document.getElementById('batchCountSelect').value, 10);
    const len = parseInt(document.getElementById('tokenLengthInput').value, 10);
    const container = document.getElementById('tokensList');
    container.innerHTML = '';

    const tokens = [];
    for (let i = 0; i < count; i++) {
        let token = '';
        if (currentMode === 'api-key') token = generateApiKey(len);
        else if (currentMode === 'password') token = generatePassword(len);
        else if (currentMode === 'hex') token = generateHex(Math.floor(len / 2));
        else if (currentMode === 'uuid') token = generateUuid();
        else if (currentMode === 'base64') token = generateBase64(len);

        tokens.push(token);

        const row = document.createElement('div');
        row.className = 'secret-output-item';
        row.innerHTML = `
            <span class="secret-output-val">${escapeHtml(token)}</span>
            <button type="button" class="tool-copy-btn" onclick="copyTokenRow(this, '${escapeHtml(token)}')">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                <span><?= $isDe ? 'Kopieren' : 'Copy' ?></span>
            </button>
        `;
        container.appendChild(row);
    }

    updateEntropyDisplay(len);
}

function updateEntropyDisplay(len) {
    let pool = 62;
    if (currentMode === 'password') {
        pool = 0;
        if (document.getElementById('optUpper').checked) pool += 26;
        if (document.getElementById('optLower').checked) pool += 26;
        if (document.getElementById('optDigits').checked) pool += 10;
        if (document.getElementById('optSymbols').checked) pool += 28;
    } else if (currentMode === 'hex') {
        pool = 16;
    } else if (currentMode === 'uuid') {
        pool = 128;
    }

    const bits = Math.round(len * Math.log2(Math.max(2, pool)));
    const scoreElem = document.getElementById('entropyScore');
    const barElem = document.getElementById('entropyBar');

    const pct = Math.min(100, Math.round((bits / 128) * 100));
    barElem.style.width = `${pct}%`;

    if (bits < 64) {
        scoreElem.textContent = `${bits} bits &bull; <?= $isDe ? 'Schwach' : 'Moderate' ?>`;
        scoreElem.style.color = '#eab308';
        barElem.style.background = '#eab308';
    } else if (bits < 100) {
        scoreElem.textContent = `${bits} bits &bull; <?= $isDe ? 'Stark' : 'Strong' ?>`;
        scoreElem.style.color = '#16a34a';
        barElem.style.background = '#16a34a';
    } else {
        scoreElem.textContent = `${bits} bits &bull; <?= $isDe ? 'Sehr hoch (Militärstandard)' : 'High-Entropy (Sovereign)' ?>`;
        scoreElem.style.color = '#16a34a';
        barElem.style.background = '#16a34a';
    }
}

function copyTokenRow(btn, text) {
    navigator.clipboard.writeText(text).then(() => {
        btn.classList.add('copied');
        btn.querySelector('span').textContent = '<?= $isDe ? 'Kopiert!' : 'Copied!' ?>';
        setTimeout(() => {
            btn.classList.remove('copied');
            btn.querySelector('span').textContent = '<?= $isDe ? 'Kopieren' : 'Copy' ?>';
        }, 1500);
    });
}

function copyAllTokens() {
    const vals = Array.from(document.querySelectorAll('.secret-output-val')).map(el => el.textContent).join('\n');
    if (!vals) return;
    navigator.clipboard.writeText(vals).then(() => {
        const btn = document.getElementById('copyAllBtn');
        const lbl = document.getElementById('copyAllLabel');
        btn.classList.add('copied');
        lbl.textContent = '<?= $isDe ? 'Alle kopiert!' : 'All Copied!' ?>';
        setTimeout(() => {
            btn.classList.remove('copied');
            lbl.textContent = '<?= $isDe ? 'Alle kopieren' : 'Copy All' ?>';
        }, 1500);
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

// Initial generation
document.addEventListener('DOMContentLoaded', () => {
    generateTokens();
});
</script>
