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
<html lang="<?= e($lang) ?>" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($code) ?> — <?= e($message) ?> — ternis.org</title>
    <meta name="robots" content="noindex, nofollow">

    <!-- Fonts & Stylesheet -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="<?= e(asset_url('/assets/css/app.css')) ?>">
</head>
<body style="display:flex;flex-direction:column;min-height:100vh;justify-content:space-between;">

    <!-- Ambient Glowing Blobs -->
    <div class="ambient-glow" aria-hidden="true">
        <div class="glow-orb-1"></div>
        <div class="glow-orb-2"></div>
    </div>

    <!-- Header Navigation -->
    <header class="site-header">
        <div class="container nav-wrapper">
            <a href="/<?= e($lang) ?>" class="nav-brand">
                <span class="brand-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </span>
                <span>ternis.org</span>
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
        </div>
    </header>

    <main style="padding:6rem 0;text-align:center;flex-grow:1;display:flex;align-items:center;">
        <div class="container" style="max-width:640px;">
            <div style="font-size:clamp(4rem, 10vw, 7rem);font-weight:900;font-family:var(--font-mono);background:var(--gradient-hero);-webkit-background-clip:text;-webkit-text-fill-color:transparent;line-height:1;margin-bottom:1.5rem;">
                <?= e($code) ?>
            </div>
            <h1 style="font-size:2rem;font-weight:700;margin-bottom:1rem;"><?= e($message) ?></h1>
            <p style="color:var(--text-secondary);font-size:1.1rem;margin-bottom:2.5rem;">
                <?= e(t('error.desc')) ?>
            </p>
            <div style="display:flex;justify-content:center;gap:1rem;flex-wrap:wrap;">
                <a href="/<?= e($lang) ?>" class="btn btn-primary">
                    &larr; <?= e(t('error.back_home')) ?>
                </a>
                <a href="/<?= e($lang) ?>#projects" class="btn btn-secondary">
                    <?= e(t('error.explore_proj')) ?>
                </a>
            </div>
        </div>
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="footer-bottom">
                <div>
                    &copy; <?= date('Y') ?> ternis.org. <?= e(t('footer.rights')) ?>
                </div>
                <div class="footer-meta">
                    <span><?= e(t('footer.version')) ?>: <span class="version-badge">v<?= e($versionShort) ?></span></span>
                </div>
            </div>
        </div>
    </footer>

    <script src="<?= e(asset_url('/assets/js/app.js')) ?>" defer></script>
</body>
</html>
