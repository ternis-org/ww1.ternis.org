<?php

declare(strict_types=1);

/**
 * Main Base Layout for ternis.org
 * @var string $slot
 * @var string $lang
 * @var string|null $title
 * @var string|null $metaDescription
 * @var string|null $metaKeywords
 * @var string|null $canonicalUrl
 * @var bool|null $showNav
 * @var bool|null $showFooter
 * @var bool|null $showScrollTop
 */

$lang            = $lang ?? current_lang();
$altLang         = $lang === 'en' ? 'de' : 'en';
$pageTitle       = $title ?? t('meta.title');
$metaDescription = $metaDescription ?? t('meta.description');
$metaKeywords    = $metaKeywords ?? t('meta.keywords');
$canonical       = $canonicalUrl ?? ('https://ternis.org/' . $lang);
$canonicalPath   = parse_url($canonical, PHP_URL_PATH) ?? '/' . $lang;
$altUrl          = 'https://ternis.org' . lang_url($altLang, $canonicalPath);
$xDefaultUrl     = 'https://ternis.org' . lang_url('en', $canonicalPath);
$versionShort    = app_version_hash(true);
$showNav         = $showNav ?? true;
$showFooter      = $showFooter ?? true;
$showScrollTop   = $showScrollTop ?? true;
?>
<!DOCTYPE html>
<html lang="<?= e($lang) ?>" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Instant Theme Initializer (Prevents FOUC) -->
    <script>
        (function() {
            try {
                var t = localStorage.getItem('ternis_theme');
                if (!t) {
                    t = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                }
                document.documentElement.setAttribute('data-theme', t);
            } catch (e) {}
        })();
    </script>

    <!-- Font Preconnect & Stylesheet -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap">

    <!-- SEO Meta Tags -->
    <title><?= e($pageTitle) ?></title>
    <meta name="title" content="<?= e($pageTitle) ?>">
    <meta name="description" content="<?= e($metaDescription) ?>">
    <meta name="keywords" content="<?= e($metaKeywords) ?>">
    <meta name="author" content="ternis.org">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= e($canonical) ?>">
    <link rel="alternate" hreflang="<?= e($altLang) ?>" href="<?= e($altUrl) ?>">
    <link rel="alternate" hreflang="x-default" href="<?= e($xDefaultUrl) ?>">

    <!-- Open Graph / Twitter -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= e($canonical) ?>">
    <meta property="og:title" content="<?= e($pageTitle) ?>">
    <meta property="og:description" content="<?= e($metaDescription) ?>">
    <meta property="og:image" content="https://ternis.org/og.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= e($canonical) ?>">
    <meta property="twitter:title" content="<?= e($pageTitle) ?>">
    <meta property="twitter:description" content="<?= e($metaDescription) ?>">
    <meta property="twitter:image" content="https://ternis.org/og.jpg">

    <!-- Theme & Icons -->
    <meta name="theme-color" content="#4a5d23">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="icon" type="image/x-icon" href="/favicon.ico" sizes="32x32">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="manifest" href="/manifest.json">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="<?= e(asset_url('/assets/css/app.css')) ?>">

    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "ternis.org",
        "url": "https://ternis.org",
        "description": "<?= e($metaDescription) ?>",
        "logo": "https://ternis.org/favicon.svg",
        "parentOrganization": {
            "@type": "Organization",
            "name": "ternis.dev / ternis-edv.de",
            "url": "https://ternis.dev"
        },
        "sameAs": [
            "<?= e(config('repo_url')) ?>",
            "<?= e(config('org_github')) ?>",
            "https://ternis.dev",
            "https://ternis-edv.de",
            "https://mtex.dev",
            "https://getmy.name",
            "https://dnbx.de",
            "https://drophtml.de",
            "https://example-dns.com",
            "https://github.com/example-dns/example-dns"
        ]
    }
    </script>
</head>
<body>

    <!-- Top Scroll Progress Indicator -->
    <div id="scroll-progress" class="scroll-progress-bar" aria-hidden="true">
        <div class="scroll-progress-track">
            <div class="scroll-progress-fill"></div>
            <div class="scroll-progress-head"></div>
        </div>
    </div>

    <?php if ($showNav): ?>
        <?php component('navbar', ['lang' => $lang]); ?>
    <?php endif; ?>

    <!-- Main Sections Wrapper -->
    <div class="sections-wrapper">
        <main id="main-content">
            <?= $slot ?>
        </main>

        <?php if ($showScrollTop): ?>
            <?php component('scroll_to_top'); ?>
        <?php endif; ?>
    </div><!-- /.sections-wrapper -->

    <?php if ($showFooter): ?>
        <?php component('footer', ['lang' => $lang, 'versionShort' => $versionShort]); ?>
    <?php endif; ?>

    <!-- Scripts -->
    <script src="<?= e(asset_url('/assets/js/app.js')) ?>" defer></script>
</body>
</html>
