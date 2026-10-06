<?php

declare(strict_types=1);

/**
 * Shortlink & QR Code Studio View
 * Path: /{lang}/tools/shortlink
 *
 * @var string $lang
 */

$lang = $lang ?? current_lang();
$isDe = $lang === 'de';

$title = $isDe ? 'Shortlink & QR Code Studio — ternis.org' : 'Shortlink & QR Code Studio — ternis.org';
$metaDescription = $isDe
    ? 'Erstelle kostenlose Kurzlinks über t-api.de und generiere hochauflösende SVG/PNG-QR-Codes für URLs, WLAN-Netzwerke und Visitenkarten.'
    : 'Create fast shortlinks powered by links.t-api.de and craft high-res SVG & PNG QR codes for URLs, Wi-Fi networks, and contacts.';
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
        <span style="color:var(--text-main);font-weight:600;"><?= $isDe ? 'Shortlink & QR Studio' : 'Shortlink & QR Studio' ?></span>
    </nav>

    <!-- Header -->
    <header class="tool-header">
        <div class="tool-badge-pill">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
            <span>links.t-api.de/v1 &bull; href.nz</span>
        </div>
        <h1 class="tool-title">
            <?= $isDe ? 'Shortlink & QR Code Studio' : 'Shortlink & QR Code Studio' ?>
        </h1>
        <p class="tool-desc">
            <?= $isDe
                ? 'Erstelle blitzschnelle Kurzlinks auf Basis unserer t-api.de REST-Infrastruktur oder gestalte anpassbare Vektor-QR-Codes (SVG/PNG) für Webseiten, WLAN-Zugangsdaten und vCards.'
                : 'Instantly shorten links backed by our high-performance t-api.de REST API, or generate production-ready vector QR codes (SVG & PNG) for web pages, Wi-Fi credentials, and vCards.'
            ?>
        </p>
    </header>

    <!-- Studio Mode Tabs -->
    <div class="tools-tabs" role="tablist">
        <button type="button" class="tools-tab-btn active" id="tabBtnShortlink" role="tab" aria-selected="true" aria-controls="panelShortlink" onclick="switchStudioTab('shortlink')">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
            <span><?= $isDe ? '1. Kurzlink erstellen' : '1. Create Shortlink' ?></span>
        </button>
        <button type="button" class="tools-tab-btn" id="tabBtnQr" role="tab" aria-selected="false" aria-controls="panelQr" onclick="switchStudioTab('qr')">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            <span><?= $isDe ? '2. QR Code Studio' : '2. QR Code Studio' ?></span>
        </button>
        <a href="/<?= e($lang) ?>/tools/shortlink/api" class="tools-tab-btn" style="margin-left:auto;text-decoration:none;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
            <span><?= $isDe ? 'API-Leitfaden öffnen &rarr;' : 'Developer API Guide &rarr;' ?></span>
        </a>
    </div>

    <!-- PANEL 1: SHORTLINK CREATOR -->
    <div id="panelShortlink" role="tabpanel" aria-labelledby="tabBtnShortlink">
        <div class="tool-grid">
            <!-- Left: Input Form -->
            <div class="tool-card">
                <div class="tool-card-header">
                    <h2 class="tool-card-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                        <span><?= $isDe ? 'Ziel-Adresse eingeben' : 'Enter Destination URL' ?></span>
                    </h2>
                    <span style="font-size:0.75rem;font-family:var(--font-mono);color:var(--text-muted);">
                        POST /v1/links/public
                    </span>
                </div>

                <form id="shortlinkForm" onsubmit="handleShortlinkSubmit(event)">
                    <div class="tool-form-group">
                        <label class="tool-label" for="destUrlInput">
                            <?= $isDe ? 'Ziel-URL' : 'Destination URL' ?>
                        </label>
                        <input type="url" id="destUrlInput" class="tool-input mono" placeholder="https://example.com/very-long-landing-page..." required>
                        <div class="tool-input-hint">
                            <?= $isDe
                                ? 'Öffentliche Links leiten über href.nz weiter. Keine Registrierung erforderlich.'
                                : 'Public guest links route via href.nz. No registration or API key required.'
                            ?>
                        </div>
                    </div>

                    <!-- Quick Demo Presets -->
                    <div class="tool-form-group">
                        <label class="tool-label" style="font-size:0.75rem;color:var(--text-muted);">
                            <?= $isDe ? 'Schnellauswahl testen:' : 'Test with quick preset:' ?>
                        </label>
                        <div class="pills-group">
                            <button type="button" class="pill-choice" onclick="setDestUrl('https://ternis.org')">ternis.org</button>
                            <button type="button" class="pill-choice" onclick="setDestUrl('https://github.com/ternis-org')">github.com/ternis-org</button>
                            <button type="button" class="pill-choice" onclick="setDestUrl('https://ternisdomains.de')">ternisdomains.de</button>
                        </div>
                    </div>

                    <div style="margin-top:1.5rem;display:flex;gap:0.75rem;align-items:center;">
                        <button type="submit" id="submitShortlinkBtn" class="tool-btn-primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                            <span><?= $isDe ? 'Kurzlink generieren' : 'Generate Shortlink' ?></span>
                        </button>
                        <span id="shortlinkSpinner" style="display:none;color:var(--primary);font-size:0.875rem;font-family:var(--font-mono);">
                            <?= $isDe ? 'Wird erstellt...' : 'Creating...' ?>
                        </span>
                    </div>

                    <div id="shortlinkError" style="display:none;margin-top:1rem;padding:0.75rem 1rem;border-radius:8px;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#dc2626;font-size:0.875rem;"></div>
                </form>

                <!-- Result Box -->
                <div id="shortlinkResult" style="display:none;" class="tool-result-box">
                    <div class="tool-result-header">
                        <span style="font-weight:600;color:var(--text-main);"><?= $isDe ? 'Generierter Kurzlink' : 'Shortlink Created' ?></span>
                        <span id="shortlinkCreatedTime" style="font-size:0.75rem;"></span>
                    </div>

                    <div style="display:flex;align-items:center;justify-content:space-between;gap:0.75rem;background:var(--surface);padding:0.85rem 1rem;border-radius:8px;border:1px solid var(--border-subtle);margin-bottom:1rem;">
                        <a id="shortlinkHref" href="#" target="_blank" rel="noopener noreferrer" style="font-family:var(--font-mono);font-size:1.0625rem;font-weight:700;color:var(--primary);text-decoration:none;word-break:break-all;"></a>
                        <div style="display:flex;gap:0.4rem;flex-shrink:0;">
                            <button type="button" class="tool-copy-btn" id="copyShortlinkBtn" onclick="copyShortlinkToClipboard()">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                <span><?= $isDe ? 'Kopieren' : 'Copy' ?></span>
                            </button>
                        </div>
                    </div>

                    <div style="display:flex;gap:0.5rem;flex-wrap:wrap;">
                        <button type="button" class="tool-btn-secondary" style="padding:0.5rem 0.85rem;font-size:0.8125rem;" onclick="sendToQrStudio()">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                            <span><?= $isDe ? 'QR-Code anpassen &rarr;' : 'Customize in QR Studio &rarr;' ?></span>
                        </button>
                        <a id="openLinkBtn" href="#" target="_blank" rel="noopener noreferrer" class="tool-btn-secondary" style="padding:0.5rem 0.85rem;font-size:0.8125rem;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                            <span><?= $isDe ? 'Im Browser öffnen' : 'Open Link' ?></span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right: Feature Overview & API Hint -->
            <div style="display:flex;flex-direction:column;gap:1.5rem;">
                <div class="tool-card">
                    <h3 style="font-size:1.0625rem;font-weight:700;margin:0 0 1rem;display:flex;align-items:center;gap:0.5rem;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                        <span><?= $isDe ? 'Über die links.t-api.de Plattform' : 'About links.t-api.de Engine' ?></span>
                    </h3>
                    <ul style="margin:0;padding-left:1.25rem;font-size:0.875rem;color:var(--text-muted);line-height:1.7;">
                        <li><strong><?= $isDe ? 'Sub-Millisekunden-Redirects:' : 'Sub-millisecond redirects:' ?></strong> <?= $isDe ? 'Hochoptimierte Edge-Routing-Architektur auf href.nz.' : 'Edge-routed on high-performance Anycast hosts.' ?></li>
                        <li><strong><?= $isDe ? 'Datenschutzkonform:' : 'Privacy compliant:' ?></strong> <?= $isDe ? 'DNT- und Global Privacy Control (GPC) Unterstützung ohne Drittanbieter-Tracker.' : 'Honors DNT & GPC headers; zero invasive third-party ad pixels.' ?></li>
                        <li><strong><?= $isDe ? 'Eigene Domains & Slugs:' : 'Custom domains & slugs:' ?></strong> <?= $isDe ? 'Mit API-Key (tl_...) können eigene Domains, Wunsch-Slugs und Bio Pages verwaltet werden.' : 'Pass a tl_... key to configure custom domains, vanity slugs, and bio pages.' ?></li>
                    </ul>
                    <div style="margin-top:1.25rem;padding-top:1rem;border-top:1px solid var(--border-subtle);">
                        <a href="/<?= e($lang) ?>/tools/shortlink/api" style="font-size:0.8125rem;font-weight:600;color:var(--primary);text-decoration:none;display:inline-flex;align-items:center;gap:0.35rem;">
                            <span><?= $isDe ? 'Vollständige API-Referenz lesen' : 'Explore full API reference' ?></span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>

                <div class="tool-card" style="background:rgba(234,88,12,0.03);border-color:rgba(234,88,12,0.2);">
                    <h3 style="font-size:0.9375rem;font-weight:700;margin:0 0 0.5rem;color:var(--primary);">
                        <?= $isDe ? 'cURL Schnelleinstieg' : 'Quick cURL Example' ?>
                    </h3>
                    <pre class="tool-terminal" style="font-size:0.8125rem;padding:0.85rem;margin:0;">curl -X POST https://links.t-api.de/v1/links/public \
  -H "Content-Type: application/json" \
  -d '{"destination_url":"https://example.com"}'</pre>
                </div>
            </div>
        </div>
    </div>

    <!-- PANEL 2: QR CODE STUDIO -->
    <div id="panelQr" role="tabpanel" aria-labelledby="tabBtnQr" style="display:none;">
        <div class="tool-grid">
            <!-- Left: QR Settings Form -->
            <div class="tool-card">
                <div class="tool-card-header">
                    <h2 class="tool-card-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        <span><?= $isDe ? 'QR-Code Konfiguration' : 'QR Code Generator' ?></span>
                    </h2>
                    <span style="font-size:0.75rem;font-family:var(--font-mono);color:var(--text-muted);">
                        links.t-api.de/v1/qr
                    </span>
                </div>

                <!-- Payload Mode -->
                <div class="tool-form-group">
                    <label class="tool-label"><?= $isDe ? 'Inhaltstyp' : 'Payload Type' ?></label>
                    <div class="pills-group" id="qrPayloadTypeGroup">
                        <button type="button" class="pill-choice active" onclick="setQrType('url')">URL</button>
                        <button type="button" class="pill-choice" onclick="setQrType('text')">Text</button>
                        <button type="button" class="pill-choice" onclick="setQrType('wifi')">Wi-Fi</button>
                        <button type="button" class="pill-choice" onclick="setQrType('vcard')">vCard Contact</button>
                    </div>
                </div>

                <!-- Mode URL -->
                <div id="qrFieldUrl" class="tool-form-group">
                    <label class="tool-label" for="qrInputUrl"><?= $isDe ? 'Ziel-Webadresse (URL)' : 'Web URL' ?></label>
                    <input type="text" id="qrInputUrl" class="tool-input mono" value="https://ternis.org" oninput="updateQrPreview()">
                </div>

                <!-- Mode Text -->
                <div id="qrFieldText" class="tool-form-group" style="display:none;">
                    <label class="tool-label" for="qrInputText"><?= $isDe ? 'Freitext' : 'Plain Text' ?></label>
                    <textarea id="qrInputText" class="tool-textarea" rows="3" placeholder="Hello World" oninput="updateQrPreview()"></textarea>
                </div>

                <!-- Mode Wi-Fi -->
                <div id="qrFieldWifi" style="display:none;">
                    <div class="tool-form-group">
                        <label class="tool-label" for="qrWifiSsid"><?= $isDe ? 'WLAN Netzwerkname (SSID)' : 'Network SSID' ?></label>
                        <input type="text" id="qrWifiSsid" class="tool-input" placeholder="HomeNetwork" oninput="updateQrPreview()">
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                        <div class="tool-form-group">
                            <label class="tool-label" for="qrWifiPass"><?= $isDe ? 'Passwort' : 'Password' ?></label>
                            <input type="text" id="qrWifiPass" class="tool-input mono" placeholder="SecretKey" oninput="updateQrPreview()">
                        </div>
                        <div class="tool-form-group">
                            <label class="tool-label" for="qrWifiEnc"><?= $isDe ? 'Verschlüsselung' : 'Encryption' ?></label>
                            <select id="qrWifiEnc" class="tool-select" onchange="updateQrPreview()">
                                <option value="WPA">WPA / WPA2 / WPA3</option>
                                <option value="WEP">WEP</option>
                                <option value="nopass">None (Open)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Mode vCard -->
                <div id="qrFieldVcard" style="display:none;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                        <div class="tool-form-group">
                            <label class="tool-label" for="qrVcardFn"><?= $isDe ? 'Vorname' : 'First Name' ?></label>
                            <input type="text" id="qrVcardFn" class="tool-input" placeholder="Jane" oninput="updateQrPreview()">
                        </div>
                        <div class="tool-form-group">
                            <label class="tool-label" for="qrVcardLn"><?= $isDe ? 'Nachname' : 'Last Name' ?></label>
                            <input type="text" id="qrVcardLn" class="tool-input" placeholder="Doe" oninput="updateQrPreview()">
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                        <div class="tool-form-group">
                            <label class="tool-label" for="qrVcardPhone"><?= $isDe ? 'Telefon' : 'Phone' ?></label>
                            <input type="tel" id="qrVcardPhone" class="tool-input mono" placeholder="+49 170 1234567" oninput="updateQrPreview()">
                        </div>
                        <div class="tool-form-group">
                            <label class="tool-label" for="qrVcardEmail"><?= $isDe ? 'E-Mail' : 'Email' ?></label>
                            <input type="email" id="qrVcardEmail" class="tool-input" placeholder="jane@example.com" oninput="updateQrPreview()">
                        </div>
                    </div>
                </div>

                <!-- Custom Styling Options -->
                <div style="margin-top:1.5rem;padding-top:1.5rem;border-top:1px solid var(--border-subtle);">
                    <h3 style="font-size:0.9375rem;font-weight:700;margin:0 0 1rem;color:var(--text-main);">
                        <?= $isDe ? 'Format & Darstellung' : 'Format & Styling Options' ?>
                    </h3>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                        <div class="tool-form-group">
                            <label class="tool-label" for="qrFormatSelect"><?= $isDe ? 'Ausgabeformat' : 'Output Format' ?></label>
                            <select id="qrFormatSelect" class="tool-select" onchange="updateQrPreview()">
                                <option value="svg">SVG (Vector - Crisp print)</option>
                                <option value="png">PNG (Raster image)</option>
                            </select>
                        </div>
                        <div class="tool-form-group">
                            <label class="tool-label" for="qrEccSelect"><?= $isDe ? 'Fehlerkorrektur (ECC)' : 'Error Correction' ?></label>
                            <select id="qrEccSelect" class="tool-select" onchange="updateQrPreview()">
                                <option value="M" selected>M — Medium (~15%)</option>
                                <option value="L">L — Low (~7%)</option>
                                <option value="Q">Q — Quartile (~25%)</option>
                                <option value="H">H — High (~30%)</option>
                            </select>
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                        <div class="tool-form-group">
                            <label class="tool-label" for="qrColorPicker"><?= $isDe ? 'Vordergrundfarbe' : 'Foreground Color' ?></label>
                            <div style="display:flex;align-items:center;gap:0.5rem;">
                                <input type="color" id="qrColorPicker" value="#000000" style="width:40px;height:38px;padding:2px;border-radius:6px;border:1px solid var(--border-subtle);background:var(--bg-color);cursor:pointer;" onchange="syncColorInput('picker')">
                                <input type="text" id="qrColorText" class="tool-input mono" value="#000000" maxlength="7" style="flex:1;" oninput="syncColorInput('text')">
                            </div>
                        </div>
                        <div class="tool-form-group">
                            <label class="tool-label" for="qrBgColorPicker"><?= $isDe ? 'Hintergrundfarbe' : 'Background Color' ?></label>
                            <div style="display:flex;align-items:center;gap:0.5rem;">
                                <input type="color" id="qrBgColorPicker" value="#ffffff" style="width:40px;height:38px;padding:2px;border-radius:6px;border:1px solid var(--border-subtle);background:var(--bg-color);cursor:pointer;" onchange="syncBgColorInput('picker')">
                                <input type="text" id="qrBgColorText" class="tool-input mono" value="#ffffff" maxlength="7" style="flex:1;" oninput="syncBgColorInput('text')">
                            </div>
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                        <div class="tool-form-group">
                            <label class="tool-label" for="qrSizeInput"><?= $isDe ? 'Bildgröße (px)' : 'Size (px)' ?>: <span id="qrSizeVal" style="font-family:var(--font-mono);color:var(--primary);">320</span></label>
                            <input type="range" id="qrSizeInput" min="150" max="800" step="10" value="320" style="width:100%;" oninput="document.getElementById('qrSizeVal').textContent = this.value; updateQrPreview()">
                        </div>
                        <div class="tool-form-group">
                            <label class="tool-label" for="qrMarginInput"><?= $isDe ? 'Rand / Quiet Zone' : 'Quiet Zone (Margin)' ?>: <span id="qrMarginVal" style="font-family:var(--font-mono);color:var(--primary);">2</span></label>
                            <input type="range" id="qrMarginInput" min="0" max="8" step="1" value="2" style="width:100%;" oninput="document.getElementById('qrMarginVal').textContent = this.value; updateQrPreview()">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Live QR Preview & Export -->
            <div style="display:flex;flex-direction:column;gap:1.5rem;">
                <div class="tool-card">
                    <div class="tool-card-header">
                        <h2 class="tool-card-title">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8"></polygon></svg>
                            <span><?= $isDe ? 'Live-Vorschau' : 'Live Vector Preview' ?></span>
                        </h2>
                        <span id="qrFormatBadge" style="font-size:0.75rem;font-family:var(--font-mono);padding:0.2rem 0.5rem;border-radius:4px;background:rgba(234,88,12,0.1);color:var(--primary);">SVG</span>
                    </div>

                    <div class="qr-preview-card">
                        <img id="qrPreviewImg" src="" alt="QR Code Preview" class="qr-preview-img" style="max-height:280px;object-fit:contain;">
                        <div id="qrLoadingText" style="margin-top:0.75rem;font-size:0.8125rem;color:var(--text-muted);font-family:var(--font-mono);">
                            <?= $isDe ? 'Wird gerendert...' : 'Rendering...' ?>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div style="margin-top:1.5rem;display:flex;gap:0.75rem;flex-wrap:wrap;">
                        <a id="qrDownloadBtn" href="#" download="qr-code.svg" class="tool-btn-primary" style="flex:1;">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span id="qrDownloadLabel"><?= $isDe ? 'Herunterladen (SVG)' : 'Download (SVG)' ?></span>
                        </a>
                        <button type="button" class="tool-btn-secondary" onclick="copyQrEndpointUrl()">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                            <span id="copyQrBtnLabel"><?= $isDe ? 'URL kopieren' : 'Copy Endpoint' ?></span>
                        </button>
                    </div>

                    <!-- Direct integration code -->
                    <div style="margin-top:1.5rem;">
                        <label class="tool-label" style="font-size:0.75rem;color:var(--text-muted);"><?= $isDe ? 'Direkter API-Aufruf (cURL):' : 'Direct API Endpoint Call:' ?></label>
                        <pre class="tool-terminal" id="qrCurlSnippet" style="font-size:0.75rem;padding:0.75rem;margin:0;word-break:break-all;"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
