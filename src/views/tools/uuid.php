<?php

declare(strict_types=1);

/**
 * One-Shot UUID View: /{lang}/tools/uuid
 * A single UUIDv4 that is replaced with a fresh one every time it is copied.
 * Path: /{lang}/tools/uuid
 *
 * @var string $lang
 */

$lang = $lang ?? current_lang();
$isDe = $lang === 'de';

/** Server-rendered starting value so the page works even without JavaScript. */
$initialUuid = (function (): string {
    $b = random_bytes(16);
    $b[6] = chr((ord($b[6]) & 0x0f) | 0x40);
    $b[8] = chr((ord($b[8]) & 0x3f) | 0x80);
    $hex = bin2hex($b);
    return sprintf('%s-%s-%s-%s-%s', substr($hex, 0, 8), substr($hex, 8, 4), substr($hex, 12, 4), substr($hex, 16, 4), substr($hex, 20));
})();

$title = ($isDe ? 'Einweg-UUID-Generator' : 'One-Shot UUID Generator') . ' — ternis.org';
$metaDescription = $isDe
    ? 'Eine einzige, kryptografisch zufällige UUIDv4 (Web Crypto API). Jede Kopie verbrennt sie und erzeugt sofort eine frische — 100% clientseitig, ohne Netzwerk.'
    : 'A single cryptographically random UUIDv4 (Web Crypto API). Every copy burns it and instantly replaces it with a fresh one — 100% client-side, zero network.';
?>

<style>
    .uuid-stage {
        max-width: 760px;
        margin: 0 auto;
        text-align: center;
        padding: 2.5rem 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1.1rem;
    }

    .uuid-status-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-family: var(--font-mono);
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--text-muted);
    }

    .uuid-live-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #16a34a;
        box-shadow: 0 0 6px rgba(22, 163, 74, 0.8);
    }

    .uuid-display {
        display: inline-block;
        width: 100%;
        border: 1px dashed var(--border-subtle);
        background: var(--bg-color);
        border-radius: 12px;
        padding: 1.1rem 1rem;
        font-family: var(--font-mono);
        font-size: clamp(1rem, 2.6vw, 1.45rem);
        font-weight: 600;
        letter-spacing: 0.01em;
        color: var(--primary);
        cursor: copy;
        overflow-wrap: break-word;
        transition: border-color 0.15s ease, transform 0.15s ease;
    }

    .uuid-display:hover { border-color: var(--primary); }

    .uuid-display.is-swapping { animation: uuid-swap 0.32s cubic-bezier(0.25, 0.9, 0.3, 1) both; }

    @keyframes uuid-swap {
        from { opacity: 0; transform: translateY(6px); filter: blur(3px); }
        to   { opacity: 1; transform: none; filter: none; }
    }

    .uuid-hint {
        margin: 0;
        font-size: 0.84375rem;
        color: var(--text-muted);
        line-height: 1.6;
        max-width: 480px;
    }

    .uuid-counter {
        font-family: var(--font-mono);
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    .uuid-msg {
        min-height: 1.2em;
        margin: 0;
        font-size: 0.8125rem;
        font-weight: 600;
        color: var(--text-muted);
    }

    .uuid-history { max-width: 760px; margin: 1.25rem auto 0; }

    .uuid-history-list { display: flex; flex-direction: column; gap: 0.5rem; }

    .uuid-history-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        padding: 0.55rem 0.75rem;
        background: var(--bg-color);
        border: 1px solid var(--border-subtle);
        border-radius: 9px;
        font-family: var(--font-mono);
        font-size: 0.78rem;
        color: var(--text-muted);
        overflow-wrap: anywhere;
    }

    .uuid-empty {
        margin: 0;
        font-size: 0.8125rem;
        color: var(--text-muted);
    }

    @media (prefers-reduced-motion: reduce) {
        .uuid-display.is-swapping { animation: none; }
    }
