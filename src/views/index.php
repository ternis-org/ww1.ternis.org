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
            box-shadow: 0 0 20px rgba(74, 93, 35, 0.6) !important;
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
            background: linear-gradient(90deg, transparent 0%, rgba(74, 93, 35, 0.3) 25%, #4a5d23 50%, rgba(74, 93, 35, 0.3) 75%, transparent 100%);
            border-radius: 99px;
            box-shadow: 0 0 14px rgba(74, 93, 35, 0.5);
            animation: loaderSlide 1.5s cubic-bezier(0.65, 0, 0.35, 1) infinite;
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
            box-shadow: 0 0 8px rgba(74, 93, 35, 0.6);
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
            "https://getmy.name"
        ]
    }
    </script>
</head>
<body>

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

    <!-- Organic Morphing Blobs -->
    <div class="blob blob-1" aria-hidden="true"></div>
    <div class="blob blob-2" aria-hidden="true"></div>
    <div class="blob blob-3" aria-hidden="true"></div>

    <!-- Floating Pill Navigation -->
    <div class="nav-container-fixed">
        <nav class="floating-nav">
            <a href="/<?= e($lang) ?>" class="logo">
                <span>ternis.org</span>
            </a>

            <div class="nav-links">
                <a href="#about"><?= e(t('nav.about')) ?></a>
                <a href="#projects"><?= e(t('nav.projects')) ?></a>
                <a href="#playground"><?= e(t('nav.playground')) ?></a>
                <a href="#maintainer"><?= e(t('nav.ecosystem')) ?></a>
                <a href="#roadmap"><?= e(t('nav.roadmap')) ?></a>
                <a href="#faq"><?= e(t('nav.faq')) ?></a>
            </div>

            <div class="nav-actions">
                <!-- Nav Action CTA Button -->
                <a href="#projects" class="btn btn-sm btn-nav-cta">
                    <?= e(t('nav.cta_explore')) ?>
                </a>

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
        <a href="#about" class="nav-link"><?= e(t('nav.about')) ?></a>
        <a href="#projects" class="nav-link"><?= e(t('nav.projects')) ?></a>
        <a href="#playground" class="nav-link"><?= e(t('nav.playground')) ?></a>
        <a href="#maintainer" class="nav-link"><?= e(t('nav.ecosystem')) ?></a>
        <a href="#roadmap" class="nav-link"><?= e(t('nav.roadmap')) ?></a>
        <a href="#faq" class="nav-link"><?= e(t('nav.faq')) ?></a>
        <a href="/<?= e($lang) ?>/legal/imprint" class="nav-link"><?= e(t('nav.imprint')) ?></a>
        <a href="/<?= e($lang) ?>/legal/privacy" class="nav-link"><?= e(t('nav.privacy')) ?></a>
    </div>

    <!-- Main Sections Wrapper (Sticky Boundary for Scroll-To-Top) -->
    <div class="sections-wrapper">
        <main>
            <!-- Hero Section -->
            <section id="hero">
            <div class="container">
                <div class="section-badge">
                    <span class="badge badge-primary"><?= e(t('hero.badge')) ?></span>
                </div>

                <h1>
                    <?= e(t('hero.title_line1')) ?><br>
                    <strong><?= e(t('hero.title_line2')) ?></strong>
                </h1>

                <p class="hero-p">
                    <?= e(t('hero.description')) ?>
                </p>

                <div class="hero-actions">
                    <a href="#projects" class="btn">
                        <span><?= e(t('hero.cta_projects')) ?></span>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:16px;height:16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                    <a href="#playground" class="btn btn-secondary">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:16px;height:16px;color:var(--primary);">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
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

        <!-- Two-Col Section (Philosophy) -->
        <section id="about">
            <div class="container">
                <div class="two-col">
                    <div class="image-col-sculpted">
                        <h3>Digital Sustainability</h3>
                        <p>Lightweight architectures, green European hosting, and zero bloat for a cleaner web footprint.</p>
                    </div>

                    <div class="text-col">
                        <div class="section-badge">
                            <span class="badge badge-secondary"><?= e(t('mission.badge')) ?></span>
                        </div>
                        <h2><?= e(t('mission.title')) ?></h2>
                        <p><?= e(t('mission.description')) ?></p>
                        <p><?= e(t('mission.card1_desc')) ?></p>
                        <p><?= e(t('mission.card2_desc')) ?></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Values Grid (Impact) -->
        <section id="impact">
            <div class="container">
                <div class="section-header">
                    <div class="section-badge">
                        <span class="badge badge-accent">Core Pillars</span>
                    </div>
                    <h2 class="section-title">Engineered for Tomorrow</h2>
                    <p class="section-subtitle">Zero compromises on privacy, performance, or software freedom.</p>
                </div>

                <div class="values-grid">
                    <div class="value-card">
                        <div class="value-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                            </svg>
                        </div>
                        <h3><?= e(t('mission.card1_title')) ?></h3>
                        <p><?= e(t('mission.card1_desc')) ?></p>
                    </div>

                    <div class="value-card">
                        <div class="value-icon" style="background:var(--secondary);">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3><?= e(t('mission.card2_title')) ?></h3>
                        <p><?= e(t('mission.card2_desc')) ?></p>
                    </div>

                    <div class="value-card">
                        <div class="value-icon" style="background:var(--accent);">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3><?= e(t('mission.card3_title')) ?></h3>
                        <p><?= e(t('mission.card3_desc')) ?></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Maintained Projects Showcase -->
        <section id="projects">
            <div class="container">
                <div class="section-header">
                    <div class="section-badge">
                        <span class="badge badge-primary"><?= e(t('projects.badge')) ?></span>
                    </div>
                    <h2 class="section-title"><?= e(t('projects.title')) ?></h2>
                    <p class="section-subtitle"><?= e(t('projects.subtitle')) ?></p>
                </div>

                <div class="projects-grid">
                    <!-- Project 1: getmy.name -->
                    <div class="project-card">
                        <div>
                            <div class="project-header">
                                <h3><?= e(t('projects.getmyname.title')) ?></h3>
                                <span class="badge badge-primary"><?= e(t('projects.getmyname.badge')) ?></span>
                            </div>

                            <div class="project-tagline"><?= e(t('projects.getmyname.tagline')) ?></div>
                            <p class="project-desc"><?= e(t('projects.getmyname.description')) ?></p>

                            <div class="project-tags">
                                <?php foreach (t_array('projects.getmyname.tags') as $tag): ?>
                                    <span class="project-tag"><?= e($tag) ?></span>
                                <?php endforeach; ?>
                            </div>

                            <ul class="project-features">
                                <?php foreach (t_array('projects.getmyname.features') as $feature): ?>
                                    <li>
                                        <svg fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span><?= e($feature) ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <div class="project-actions">
                            <a href="<?= e(t('projects.getmyname.url')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm">
                                <span><?= e(t('projects.view_project')) ?></span>
                            </a>
                            <a href="https://getmy.name/api-docs" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">
                                <span>API Docs</span>
                            </a>
                            <a href="<?= e(t('projects.getmyname.repo')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline btn-sm">
                                <span><?= e(t('projects.view_repo')) ?></span>
                            </a>
                        </div>
                    </div>

                    <!-- Project 2: MTEX.dev -->
                    <div class="project-card">
                        <div>
                            <div class="project-header">
                                <h3><?= e(t('projects.mtex.title')) ?></h3>
                                <span class="badge badge-secondary"><?= e(t('projects.mtex.badge')) ?></span>
                            </div>

                            <div class="project-tagline"><?= e(t('projects.mtex.tagline')) ?></div>
                            <p class="project-desc"><?= e(t('projects.mtex.description')) ?></p>

                            <div class="project-tags">
                                <?php foreach (t_array('projects.mtex.tags') as $tag): ?>
                                    <span class="project-tag"><?= e($tag) ?></span>
                                <?php endforeach; ?>
                            </div>

                            <ul class="project-features">
                                <?php foreach (t_array('projects.mtex.features') as $feature): ?>
                                    <li>
                                        <svg fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span><?= e($feature) ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <div class="project-actions">
                            <a href="<?= e(t('projects.mtex.url')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm">
                                <span><?= e(t('projects.view_project')) ?></span>
                            </a>
                            <a href="<?= e(t('projects.mtex.repo')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline btn-sm">
                                <span><?= e(t('projects.view_repo')) ?></span>
                            </a>
                        </div>
                    </div>

                    <!-- Project 3: mail-free.eu / .uk -->
                    <div class="project-card">
                        <div>
                            <div class="project-header">
                                <h3><?= e(t('projects.mailfree.title')) ?></h3>
                                <span class="badge badge-accent"><?= e(t('projects.mailfree.badge')) ?></span>
                            </div>

                            <div class="project-tagline"><?= e(t('projects.mailfree.tagline')) ?></div>
                            <p class="project-desc"><?= e(t('projects.mailfree.description')) ?></p>

                            <div class="project-tags">
                                <?php foreach (t_array('projects.mailfree.tags') as $tag): ?>
                                    <span class="project-tag"><?= e($tag) ?></span>
                                <?php endforeach; ?>
                            </div>

                            <ul class="project-features">
                                <?php foreach (t_array('projects.mailfree.features') as $feature): ?>
                                    <li>
                                        <svg fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span><?= e($feature) ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <div class="project-actions">
                            <a href="<?= e(t('projects.mailfree.url_eu')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">
                                <span>mail-free.eu</span>
                            </a>
                            <a href="<?= e(t('projects.mailfree.url_uk')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">
                                <span>mail-free.uk</span>
                            </a>
                            <a href="<?= e(t('projects.mailfree.repo')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline btn-sm">
                                <span><?= e(t('projects.view_repo')) ?></span>
                            </a>
                        </div>
                    </div>

                    <!-- Project 4: static.re -->
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

                            <ul class="project-features">
                                <?php foreach (t_array('projects.staticre.features') as $feature): ?>
                                    <li>
                                        <svg fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span><?= e($feature) ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <div class="project-actions">
                            <a href="<?= e(t('projects.staticre.url')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">
                                <span><?= e(t('projects.view_project')) ?></span>
                            </a>
                            <a href="<?= e(t('projects.staticre.repo')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline btn-sm">
                                <span><?= e(t('projects.view_repo')) ?></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Interactive API Playground -->
        <section id="playground">
            <div class="container">
                <div class="section-header">
                    <div class="section-badge">
                        <span class="badge badge-primary"><?= e(t('playground.badge')) ?></span>
                    </div>
                    <h2 class="section-title"><?= e(t('playground.title')) ?></h2>
                    <p class="section-subtitle"><?= e(t('playground.subtitle')) ?></p>
                </div>

                <div class="playground-wrapper">
                    <!-- Playground Header -->
                    <div class="terminal-header">
                        <div class="window-dots">
                            <span class="dot red"></span>
                            <span class="dot yellow"></span>
                            <span class="dot green"></span>
                        </div>

                        <div class="terminal-tabs">
                            <button type="button" class="tab-btn active" data-lang="curl"><?= e(t('playground.tab_curl')) ?></button>
                            <button type="button" class="tab-btn" data-lang="js"><?= e(t('playground.tab_js')) ?></button>
                            <button type="button" class="tab-btn" data-lang="py"><?= e(t('playground.tab_py')) ?></button>
                            <button type="button" class="tab-btn" data-lang="php"><?= e(t('playground.tab_php')) ?></button>
                        </div>
                    </div>

                    <!-- Playground Body -->
                    <div class="playground-body">
                        <!-- Code Pane -->
                        <div class="code-pane">
                            <div class="pane-header">
                                <span class="pane-title"><?= e(t('playground.endpoint_label')) ?></span>
                                <button type="button" id="btn-copy-code" class="btn btn-secondary btn-sm" style="padding:0.25rem 0.65rem;font-size:0.775rem;">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;height:14px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    <span><?= e(t('playground.btn_copy')) ?></span>
                                </button>
                            </div>
                            <pre class="code-snippet"><code id="playground-code"></code></pre>
                            <div style="margin-top: 1.5rem;">
                                <button type="button" id="btn-run-api" class="btn btn-sm" style="width:100%;">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:16px;height:16px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span><?= e(t('playground.btn_send')) ?></span>
                                </button>
                            </div>
                        </div>

                        <!-- Response Pane -->
                        <div class="response-pane">
                            <div class="pane-header">
                                <span class="pane-title"><?= e(t('playground.response_label')) ?></span>
                                <div style="display:flex;align-items:center;gap:0.75rem;">
                                    <span class="badge badge-primary" style="font-size:0.7rem;padding:0.15rem 0.5rem;"><?= e(t('playground.status_label')) ?></span>
                                    <span style="font-size:0.75rem;font-family:var(--font-mono);color:var(--secondary);"><?= e(t('playground.latency_label')) ?>: <strong id="api-latency-val" style="color:var(--primary);">28ms</strong></span>
                                </div>
                            </div>
                            <pre class="response-json"><code id="playground-json">{
  "status": "success",
  "meta": {
    "api": "getmy.name",
    "version": "v1.4.0",
    "cluster": "eu-central-nbg",
    "execution_time_ms": 28.4
  },
  "data": {
    "username": "fabianternis",
    "name": "Fabian Ternis",
    "headline": "Lead Systems Architect & Full-Stack Engineer",
    "location": "Germany, European Union",
    "bio": "Building sovereign, privacy-centric developer tools and open-source infrastructure under ternis.org & MTEX.dev.",
    "organization": "ternis-edv.de / ternis.dev",
    "skills": [
      "PHP 8.3 / Laravel",
      "TypeScript / React / Vue",
      "Go & Cloud Infrastructure",
      "REST & Headless APIs",
      "Docker & Bare-Metal Linux"
    ]
  }
}</code></pre>
                        </div>
                    </div>

                    <!-- Playground Footer -->
                    <div class="playground-footer">
                        <div style="display:flex;align-items:center;gap:0.5rem;">
                            <svg fill="currentColor" viewBox="0 0 20 20" style="width:16px;height:16px;color:var(--accent);">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <span><?= e(t('playground.tip')) ?></span>
                        </div>
                        <a href="https://getmy.name/api-docs" target="_blank" rel="noopener noreferrer" style="color:var(--primary);font-weight:600;font-size:0.875rem;">
                            getmy.name API-Docs →
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Maintainership & Studio Stewardship -->
        <section id="maintainer">
            <div class="container">
                <div class="maintainer-card">
                    <div class="maintainer-content">
                        <div class="section-badge">
                            <span class="badge badge-primary"><?= e(t('maintainer.badge')) ?></span>
                        </div>
                        <h2><?= e(t('maintainer.title')) ?></h2>
                        <p><?= e(t('maintainer.subtitle')) ?></p>
                        <p><?= e(t('maintainer.desc1')) ?></p>
                        <p><?= e(t('maintainer.desc2')) ?></p>

                        <div class="maintainer-links">
                            <a href="https://ternis.dev" target="_blank" rel="noopener noreferrer" class="btn btn-sm">
                                <span><?= e(t('maintainer.link_ternis_dev')) ?></span>
                            </a>
                            <a href="https://ternis-edv.de" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">
                                <span><?= e(t('maintainer.link_ternis_edv')) ?></span>
                            </a>
                            <a href="https://github.com/ternis-org" target="_blank" rel="noopener noreferrer" class="btn btn-outline btn-sm">
                                <span><?= e(t('maintainer.link_github')) ?></span>
                            </a>
                        </div>
                    </div>

                    <div class="studio-showcase">
                        <div class="studio-item">
                            <div class="studio-avatar">FT</div>
                            <div class="studio-meta">
                                <h4>Fabian Ternis</h4>
                                <p>Lead Architect & FOSS Maintainer</p>
                            </div>
                        </div>
                        <div class="studio-item">
                            <div class="studio-avatar" style="background:var(--secondary);">EDV</div>
                            <div class="studio-meta">
                                <h4>ternis-edv.de</h4>
                                <p>Web Engineering Studio • Germany</p>
                            </div>
                        </div>
                        <div class="studio-item">
                            <div class="studio-avatar" style="background:var(--accent);">MTX</div>
                            <div class="studio-meta">
                                <h4>MTEX.dev</h4>
                                <p>Developer Tooling & Components</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Roadmap -->
        <section id="roadmap">
            <div class="container">
                <div class="section-header">
                    <div class="section-badge">
                        <span class="badge badge-secondary"><?= e(t('roadmap.badge')) ?></span>
                    </div>
                    <h2 class="section-title"><?= e(t('roadmap.title')) ?></h2>
                    <p class="section-subtitle"><?= e(t('roadmap.subtitle')) ?></p>
                </div>

                <div class="roadmap-grid">
                    <div class="roadmap-card">
                        <span class="badge badge-primary"><?= e(t('roadmap.q1_badge')) ?></span>
                        <h3><?= e(t('roadmap.q1_title')) ?></h3>
                        <p><?= e(t('roadmap.q1_desc')) ?></p>
                    </div>

                    <div class="roadmap-card">
                        <span class="badge badge-accent"><?= e(t('roadmap.q2_badge')) ?></span>
                        <h3><?= e(t('roadmap.q2_title')) ?></h3>
                        <p><?= e(t('roadmap.q2_desc')) ?></p>
                    </div>

                    <div class="roadmap-card">
                        <span class="badge badge-primary"><?= e(t('roadmap.q3_badge')) ?></span>
                        <h3><?= e(t('roadmap.q3_title')) ?></h3>
                        <p><?= e(t('roadmap.q3_desc')) ?></p>
                    </div>

                    <div class="roadmap-card">
                        <span class="badge badge-secondary"><?= e(t('roadmap.q4_badge')) ?></span>
                        <h3><?= e(t('roadmap.q4_title')) ?></h3>
                        <p><?= e(t('roadmap.q4_desc')) ?></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section id="faq">
            <div class="container">
                <div class="section-header">
                    <div class="section-badge">
                        <span class="badge badge-primary"><?= e(t('faq.badge')) ?></span>
                    </div>
                    <h2 class="section-title"><?= e(t('faq.title')) ?></h2>
                    <p class="section-subtitle"><?= e(t('faq.subtitle')) ?></p>
                </div>

                <div class="faq-list">
                    <?php foreach (t_array('faq.items') as $idx => $faqItem): ?>
                        <div class="faq-item <?= $idx === 0 ? 'active' : '' ?>">
                            <button type="button" class="faq-question">
                                <span><?= e($faqItem['q'] ?? '') ?></span>
                                <span class="faq-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </span>
                            </button>
                            <div class="faq-answer">
                                <p><?= e($faqItem['a'] ?? '') ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>

    <!-- Sticky Scroll-To-Top Tracker (Sticky inside sections-wrapper, but outside footer) -->
    <div class="scroll-top-tracker">
        <button type="button" id="scroll-to-top" class="scroll-to-top" aria-label="Scroll to top">
            <svg class="progress-ring" width="50" height="50" viewBox="0 0 50 50">
                <circle class="progress-ring-bg" stroke-width="3" fill="transparent" r="20" cx="25" cy="25" />
                <circle class="progress-ring-circle" stroke-width="3" stroke-linecap="round" fill="transparent" r="20" cx="25" cy="25" />
            </svg>
            <svg class="arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
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
                        <a href="https://ternis.dev" target="_blank" rel="noopener noreferrer" class="btn" style="background:var(--bg-color);color:var(--primary);box-shadow:none;">
                            <?= e(t('cta.btn_contact')) ?>
                        </a>
                    </div>
                </div>

                <div class="footer-links-grid">
                    <div class="footer-col">
                        <h4><?= e(t('footer.col_projects')) ?></h4>
                        <ul>
                            <li><a href="https://getmy.name" target="_blank" rel="noopener noreferrer">getmy.name</a></li>
                            <li><a href="https://getmy.name/api-docs" target="_blank" rel="noopener noreferrer">API-Docs</a></li>
                            <li><a href="https://mtex.dev" target="_blank" rel="noopener noreferrer">MTEX.dev</a></li>
                            <li><a href="https://mail-free.eu" target="_blank" rel="noopener noreferrer">mail-free.eu</a></li>
                            <li><a href="https://static.re" target="_blank" rel="noopener noreferrer">static.re</a></li>
                        </ul>
                    </div>

                    <div class="footer-col">
                        <h4><?= e(t('footer.col_ecosystem')) ?></h4>
                        <ul>
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
