<?php

declare(strict_types=1);

/**
 * Error view template (404 / 500)
 * @var string $lang
 * @var int $code
 * @var string $message
 */

$lang = current_lang();
$code = $code ?? 404;
$message = $message ?? t('error.not_found');
$versionShort = app_version_hash(true);
?>
<!DOCTYPE html>
<html lang="<?= e($lang) ?>" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($code) ?> — <?= e($message) ?> — ternis.org</title>
    <meta name="robots" content="noindex, nofollow">

    <!-- Fonts & Stylesheet -->
    <link rel="stylesheet" href="<?= e(asset_url('/assets/css/app.css')) ?>">
</head>
<body style="display:flex;flex-direction:column;min-height:100vh;justify-content:space-between;">

    <!-- Organic Blobs -->
    <div class="blob blob-1" aria-hidden="true"></div>
    <div class="blob blob-2" aria-hidden="true"></div>

    <!-- Floating Pill Navigation -->
    <div class="nav-container-fixed">
        <nav class="floating-nav">
            <a href="/<?= e($lang) ?>" class="logo">
                <span>ternis.org</span>
                <span class="logo-dot" title="Operational"></span>
            </a>

            <div class="nav-actions">
                <div class="lang-switcher">
                    <a href="/en" class="lang-btn <?= $lang === 'en' ? 'active' : '' ?>">EN</a>
                    <a href="/de" class="lang-btn <?= $lang === 'de' ? 'active' : '' ?>">DE</a>
                </div>

                <button type="button" class="btn-icon btn-theme-toggle" aria-label="Toggle theme">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </button>
            </div>
        </nav>
    </div>

    <main style="padding:12rem 0 6rem;text-align:center;flex-grow:1;display:flex;align-items:center;">
        <div class="container" style="max-width:640px;">
            <div style="font-size:clamp(4.5rem, 12vw, 8rem);font-weight:300;font-family:var(--font-mono);color:var(--primary);line-height:1;margin-bottom:1.5rem;">
                <?= e($code) ?>
            </div>
            <h1 style="font-size:2rem;font-weight:600;color:var(--primary);margin-bottom:1rem;"><?= e($message) ?></h1>
            <p style="color:var(--secondary);font-size:1.15rem;margin-bottom:2.5rem;">
                <?= e(t('error.desc')) ?>
            </p>
            <div style="display:flex;justify-content:center;gap:1.25rem;flex-wrap:wrap;">
                <a href="/<?= e($lang) ?>" class="btn">
                    &larr; <?= e(t('error.back_home')) ?>
                </a>
                <a href="/<?= e($lang) ?>#projects" class="btn btn-secondary">
                    <?= e(t('error.explore_proj')) ?>
                </a>
            </div>
        </div>
    </main>

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

    <script src="<?= e(asset_url('/assets/js/app.js')) ?>" defer></script>
</body>
</html>
