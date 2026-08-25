<?php

declare(strict_types=1);

/**
 * Legal document view template (Imprint, Privacy, License)
 * @var string $lang
 * @var string $slug
 * @var array $doc
 */

$lang = current_lang();
$canonicalUrl = 'https://ternis.org/' . $lang . '/legal/' . $slug;
$altLang = $lang === 'en' ? 'de' : 'en';
$altUrl = 'https://ternis.org/' . $altLang . '/legal/' . $slug;
$versionShort = app_version_hash(true);
$title = ($doc['title'] ?? 'Legal Notice') . ' — ternis.org';
?>
<!DOCTYPE html>
<html lang="<?= e($lang) ?>" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title) ?></title>
    <meta name="robots" content="noindex, follow">
    <link rel="canonical" href="<?= e($canonicalUrl) ?>">
    <link rel="alternate" hreflang="<?= e($altLang) ?>" href="<?= e($altUrl) ?>">

    <!-- Theme Color & PWA -->
    <meta name="theme-color" content="#4a5d23">
    <link rel="icon" href="/favicon.ico" sizes="any">

    <!-- Fonts & Stylesheet -->
    <link rel="stylesheet" href="<?= e(asset_url('/assets/css/app.css')) ?>">
</head>
<body>

    <!-- Organic Blobs -->
    <div class="blob blob-1" aria-hidden="true"></div>
    <div class="blob blob-2" aria-hidden="true"></div>

    <!-- Floating Pill Navigation -->
    <div class="nav-container-fixed">
        <nav class="floating-nav">
            <a href="/<?= e($lang) ?>" class="logo">
                <span>ternis.org</span>
            </a>

            <div class="nav-links">
                <a href="/<?= e($lang) ?>#projects"><?= e(t('nav.projects')) ?></a>
                <a href="https://getmy.name" target="_blank" rel="noopener noreferrer">getmy.name</a>
                <a href="https://getmy.name/api-docs" target="_blank" rel="noopener noreferrer">API Docs</a>
                <a href="https://mtex.dev" target="_blank" rel="noopener noreferrer">MTEX.dev</a>
                <a href="https://dnbx.de" target="_blank" rel="noopener noreferrer">dnbx.de</a>
                <a href="/<?= e($lang) ?>#connect"><?= e(t('nav.ecosystem')) ?></a>
            </div>

            <div class="nav-actions">
                <!-- Language Switcher -->
                <div class="lang-switcher">
                    <a href="/en/legal/<?= e($slug) ?>" class="lang-btn <?= $lang === 'en' ? 'active' : '' ?>">EN</a>
                    <a href="/de/legal/<?= e($slug) ?>" class="lang-btn <?= $lang === 'de' ? 'active' : '' ?>">DE</a>
                </div>

                <!-- Theme Toggle -->
                <button type="button" class="btn-icon btn-theme-toggle" aria-label="Toggle theme">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </button>

                <a href="https://github.com/ternis-org" target="_blank" rel="noopener noreferrer" class="btn-icon" aria-label="GitHub Organization">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"></path>
                    </svg>
                </a>
            </div>
        </nav>
    </div>

    <main class="legal-section">
        <div class="container" style="max-width:880px;">
            <!-- Breadcrumbs -->
            <div style="margin-bottom:2rem;display:flex;align-items:center;gap:0.5rem;font-size:0.9rem;color:var(--secondary);">
                <a href="/<?= e($lang) ?>">&larr; <?= e(t('error.back_home')) ?></a>
                <span>/</span>
                <span><?= e(t('nav.legal')) ?></span>
                <span>/</span>
                <span style="color:var(--primary);font-weight:600;"><?= e($doc['title'] ?? '') ?></span>
            </div>

            <!-- Legal Nav Tabs -->
            <div style="display:flex;gap:0.75rem;margin-bottom:2.5rem;flex-wrap:wrap;">
                <a href="/<?= e($lang) ?>/legal/imprint" class="btn <?= $slug === 'imprint' ? '' : 'btn-secondary' ?> btn-sm">
                    <?= e(t('nav.imprint')) ?>
                </a>
                <a href="/<?= e($lang) ?>/legal/privacy" class="btn <?= $slug === 'privacy' ? '' : 'btn-secondary' ?> btn-sm">
                    <?= e(t('nav.privacy')) ?>
                </a>
                <a href="/<?= e($lang) ?>/legal/license" class="btn <?= $slug === 'license' ? '' : 'btn-secondary' ?> btn-sm">
                    <?= e(t('nav.license')) ?>
                </a>
            </div>

            <div class="legal-card">
                <div class="legal-header" style="margin-bottom:2.5rem;">
                    <h1 style="font-size:2.5rem;font-weight:600;color:var(--primary);line-height:1.15;margin-bottom:0.75rem;">
                        <?= e($doc['title'] ?? '') ?>
                    </h1>
                    <?php if (!empty($doc['subtitle'])): ?>
                        <p style="color:var(--secondary);font-size:1.15rem;"><?= e($doc['subtitle']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="legal-content">
                    <?php if ($slug === 'imprint'): ?>
                        <h3><?= e($doc['operator_heading'] ?? 'Provider') ?></h3>
                        <p>
                            <strong><?= e($doc['operator_name'] ?? 'Fabian Ternis') ?></strong><br>
                            <?= e($doc['operator_org'] ?? 'ternis-edv.de / ternis.dev') ?><br>
                            <?= e($doc['operator_address'] ?? 'Germany') ?>
                        </p>

                        <h3><?= e($doc['contact_heading'] ?? 'Contact') ?></h3>
                        <p>
                            <?= nl2br(e($doc['contact_email'] ?? '')) ?><br>
                            <?= nl2br(e($doc['contact_web'] ?? '')) ?>
                        </p>

                        <h3><?= e($doc['disclaimer_heading'] ?? 'Disclaimer') ?></h3>
                        <p><?= e($doc['disclaimer_text'] ?? '') ?></p>

                        <h3><?= e($doc['copyright_heading'] ?? 'Copyright') ?></h3>
                        <p><?= e($doc['copyright_text'] ?? '') ?></p>

                    <?php elseif ($slug === 'privacy'): ?>
                        <h3><?= e($doc['summary_heading'] ?? 'Overview') ?></h3>
                        <p><?= e($doc['summary_text'] ?? '') ?></p>

                        <h3><?= e($doc['server_heading'] ?? 'Server Logs') ?></h3>
                        <p><?= e($doc['server_text'] ?? '') ?></p>

                        <h3><?= e($doc['cookies_heading'] ?? 'Cookies') ?></h3>
                        <p><?= e($doc['cookies_text'] ?? '') ?></p>

                        <h3><?= e($doc['rights_heading'] ?? 'Your Rights') ?></h3>
                        <p><?= e($doc['rights_text'] ?? '') ?></p>

                    <?php elseif ($slug === 'license'): ?>
                        <h3><?= e($doc['license_heading'] ?? 'License') ?></h3>
                        <pre><?= e($doc['license_text'] ?? '') ?></pre>

                        <h3><?= e($doc['values_heading'] ?? 'Values') ?></h3>
                        <p><?= e($doc['values_text'] ?? '') ?></p>

                    <?php else: ?>
                        <p><?= e($doc['content'] ?? '') ?></p>
                    <?php endif; ?>
                </div>

                <div style="margin-top:3.5rem;padding-top:2rem;border-top:1px solid var(--border-subtle);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;">
                    <a href="/<?= e($lang) ?>" class="btn btn-secondary btn-sm">
                        &larr; <?= e(t('error.back_home')) ?>
                    </a>
                    <span style="font-size:0.85rem;color:var(--secondary);font-family:var(--font-mono);">
                        ternis.org legal disclosure &bull; <?= date('Y') ?>
                    </span>
                </div>
            </div>
        </div>
    </main>

    <!-- Sculpted Footer -->
    <footer class="sculpted-footer">
        <div class="container">
            <div class="footer-bottom">
                <div>
                    &copy; <?= date('Y') ?> ternis.org &bull; <?= e(t('footer.rights')) ?>
                </div>
                <div>
                    <?= e(t('footer.version')) ?>: <strong style="font-family:var(--font-mono);">v<?= e($versionShort) ?></strong>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="<?= e(asset_url('/assets/js/app.js')) ?>" defer></script>
</body>
</html>