</style>

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
        <span style="color:var(--text-main);font-weight:600;"><?= $isDe ? 'Einweg-UUID' : 'One-Shot UUID' ?></span>
    </nav>

    <!-- Header -->
    <header class="tool-header">
        <div class="tool-badge-pill">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
            <span><?= $isDe ? 'Web Crypto API &bull; Einmal kopieren, einmal weg' : 'Web Crypto API &bull; Copy once, once gone' ?></span>
        </div>
        <h1 class="tool-title">
            <?= $isDe ? 'Einweg-UUID-Generator' : 'One-Shot UUID Generator' ?>
        </h1>
        <p class="tool-desc">
            <?= $isDe
                ? 'Genau eine UUIDv4 pro Seite. Sobald du sie kopierst, wird sie verbraucht und durch eine frische ersetzt — du kannst sie also nie zweimal versehentlich verwenden.'
                : 'Exactly one UUIDv4 per page. The moment you copy it, it is spent and swapped for a fresh one — so you can never accidentally reuse the same identifier twice.'
            ?>
        </p>
    </header>

    <!-- The one UUID -->
    <section class="tool-card uuid-stage" aria-label="<?= $isDe ? 'Die aktuelle UUID' : 'The current UUID' ?>">
        <span class="uuid-status-chip">
            <span class="uuid-live-dot" aria-hidden="true"></span>
            <span id="uuidState"><?= $isDe ? 'Frisch & unverbraucht' : 'Fresh & unspent' ?></span>
        </span>

        <button type="button" id="uuidValue" class="uuid-display" title="<?= $isDe ? 'Klicken zum Kopieren' : 'Click to copy' ?>" aria-live="polite"><?= e($initialUuid) ?></button>

        <p class="uuid-hint">
            <?= $isDe
                ? 'Kopieren mit einem Klick auf die UUID oder den Button. Beim erfolgreichen Kopieren wird sie sofort verbraucht und ersetzt.'
                : 'Click the UUID or the button to copy. On a successful copy it is spent and instantly replaced.'
            ?>
        </p>

        <div style="display:flex;gap:0.75rem;align-items:center;flex-wrap:wrap;justify-content:center;">
            <button type="button" class="tool-btn-primary" id="uuidCopyBtn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                <span><?= $isDe ? 'Kopieren & verbrennen' : 'Copy & burn' ?></span>
            </button>
            <span class="uuid-counter" id="uuidCounter" aria-label="<?= $isDe ? 'Kopien in dieser Sitzung' : 'Copies this session' ?>"></span>
        </div>

        <p class="uuid-msg" id="uuidMsg" role="status"></p>
    </section>

    <!-- Spent history -->
    <section class="tool-card uuid-history" aria-label="<?= $isDe ? 'Verbrauchte UUIDs' : 'Spent UUIDs' ?>">
        <div class="tool-card-header">
            <h2 class="tool-card-title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
                <span><?= $isDe ? 'Kürzlich verbraucht' : 'Recently spent' ?></span>
            </h2>
        </div>
        <div class="uuid-history-list" id="uuidHistory">
            <p class="uuid-empty"><?= $isDe ? 'Noch nichts verbraucht — die erste Kopie erscheint hier als Backup.' : 'Nothing spent yet — your first copied UUID shows up here as a backup.' ?></p>
        </div>
    </section>

    <!-- Zero-Knowledge Callout -->
    <div class="tool-card" style="max-width:760px;margin:1.25rem auto 0;background:rgba(22,163,74,0.03);border-color:rgba(22,163,74,0.2);">
        <div style="display:flex;align-items:flex-start;gap:0.75rem;">
            <div style="color:#16a34a;margin-top:0.15rem;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
            </div>
            <div>
                <h4 style="margin:0 0 0.25rem;font-size:0.9375rem;font-weight:700;color:var(--text-main);">
                    <?= $isDe ? 'CSPRNG-Entropie, ausschließlich lokal' : 'CSPRNG entropy, strictly local' ?>
                </h4>
                <p style="margin:0;font-size:0.8125rem;color:var(--text-muted);line-height:1.55;">
                    <?= $isDe
                        ? 'Jede UUID entsteht über crypto.randomUUID() bzw. die Web Crypto API (CSPRNG) deines Browsers. Es gibt keine Server-Speicherung, kein Logging und kein Netzwerk-Roundtrip.'
                        : 'Every UUID comes from crypto.randomUUID() backed by your browser’s CSPRNG (Web Crypto API). No server storage, no logging, no network round-trip — not even the first one.'
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    'use strict';

    const uuidEl = document.getElementById('uuidValue');
    const btn = document.getElementById('uuidCopyBtn');
    const btnLabel = btn.querySelector('span');
    const msgEl = document.getElementById('uuidMsg');
    const stateEl = document.getElementById('uuidState');
    const counterEl = document.getElementById('uuidCounter');
    const historyEl = document.getElementById('uuidHistory');

    const isDe = <?= $isDe ? 'true' : 'false' ?>;
    const labels = {
        fresh: isDe ? 'Frisch & unverbraucht' : 'Fresh & unspent',
        spent: isDe ? 'Verbraucht' : 'Spent',
        copied: isDe ? 'Kopiert!' : 'Copied!',
        copying: isDe ? 'Kopiert — ersetze …' : 'Copied — swapping …',
        failure: isDe ? 'Kopieren blockiert — UUID manuell markieren und kopieren.' : 'Copy blocked — select the UUID manually.',
        counter: isDe ? 'Kopien in dieser Sitzung: ' : 'Copies this session: ',
        backup: isDe ? 'Noch nichts verbraucht — die erste Kopie erscheint hier als Backup.' : 'Nothing spent yet — your first copied UUID shows up here as a backup.',
        copiedHistory: isDe ? 'Kopiert!' : 'Copied!'
    };

    let busy = false;
    let copies = 0;
    const history = [];

    function randomBytes(count) {
        if (window.crypto && typeof window.crypto.getRandomValues === 'function') {
            const arr = new Uint8Array(count);
            window.crypto.getRandomValues(arr);
            return arr;
        }
        throw new Error('CSPRNG unavailable');
    }

    function freshUuid() {
        if (window.crypto && typeof crypto.randomUUID === 'function') {
            return crypto.randomUUID();
        }
        const b = randomBytes(16);
        b[6] = (b[6] & 0x0f) | 0x40;
        b[8] = (b[8] & 0x3f) | 0x80;
        const h = Array.from(b).map(x => x.toString(16).padStart(2, '0')).join('');
        return h.slice(0, 8) + '-' + h.slice(8, 12) + '-' + h.slice(12, 16) + '-' + h.slice(16, 20) + '-' + h.slice(20);
    }

    function writeClipboard(text) {
        if (navigator.clipboard && navigator.clipboard.writeText) {
            return navigator.clipboard.writeText(text).then(() => true, () => fallbackCopy(text));
        }
        return Promise.resolve(fallbackCopy(text));
    }

    function fallbackCopy(text) {
        try {
            const ta = document.createElement('textarea');
            ta.value = text;
            ta.setAttribute('readonly', '');
            ta.style.position = 'fixed';
            ta.style.opacity = '0';
            document.body.appendChild(ta);
            ta.select();
            const ok = document.execCommand('copy');
            ta.remove();
            return ok;
        } catch (err) {
            return false;
        }
    }

    function swapTo(value) {
        uuidEl.classList.remove('is-swapping');
        // Force a reflow so the re-added animation class replays reliably.
        void uuidEl.offsetWidth;
        uuidEl.textContent = value;
        uuidEl.classList.add('is-swapping');
    }

    function burnAfterCopy(uuid) {
        copies++;
        counterEl.textContent = labels.counter + copies;
        stateEl.textContent = labels.spent;
        history.unshift(uuid);
        if (history.length > 5) history.length = 5;
        renderHistory();
    }

    function copyCurrent() {
        if (busy) return;
        const uuid = uuidEl.textContent.trim();
        if (!uuid) return;
        busy = true;

        writeClipboard(uuid).then(ok => {
            if (!ok) {
                msgEl.textContent = labels.failure;
                busy = false;
                return;
            }
            const original = btnLabel.textContent;
            btnLabel.textContent = labels.copying;
            btn.setAttribute('disabled', '');
            burnAfterCopy(uuid);

            setTimeout(() => {
                swapTo(freshUuid());
                stateEl.textContent = labels.fresh;
                msgEl.textContent = labels.copied;
                btnLabel.textContent = original;
                btn.removeAttribute('disabled');
                busy = false;
                setTimeout(() => { if (msgEl.textContent === labels.copied) msgEl.textContent = ''; }, 2200);
            }, 550);
        });
    }

    function renderHistory() {
        if (!history.length) {
            historyEl.innerHTML = '<p class="uuid-empty">' + labels.backup + '</p>';
            return;
        }
        historyEl.innerHTML = '';
        history.forEach(item => {
            const row = document.createElement('div');
            row.className = 'uuid-history-row';
            const span = document.createElement('span');
            span.textContent = item;
            const reCopy = document.createElement('button');
            reCopy.type = 'button';
            reCopy.className = 'tool-copy-btn';
            reCopy.textContent = isDe ? 'Nochmal kopieren' : 'Copy again';
            reCopy.setAttribute('aria-label', (isDe ? 'UUID erneut kopieren: ' : 'Copy UUID again: ') + item);
            reCopy.addEventListener('click', () => {
                writeClipboard(item).then(ok => {
                    if (!ok) return;
                    reCopy.textContent = labels.copiedHistory;
                    setTimeout(() => { reCopy.textContent = isDe ? 'Nochmal kopieren' : 'Copy again'; }, 1400);
                });
            });
            row.appendChild(span);
            row.appendChild(reCopy);
            historyEl.appendChild(row);
        });
    }

    btn.addEventListener('click', copyCurrent);
    uuidEl.addEventListener('click', copyCurrent);

    // Bonus: if the user selects the live UUID and copies it manually (Ctrl+C),
    // that also counts as spending it.
    document.addEventListener('copy', () => {
        if (busy) return;
        const selection = (window.getSelection ? String(window.getSelection()) : '').trim();
        if (selection && selection === uuidEl.textContent.trim()) {
            setTimeout(copyCurrent, 700);
        }
    });
})();
</script>