/**
 * Tab Switching
 */
function switchStudioTab(tab) {
    const isShortlink = tab === 'shortlink';
    document.getElementById('tabBtnShortlink').classList.toggle('active', isShortlink);
    document.getElementById('tabBtnQr').classList.toggle('active', !isShortlink);
    document.getElementById('panelShortlink').style.display = isShortlink ? 'block' : 'none';
    document.getElementById('panelQr').style.display = !isShortlink ? 'block' : 'none';

    if (!isShortlink) {
        updateQrPreview();
    }
}

/**
 * Shortlink handling
 */
let currentShortUrl = '';

function setDestUrl(url) {
    document.getElementById('destUrlInput').value = url;
}

async function handleShortlinkSubmit(e) {
    e.preventDefault();
    const input = document.getElementById('destUrlInput');
    const submitBtn = document.getElementById('submitShortlinkBtn');
    const spinner = document.getElementById('shortlinkSpinner');
    const errBox = document.getElementById('shortlinkError');
    const resultBox = document.getElementById('shortlinkResult');

    errBox.style.display = 'none';
    resultBox.style.display = 'none';

    let targetUrl = input.value.trim();
    if (!targetUrl.match(/^https?:\/\//i)) {
        targetUrl = 'https://' + targetUrl;
        input.value = targetUrl;
    }

    submitBtn.disabled = true;
    spinner.style.display = 'inline-block';

    try {
        const res = await fetch('/api/tools/shortlink', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ destination_url: targetUrl })
        });

        const data = await res.json();
        if (!res.ok || !data.short_url) {
            throw new Error(data.message || (data.errors ? JSON.stringify(data.errors) : '<?= $isDe ? 'Fehler beim Erstellen des Links' : 'Failed to create shortlink' ?>'));
        }

        currentShortUrl = data.short_url;
        document.getElementById('shortlinkHref').textContent = data.short_url;
        document.getElementById('shortlinkHref').href = data.short_url;
        document.getElementById('openLinkBtn').href = data.short_url;
        document.getElementById('shortlinkCreatedTime').textContent = new Date().toLocaleTimeString();

        resultBox.style.display = 'block';
    } catch (err) {
        errBox.textContent = err.message;
        errBox.style.display = 'block';
    } finally {
        submitBtn.disabled = false;
        spinner.style.display = 'none';
    }
}

