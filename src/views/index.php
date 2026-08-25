<?php

declare(strict_types=1);

/**
 * Main index template for ternis.org
 * @var string $lang
 */

$lang = current_lang();
$canonicalUrl = 'https://ternis.org/' . $lang;
$altLang = $lang === 'en' ? 'de' : 'en';
$altUrl = 'https://ternis.org/' . $altLang;
$versionShort = app_version_hash(true);
?>
<!DOCTYPE html>
<html lang="<?= e($lang) ?>" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

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
    <title><?= e(t('meta.title')) ?></title>
    <meta name="title" content="<?= e(t('meta.title')) ?>">
    <meta name="description" content="<?= e(t('meta.description')) ?>">
    <meta name="keywords" content="<?= e(t('meta.keywords')) ?>">
    <meta name="author" content="<?= e(t('meta.author')) ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= e($canonicalUrl) ?>">
    <link rel="alternate" hreflang="<?= e($altLang) ?>" href="<?= e($altUrl) ?>">
    <link rel="alternate" hreflang="x-default" href="https://ternis.org/en">

    <!-- Open Graph / Twitter -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= e($canonicalUrl) ?>">
    <meta property="og:title" content="<?= e(t('meta.og_title')) ?>">
    <meta property="og:description" content="<?= e(t('meta.og_description')) ?>">
    <meta property="og:image" content="https://ternis.org/og.jpg">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= e($canonicalUrl) ?>">
    <meta property="twitter:title" content="<?= e(t('meta.og_title')) ?>">
    <meta property="twitter:description" content="<?= e(t('meta.og_description')) ?>">

    <!-- Theme & Icons -->
    <meta name="theme-color" content="#4a5d23">
    <link rel="icon" href="/favicon.ico" sizes="any">
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
        "description": "<?= e(t('meta.description')) ?>",
        "parentOrganization": {
            "@type": "Organization",
            "name": "ternis.dev / ternis-edv.de",
            "url": "https://ternis.dev"
        },
        "sameAs": [
            "https://github.com/ternis-org",
            "https://ternis.dev",
            "https://ternis-edv.de",
            "https://mtex.dev",
            "https://getmy.name",
            "https://dnbx.de"
        ]
    }
    </script>
