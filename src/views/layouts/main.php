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

    <!-- Critical App Loader CSS -->
    <style id="loader-critical-css">
        html.app-already-loaded #app-loader,
        #app-loader.loader-suppressed {
            display: none !important;
        }
        #app-loader {
            position: fixed;
            inset: 0;
            z-index: 999999;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f7f6f2;
            opacity: 1;
            visibility: visible;
            transition: opacity 0.5s cubic-bezier(0.16, 1, 0.3, 1),
                        visibility 0.5s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 0.5s cubic-bezier(0.16, 1, 0.3, 1),
                        filter 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            user-select: none;
            -webkit-user-select: none;
        }
        [data-theme="dark"] #app-loader {
            background-color: #0f140d;
        }
        #app-loader.loader-loaded .loader-bar {
            left: 0 !important;
            width: 100% !important;
            animation: none !important;
            background: #4a5d23 !important;
            transition: width 0.22s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }
        #app-loader.loader-hidden {
            opacity: 0 !important;
            visibility: hidden !important;
            transform: scale(1.03) translateY(-6px) !important;
            filter: blur(6px) !important;
            pointer-events: none !important;
        }
        .loader-inner {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            max-width: 90vw;
            padding: 2rem;
        }
        .loader-logo {
            font-family: 'Outfit', system-ui, sans-serif;
            font-size: clamp(2.5rem, 7vw, 4.5rem);
            font-weight: 600;
            letter-spacing: 3px;
            line-height: 1;
            color: #4a5d23;
        }
        [data-theme="dark"] .loader-logo {
            color: #94b858;
        }
        .loader-track {
            width: min(340px, 78vw);
            height: 3px;
            background: rgba(74, 93, 35, 0.12);
            border-radius: 99px;
            overflow: hidden;
            position: relative;
            margin-top: 2.25rem;
            margin-bottom: 1.25rem;
        }
        .loader-bar {
            position: absolute;
            top: 0;
            left: -50%;
            height: 100%;
            width: 45%;
            background: #4a5d23;
            border-radius: 99px;
            animation: loaderSlide 1.5s cubic-bezier(0.65, 0, 0.35, 1) infinite;
        }
        [data-theme="dark"] .loader-bar {
            background: #94b858;
        }
        .loader-status {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.65rem;
            font-family: 'Outfit', sans-serif;
            font-size: 0.75rem;
            letter-spacing: 0.25em;
            font-weight: 600;
            text-transform: uppercase;
            color: #8c9c6f;
        }
        .loader-status-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #4a5d23;
            opacity: 0.8;
            animation: loaderPulse 1.2s ease-in-out infinite alternate;
        }
        @keyframes loaderSlide {
            0%   { left: -50%; width: 35%; }
            50%  { width: 55%; }
            100% { left: 110%; width: 35%; }
        }
        @keyframes loaderPulse {
            0%   { opacity: 0.3; transform: scale(0.8); }
            100% { opacity: 1; transform: scale(1.2); }
        }
        @media (prefers-reduced-motion: reduce) {
            .loader-bar { animation: none; left: 0; width: 100%; }
            .loader-status-dot { animation: none; opacity: 1; }
            #app-loader.loader-hidden { transform: none !important; filter: none !important; }
        }
    </style>
    <noscript><style>#app-loader { display: none !important; }</style></noscript>

    <!-- Critical App Loader JS -->
    <script id="app-loader-js">
        (function() {
            try {
                if (sessionStorage.getItem('ternis_loaded')) {
                    document.documentElement.classList.add('app-already-loaded');
                    return;
                }
            } catch (e) {}

            var start = performance.now();
            var MIN_MS = 350;
            var MAX_MS = 2000;
            var isFinished = false;

            function finish() {
                if (isFinished) return;
                isFinished = true;

                try {
                    sessionStorage.setItem('ternis_loaded', '1');
                } catch (e) {}

                var loader = document.getElementById('app-loader');
                if (!loader) return;
                var elapsed = performance.now() - start;
                var delay = Math.max(0, MIN_MS - elapsed);

                setTimeout(function() {
                    loader.classList.add('loader-loaded');
                    setTimeout(function() {
                        loader.classList.add('loader-hidden');
                        function cleanup() {
                            if (loader && loader.parentNode) {
                                loader.parentNode.removeChild(loader);
                            }
                        }
                        loader.addEventListener('transitionend', cleanup, { once: true });
                        setTimeout(cleanup, 700);
                    }, 180);
                }, delay);
            }

            if (document.readyState === 'complete') {
                finish();
            } else {
                window.addEventListener('load', finish, { once: true });
            }
            setTimeout(finish, MAX_MS);
        })();
    </script>

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
    <div id="scroll-progress" class="scroll-progress-bar" aria-hidden="true"></div>

    <!-- Initial App Loader -->
    <div id="app-loader" class="app-loader" aria-hidden="true">
        <div class="loader-inner">
            <div class="loader-logo">ternis.org</div>
            <div class="loader-track">
                <div class="loader-bar"></div>
            </div>
            <div class="loader-status">
                <span class="loader-status-dot"></span>
                <span class="loader-status-text">INITIALIZING</span>
            </div>
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