function copyShortlinkToClipboard() {
    if (!currentShortUrl) return;
    navigator.clipboard.writeText(currentShortUrl).then(() => {
        const btn = document.getElementById('copyShortlinkBtn');
        btn.classList.add('copied');
        btn.querySelector('span').textContent = '<?= $isDe ? 'Kopiert!' : 'Copied!' ?>';
        setTimeout(() => {
            btn.classList.remove('copied');
            btn.querySelector('span').textContent = '<?= $isDe ? 'Kopieren' : 'Copy' ?>';
        }, 2000);
    });
}

function sendToQrStudio() {
    if (!currentShortUrl) return;
    setQrType('url');
    document.getElementById('qrInputUrl').value = currentShortUrl;
    switchStudioTab('qr');
}

/**
 * QR Studio Logic
 */
let currentQrType = 'url';
let qrDebounceTimer = null;

function setQrType(type) {
    currentQrType = type;
    const btns = document.querySelectorAll('#qrPayloadTypeGroup .pill-choice');
    btns.forEach(b => b.classList.toggle('active', b.textContent.toLowerCase().includes(type)));

    document.getElementById('qrFieldUrl').style.display = type === 'url' ? 'block' : 'none';
    document.getElementById('qrFieldText').style.display = type === 'text' ? 'block' : 'none';
    document.getElementById('qrFieldWifi').style.display = type === 'wifi' ? 'block' : 'none';
    document.getElementById('qrFieldVcard').style.display = type === 'vcard' ? 'block' : 'none';

    updateQrPreview();
}