</head>
<body>

    <!-- Floating Pill Navigation -->
    <div class="nav-container-fixed">
        <nav class="floating-nav">
            <a href="/<?= e($lang) ?>" class="logo">
                <span>ternis.org</span>
            </a>

            <div class="nav-links">
                <a href="#projects"><?= e(t('nav.projects')) ?></a>
                <a href="https://getmy.name/api-docs" target="_blank" rel="noopener noreferrer">API Docs</a>
                <a href="#connect"><?= e(t('nav.ecosystem')) ?></a>
            </div>

            <div class="nav-actions">
                <!-- Language Switcher -->
                <div class="lang-switcher">
                    <a href="/en" class="lang-btn <?= $lang === 'en' ? 'active' : '' ?>">EN</a>
                    <a href="/de" class="lang-btn <?= $lang === 'de' ? 'active' : '' ?>">DE</a>
                </div>

                <!-- Theme Toggle -->
                <button type="button" class="btn-icon btn-theme-toggle" aria-label="<?= e(t('nav.toggle_theme')) ?>">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </button>

                <!-- GitHub Org Link -->
                <a href="https://github.com/ternis-org" target="_blank" rel="noopener noreferrer" class="btn-icon" aria-label="GitHub Organization">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"></path>
                    </svg>
                </a>

                <!-- Mobile Hamburger Toggle -->
                <button type="button" class="btn-icon mobile-toggle" aria-label="Toggle navigation" aria-expanded="false">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </nav>
    </div>

    <!-- Mobile Drawer -->
    <div class="mobile-drawer">
        <a href="#projects" class="nav-link"><?= e(t('nav.projects')) ?></a>
        <a href="https://getmy.name/api-docs" target="_blank" rel="noopener noreferrer" class="nav-link">API Docs</a>
        <a href="#connect" class="nav-link"><?= e(t('nav.ecosystem')) ?></a>
        <a href="/<?= e($lang) ?>/legal/imprint" class="nav-link"><?= e(t('nav.imprint')) ?></a>
        <a href="/<?= e($lang) ?>/legal/privacy" class="nav-link"><?= e(t('nav.privacy')) ?></a>
    </div>

    <!-- Main Sections Wrapper (Sticky Boundary for Scroll-To-Top) -->
    <div class="sections-wrapper">
        <main>
            <!-- Hero Section -->
            <section id="hero">
                <div class="container">
                    <h1>
                        <?= e(t('hero.title_line1')) ?><br>
                        <strong><?= e(t('hero.title_line2')) ?></strong>
                    </h1>

                    <p class="hero-p">
                        <?= e(t('hero.description')) ?>
                    </p>

                    <div class="hero-actions">
                        <!-- Main CTA with Expanding Arrow -->
                        <a href="#projects" class="btn btn-expanding">
                            <span><?= e(t('hero.cta_projects')) ?></span>
                            <svg class="arrow-svg" viewBox="0 0 35 12" fill="none">
                                <path d="M 28.833 1 L 33.244 5.411 C 33.57 5.736 33.57 6.264 33.244 6.589 L 28.833 11" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M 1.5 6 L 32 6" stroke-width="1.5" stroke-linecap="round" class="line"/>
                            </svg>
                        </a>
                        <a href="https://getmy.name/api-docs" target="_blank" rel="noopener noreferrer" class="btn btn-secondary">
                            <span><?= e(t('hero.cta_playground')) ?></span>
                        </a>
                        <a href="https://github.com/ternis-org" target="_blank" rel="noopener noreferrer" class="btn btn-outline">
                            <svg fill="currentColor" viewBox="0 0 24 24" style="width:16px;height:16px;">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"></path>
                            </svg>
                            <span><?= e(t('hero.cta_github')) ?></span>
                        </a>
                    </div>

                    <!-- Hero Stats Bar -->
                    <div class="hero-stats">
                        <div class="stat-item">
                            <div class="stat-value"><?= e(t('hero.stat_open_source')) ?></div>
                            <div class="stat-label"><?= e(t('hero.stat_open_source_sub')) ?></div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value"><?= e(t('hero.stat_privacy')) ?></div>
                            <div class="stat-label"><?= e(t('hero.stat_privacy_sub')) ?></div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value"><?= e(t('hero.stat_latency')) ?></div>
                            <div class="stat-label"><?= e(t('hero.stat_latency_sub')) ?></div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value"><?= e(t('hero.stat_uptime')) ?></div>
                            <div class="stat-label"><?= e(t('hero.stat_uptime_sub')) ?></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Projects Showcase Section -->
            <section id="projects" style="padding-top: 4rem;">
                <div class="container">
                    <div class="section-header" style="margin-bottom: 2.5rem;">
                        <h2><?= e(t('projects.title')) ?></h2>
                        <p class="section-subtitle"><?= e(t('projects.subtitle')) ?></p>
                    </div>

                    <!-- dnbx.de Domain Management Notice Bar -->
                    <div style="background: var(--bg-card); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 1rem 1.75rem; margin-bottom: 2.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <span class="badge badge-primary" style="font-size:0.75rem;">DNS & Infrastructure</span>
                            <span style="font-size: 0.95rem; color: var(--text-dark);"><?= e(t('projects.dnbx_note')) ?></span>
                        </div>
                        <a href="https://dnbx.de" target="_blank" rel="noopener noreferrer" class="btn-expanding" style="font-family: var(--font-mono); font-size: 0.85rem; font-weight: 600; color: var(--primary); display: inline-flex; align-items: center; gap: 0.45rem;">
                            <span>dnbx.de</span>
                            <svg class="arrow-svg" viewBox="0 0 35 12" fill="none">
                                <path d="M 28.833 1 L 33.244 5.411 C 33.57 5.736 33.57 6.264 33.244 6.589 L 28.833 11" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M 1.5 6 L 32 6" stroke-width="1.5" stroke-linecap="round" class="line"/>
                            </svg>
                        </a>
                    </div>

                    <div class="projects-grid">
                        <!-- Project 1: httpclient.de -->
                        <div class="project-card">
                            <div>
                                <div class="project-header">
                                    <h3><?= e(t('projects.httpclient.title')) ?></h3>
                                    <span class="badge badge-accent"><?= e(t('projects.httpclient.badge')) ?></span>
                                </div>
                                <div class="project-tagline"><?= e(t('projects.httpclient.tagline')) ?></div>
                                <p class="project-desc"><?= e(t('projects.httpclient.description')) ?></p>
                                <div class="project-tags">
                                    <?php foreach (t_array('projects.httpclient.tags') as $tag): ?>
                                        <span class="project-tag"><?= e($tag) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="project-actions">
                                <a href="<?= e(t('projects.httpclient.url')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm">
                                    <span><?= e(t('projects.view_project')) ?></span>
                                </a>
                            </div>
                        </div>

                        <!-- Project 2: api-sandbox.de -->
                        <div class="project-card">
                            <div>
                                <div class="project-header">
                                    <h3><?= e(t('projects.apisandbox.title')) ?></h3>
                                    <span class="badge badge-secondary"><?= e(t('projects.apisandbox.badge')) ?></span>
                                </div>
                                <div class="project-tagline"><?= e(t('projects.apisandbox.tagline')) ?></div>
                                <p class="project-desc"><?= e(t('projects.apisandbox.description')) ?></p>
                                <div class="project-tags">
                                    <?php foreach (t_array('projects.apisandbox.tags') as $tag): ?>
                                        <span class="project-tag"><?= e($tag) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="project-actions">
                                <a href="<?= e(t('projects.apisandbox.url')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm">
                                    <span><?= e(t('projects.view_project')) ?></span>
                                </a>
                            </div>
                        </div>

                        <!-- Project 3: MTEX.dev (e.g. getmy.name) -->
                        <div class="project-card">
                            <div>
                                <div class="project-header">
                                    <h3><?= e(t('projects.mtex.title')) ?></h3>
                                    <span class="badge badge-primary"><?= e(t('projects.mtex.badge')) ?></span>
                                </div>
                                <div class="project-tagline"><?= e(t('projects.mtex.tagline')) ?></div>
                                <p class="project-desc"><?= e(t('projects.mtex.description')) ?></p>
                                <div class="project-tags">
                                    <?php foreach (t_array('projects.mtex.tags') as $tag): ?>
                                        <span class="project-tag"><?= e($tag) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="project-actions">
                                <a href="<?= e(t('projects.mtex.url')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm">
                                    <span><?= e(t('projects.view_project')) ?></span>
                                </a>
                                <a href="https://getmy.name" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">
                                    <span>getmy.name</span>
                                </a>
                                <a href="https://getmy.name/api-docs" target="_blank" rel="noopener noreferrer" class="btn btn-outline btn-sm">
                                    <span><?= e(t('projects.view_docs')) ?></span>
                                </a>
                            </div>
                        </div>

                        <!-- Project 4: web-search.org -->
                        <div class="project-card">
                            <div>
                                <div class="project-header">
                                    <h3><?= e(t('projects.websearch.title')) ?></h3>
                                    <span class="badge badge-accent"><?= e(t('projects.websearch.badge')) ?></span>
                                </div>
                                <div class="project-tagline"><?= e(t('projects.websearch.tagline')) ?></div>
                                <p class="project-desc"><?= e(t('projects.websearch.description')) ?></p>
                                <div class="project-tags">
                                    <?php foreach (t_array('projects.websearch.tags') as $tag): ?>
                                        <span class="project-tag"><?= e($tag) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="project-actions">
                                <a href="<?= e(t('projects.websearch.url')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm">
                                    <span><?= e(t('projects.view_project')) ?></span>
                                </a>
                            </div>
                        </div>

                        <!-- Project 5: mail-free.eu + mail-free.uk -->
                        <div class="project-card">
                            <div>
                                <div class="project-header">
                                    <h3><?= e(t('projects.mailfree.title')) ?></h3>
                                    <span class="badge badge-secondary"><?= e(t('projects.mailfree.badge')) ?></span>
                                </div>
                                <div class="project-tagline"><?= e(t('projects.mailfree.tagline')) ?></div>
                                <p class="project-desc"><?= e(t('projects.mailfree.description')) ?></p>
                                <div class="project-tags">
                                    <?php foreach (t_array('projects.mailfree.tags') as $tag): ?>
                                        <span class="project-tag"><?= e($tag) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="project-actions">
                                <a href="<?= e(t('projects.mailfree.url_eu')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">
                                    <span>mail-free.eu</span>
                                </a>
                                <a href="<?= e(t('projects.mailfree.url_uk')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">
                                    <span>mail-free.uk</span>
                                </a>
                            </div>
                        </div>

                        <!-- Project 6: static.re -->
                        <div class="project-card">
                            <div>
                                <div class="project-header">
                                    <h3><?= e(t('projects.staticre.title')) ?></h3>
                                    <span class="badge badge-accent"><?= e(t('projects.staticre.badge')) ?></span>
                                </div>
                                <div class="project-tagline"><?= e(t('projects.staticre.tagline')) ?></div>
                                <p class="project-desc"><?= e(t('projects.staticre.description')) ?></p>
                                <div class="project-tags">
                                    <?php foreach (t_array('projects.staticre.tags') as $tag): ?>
                                        <span class="project-tag"><?= e($tag) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="project-actions">
                                <a href="<?= e(t('projects.staticre.url')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">
                                    <span><?= e(t('projects.view_project')) ?></span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- More Projects Indicator Card -->
                    <div style="text-align: center; margin-top: 3.5rem; padding: 2.5rem; background: var(--bg-card); border: 1px dashed var(--border-highlight); border-radius: var(--radius-lg);">
                        <h3 style="font-size: 1.4rem; font-weight: 600; color: var(--primary); margin-bottom: 0.5rem;">... and more projects in active development</h3>
                        <p style="color: var(--text-muted); max-width: 580px; margin: 0 auto 1.5rem; font-size: 0.95rem;">
                            Discover our full suite of open-source utilities, repositories, and upcoming developer tools on the ternis-org GitHub organization.
                        </p>
                        <a href="https://github.com/ternis-org" target="_blank" rel="noopener noreferrer" class="btn btn-outline btn-sm btn-expanding">
                            <svg fill="currentColor" viewBox="0 0 24 24" style="width:16px;height:16px;">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"></path>
                            </svg>
                            <span>Explore ternis-org on GitHub</span>
                            <svg class="arrow-svg" viewBox="0 0 35 12" fill="none">
                                <path d="M 28.833 1 L 33.244 5.411 C 33.57 5.736 33.57 6.264 33.244 6.589 L 28.833 11" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M 1.5 6 L 32 6" stroke-width="1.5" stroke-linecap="round" class="line"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </section>
        </main>

        <!-- Sticky Scroll-To-Top Tracker (Sticky inside sections-wrapper, but outside footer) -->
        <div class="scroll-top-tracker">
            <button type="button" id="scroll-to-top" class="scroll-to-top" aria-label="Scroll to top">
                <svg class="progress-ring" width="44" height="44" viewBox="0 0 44 44">
                    <circle class="progress-ring-bg" stroke-width="2.5" fill="none" r="19" cx="22" cy="22" />
                    <circle class="progress-ring-circle" stroke-width="2.5" stroke-linecap="round" fill="none" r="19" cx="22" cy="22" />
                </svg>
                <svg class="scroll-arrow-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 19V5M5 12l7-7 7 7"/>
                </svg>
            </button>
        </div>
    </div><!-- /.sections-wrapper -->

    <!-- Sculpted Organic Footer -->
    <footer id="connect" class="sculpted-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-cta">
                    Let's grow<br>
                    <strong>something beautiful.</strong>
                    <div style="margin-top:2.5rem;">
                        <a href="https://ternis.dev" target="_blank" rel="noopener noreferrer" class="btn btn-expanding" style="background:var(--bg-color);color:var(--primary);box-shadow:none;">
                            <span><?= e(t('cta.btn_contact')) ?></span>
                            <svg class="arrow-svg" viewBox="0 0 35 12" fill="none">
                                <path d="M 28.833 1 L 33.244 5.411 C 33.57 5.736 33.57 6.264 33.244 6.589 L 28.833 11" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M 1.5 6 L 32 6" stroke-width="1.5" stroke-linecap="round" class="line"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="footer-links-grid">
                    <div class="footer-col">
                        <h4><?= e(t('footer.col_projects')) ?></h4>
                        <ul>
                            <li><a href="https://httpclient.de" target="_blank" rel="noopener noreferrer">httpclient.de</a></li>
                            <li><a href="https://api-sandbox.de" target="_blank" rel="noopener noreferrer">api-sandbox.de</a></li>
                            <li><a href="https://mtex.dev" target="_blank" rel="noopener noreferrer">MTEX.dev</a></li>
                            <li><a href="https://getmy.name" target="_blank" rel="noopener noreferrer">getmy.name</a></li>
                            <li><a href="https://web-search.org" target="_blank" rel="noopener noreferrer">web-search.org</a></li>
                            <li><a href="https://mail-free.eu" target="_blank" rel="noopener noreferrer">mail-free.eu</a></li>
                            <li><a href="https://static.re" target="_blank" rel="noopener noreferrer">static.re</a></li>
                        </ul>
                    </div>

                    <div class="footer-col">
                        <h4><?= e(t('footer.col_ecosystem')) ?></h4>
                        <ul>
                            <li><a href="https://dnbx.de" target="_blank" rel="noopener noreferrer">dnbx.de (DNS)</a></li>
                            <li><a href="https://ternis.dev" target="_blank" rel="noopener noreferrer">ternis.dev</a></li>
                            <li><a href="https://ternis-edv.de" target="_blank" rel="noopener noreferrer">ternis-edv.de</a></li>
                            <li><a href="https://github.com/ternis-org" target="_blank" rel="noopener noreferrer">GitHub Org</a></li>
                            <li><a href="/api/ver" target="_blank">Version Hash</a></li>
                        </ul>
                    </div>

                    <div class="footer-col">
                        <h4><?= e(t('footer.col_legal')) ?></h4>
                        <ul>
                            <li><a href="/<?= e($lang) ?>/legal/imprint"><?= e(t('nav.imprint')) ?></a></li>
                            <li><a href="/<?= e($lang) ?>/legal/privacy"><?= e(t('nav.privacy')) ?></a></li>
                            <li><a href="/<?= e($lang) ?>/legal/license"><?= e(t('nav.license')) ?></a></li>
                            <li><a href="/sitemap.xml">Sitemap.xml</a></li>
                        </ul>
                    </div>
                </div>
            </div>

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