function syncColorInput(source) {
    if (source === 'picker') {
        document.getElementById('qrColorText').value = document.getElementById('qrColorPicker').value;
    } else {
        const val = document.getElementById('qrColorText').value;
        if (/^#[0-9A-Fa-f]{6}$/.test(val)) {
            document.getElementById('qrColorPicker').value = val;
        }
    }
    updateQrPreview();
}

function syncBgColorInput(source) {
    if (source === 'picker') {
        document.getElementById('qrBgColorText').value = document.getElementById('qrBgColorPicker').value;
    } else {
        const val = document.getElementById('qrBgColorText').value;
        if (/^#[0-9A-Fa-f]{6}$/.test(val)) {
            document.getElementById('qrBgColorPicker').value = val;
        }
    }
    updateQrPreview();
}

function buildQrPayload() {
    if (currentQrType === 'url') {
        return document.getElementById('qrInputUrl').value.trim() || 'https://ternis.org';
    }
    if (currentQrType === 'text') {
        return document.getElementById('qrInputText').value.trim() || 'ternis.org';
    }
    if (currentQrType === 'wifi') {
        const ssid = document.getElementById('qrWifiSsid').value.trim() || 'Network';
        const pass = document.getElementById('qrWifiPass').value.trim();
        const enc = document.getElementById('qrWifiEnc').value;
        return `WIFI:T:${enc};S:${ssid};P:${pass};;`;
    }
    if (currentQrType === 'vcard') {
        const fn = document.getElementById('qrVcardFn').value.trim() || 'Jane';
        const ln = document.getElementById('qrVcardLn').value.trim() || 'Doe';
        const phone = document.getElementById('qrVcardPhone').value.trim();
        const email = document.getElementById('qrVcardEmail').value.trim();
        return `BEGIN:VCARD\nVERSION:3.0\nN:${ln};${fn}\nFN:${fn} ${ln}\nTEL:${phone}\nEMAIL:${email}\nEND:VCARD`;
    }
    return 'https://ternis.org';
}

function updateQrPreview() {
    clearTimeout(qrDebounceTimer);
    qrDebounceTimer = setTimeout(() => {
        const payload = buildQrPayload();
        const format = document.getElementById('qrFormatSelect').value;
        const ecc = document.getElementById('qrEccSelect').value;
        const color = document.getElementById('qrColorPicker').value.replace('#', '');
        const bgColor = document.getElementById('qrBgColorPicker').value.replace('#', '');
        const size = document.getElementById('qrSizeInput').value;
        const margin = document.getElementById('qrMarginInput').value;

        // Build URL directly on links.t-api.de/v1/qr
        const params = new URLSearchParams({
            url: payload,
            format: format,
            ecc: ecc,
            color: color,
            bgcolor: bgColor,
            size: size,
            margin: margin
        });

        const fullUrl = 'https://links.t-api.de/v1/qr?' + params.toString();

        const img = document.getElementById('qrPreviewImg');
        const loading = document.getElementById('qrLoadingText');
        const badge = document.getElementById('qrFormatBadge');
        const downloadBtn = document.getElementById('qrDownloadBtn');
        const downloadLabel = document.getElementById('qrDownloadLabel');

        badge.textContent = format.toUpperCase();
        loading.style.display = 'block';

        img.onload = () => {
            loading.style.display = 'none';
        };
        img.onerror = () => {
            loading.textContent = '<?= $isDe ? 'Vorschau wird geladen...' : 'Loading preview...' ?>';
        };
        img.src = fullUrl;

        downloadBtn.href = fullUrl;
        downloadBtn.download = `ternis-qr-${Date.now()}.${format}`;
        downloadLabel.textContent = `<?= $isDe ? 'Herunterladen' : 'Download' ?> (${format.toUpperCase()})`;

        // Update cURL snippet
        document.getElementById('qrCurlSnippet').textContent = `curl "${fullUrl}" -o qr.${format}`;
    }, 150);
}

function copyQrEndpointUrl() {
    const img = document.getElementById('qrPreviewImg');
    if (!img.src) return;
    navigator.clipboard.writeText(img.src).then(() => {
        const label = document.getElementById('copyQrBtnLabel');
        label.textContent = '<?= $isDe ? 'Kopiert!' : 'Copied!' ?>';
        setTimeout(() => {
            label.textContent = '<?= $isDe ? 'URL kopieren' : 'Copy Endpoint' ?>';
        }, 2000);
    });
}

// Initial preview render
document.addEventListener('DOMContentLoaded', () => {
    updateQrPreview();
});
</script>
