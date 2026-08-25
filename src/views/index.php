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
<html lang="<?= e($lang) ?>" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- SEO Primary Meta Tags -->
    <title><?= e(t('meta.title')) ?></title>
    <meta name="title" content="<?= e(t('meta.title')) ?>">
    <meta name="description" content="<?= e(t('meta.description')) ?>">
    <meta name="keywords" content="<?= e(t('meta.keywords')) ?>">
    <meta name="author" content="<?= e(t('meta.author')) ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= e($canonicalUrl) ?>">
    <link rel="alternate" hreflang="<?= e($altLang) ?>" href="<?= e($altUrl) ?>">
    <link rel="alternate" hreflang="x-default" href="https://ternis.org/en">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= e($canonicalUrl) ?>">
    <meta property="og:title" content="<?= e(t('meta.og_title')) ?>">
    <meta property="og:description" content="<?= e(t('meta.og_description')) ?>">
    <meta property="og:image" content="https://ternis.org/og.jpg">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= e($canonicalUrl) ?>">
    <meta property="twitter:title" content="<?= e(t('meta.og_title')) ?>">
    <meta property="twitter:description" content="<?= e(t('meta.og_description')) ?>">
    <meta property="twitter:image" content="https://ternis.org/og.jpg">

    <!-- Theme Color & PWA -->
    <meta name="theme-color" content="#08090d">
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="manifest" href="/manifest.json">

    <!-- Fonts & Critical Stylesheet -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="<?= e(asset_url('/assets/css/app.css')) ?>">

    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "ternis.org",
        "url": "https://ternis.org",
        "logo": "https://ternis.org/assets/logo.png",
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

    <!-- Ambient Glowing Blobs -->
    <div class="ambient-glow" aria-hidden="true">
        <div class="glow-orb-1"></div>
        <div class="glow-orb-2"></div>
        <div class="glow-orb-3"></div>
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
                <span><?= e(t('nav.brand')) ?></span>
                <span class="status-dot" title="Systems Operational"></span>
            </a>

            <nav class="nav-links">
                <a href="#about" class="nav-link"><?= e(t('nav.about')) ?></a>
                <a href="#projects" class="nav-link"><?= e(t('nav.projects')) ?></a>
                <a href="#playground" class="nav-link"><?= e(t('nav.playground')) ?></a>
                <a href="#maintainer" class="nav-link"><?= e(t('nav.ecosystem')) ?></a>
                <a href="#roadmap" class="nav-link"><?= e(t('nav.roadmap')) ?></a>
                <a href="#opensource" class="nav-link"><?= e(t('nav.opensource')) ?></a>
                <a href="#faq" class="nav-link"><?= e(t('nav.faq')) ?></a>
            </nav>

            <div class="nav-actions">
                <!-- Language Switcher -->
                <div class="lang-switcher">
                    <a href="/en" class="lang-btn <?= $lang === 'en' ? 'active' : '' ?>">EN</a>
                    <a href="/de" class="lang-btn <?= $lang === 'de' ? 'active' : '' ?>">DE</a>
                </div>

                <!-- Dark/Light Theme Toggle -->
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
                <button type="button" class="btn-icon mobile-toggle" aria-label="Toggle navigation menu" aria-expanded="false">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer -->
        <div class="mobile-drawer">
            <a href="#about" class="nav-link"><?= e(t('nav.about')) ?></a>
            <a href="#projects" class="nav-link"><?= e(t('nav.projects')) ?></a>
            <a href="#playground" class="nav-link"><?= e(t('nav.playground')) ?></a>
            <a href="#maintainer" class="nav-link"><?= e(t('nav.ecosystem')) ?></a>
            <a href="#roadmap" class="nav-link"><?= e(t('nav.roadmap')) ?></a>
            <a href="#opensource" class="nav-link"><?= e(t('nav.opensource')) ?></a>
            <a href="#faq" class="nav-link"><?= e(t('nav.faq')) ?></a>
            <a href="/<?= e($lang) ?>/legal/imprint" class="nav-link"><?= e(t('nav.imprint')) ?></a>
            <a href="/<?= e($lang) ?>/legal/privacy" class="nav-link"><?= e(t('nav.privacy')) ?></a>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="hero-content">
                    <div class="hero-badge-wrap">
                        <span class="badge badge-cyan">
                            <svg fill="currentColor" viewBox="0 0 20 20" style="width:14px;height:14px;">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <?= e(t('hero.badge')) ?>
                        </span>
                    </div>

                    <h1 class="hero-title">
                        <?= e(t('hero.title_line1')) ?><br>
                        <span class="gradient-text"><?= e(t('hero.title_line2')) ?></span>
                    </h1>

                    <p class="hero-desc">
                        <?= e(t('hero.description')) ?>
                    </p>

                    <div class="hero-actions">
                        <a href="#projects" class="btn btn-primary">
                            <span><?= e(t('hero.cta_projects')) ?></span>
                            <span class="btn-icon-right">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </span>
                        </a>
                        <a href="#playground" class="btn btn-secondary">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px;color:var(--brand-cyan);">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <span><?= e(t('hero.cta_playground')) ?></span>
                        </a>
                        <a href="https://github.com/ternis-org" target="_blank" rel="noopener noreferrer" class="btn btn-outline">
                            <svg fill="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px;">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"></path>
                            </svg>
                            <span><?= e(t('hero.cta_github')) ?></span>
                        </a>
                    </div>

                    <!-- Hero Stats -->
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
            </div>
        </section>

        <!-- Mission & Philosophy -->
        <section id="about">
            <div class="container">
                <div class="section-header">
                    <div class="section-badge">
                        <span class="badge badge-teal"><?= e(t('mission.badge')) ?></span>
                    </div>
                    <h2 class="section-title"><?= e(t('mission.title')) ?></h2>
                    <p class="section-subtitle"><?= e(t('mission.description')) ?></p>
                </div>

                <div class="mission-grid">
                    <div class="mission-card">
                        <div class="card-icon-wrap">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                            </svg>
                        </div>
                        <h3><?= e(t('mission.card1_title')) ?></h3>
                        <p><?= e(t('mission.card1_desc')) ?></p>
                    </div>

                    <div class="mission-card">
                        <div class="card-icon-wrap" style="color:var(--brand-teal);background:rgba(16,185,129,0.1);border-color:rgba(16,185,129,0.2);">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3><?= e(t('mission.card2_title')) ?></h3>
                        <p><?= e(t('mission.card2_desc')) ?></p>
                    </div>

                    <div class="mission-card">
                        <div class="card-icon-wrap" style="color:var(--brand-indigo);background:rgba(99,102,241,0.1);border-color:rgba(99,102,241,0.2);">
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
                        <span class="badge badge-cyan"><?= e(t('projects.badge')) ?></span>
                    </div>
                    <h2 class="section-title"><?= e(t('projects.title')) ?></h2>
                    <p class="section-subtitle"><?= e(t('projects.subtitle')) ?></p>
                </div>

                <div class="projects-grid">
                    <!-- Project 1: getmy.name -->
                    <div class="project-card">
                        <div>
                            <div class="project-header">
                                <div class="project-title-area">
                                    <div class="project-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <h3><?= e(t('projects.getmyname.title')) ?></h3>
                                </div>
                                <span class="badge badge-teal"><?= e(t('projects.getmyname.badge')) ?></span>
                            </div>

                            <div class="project-tagline"><?= e(t('projects.getmyname.tagline')) ?></div>
                            <p class="project-desc"><?= e(t('projects.getmyname.description')) ?></p>

                            <div class="project-tags">
                                <?php foreach (t('projects.getmyname.tags') as $tag): ?>
                                    <span class="project-tag"><?= e($tag) ?></span>
                                <?php endforeach; ?>
                            </div>

                            <ul class="project-features">
                                <?php foreach (t('projects.getmyname.features') as $feature): ?>
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
                            <a href="<?= e(t('projects.getmyname.url')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-sm">
                                <span><?= e(t('projects.view_project')) ?></span>
                                <span class="btn-icon-right">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;height:14px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                </span>
                            </a>
                            <a href="#playground" class="btn btn-secondary btn-sm">
                                <span><?= e(t('nav.playground')) ?></span>
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
                                <div class="project-title-area">
                                    <div class="project-icon" style="color:var(--brand-indigo);">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                        </svg>
                                    </div>
                                    <h3><?= e(t('projects.mtex.title')) ?></h3>
                                </div>
                                <span class="badge badge-teal"><?= e(t('projects.mtex.badge')) ?></span>
                            </div>

                            <div class="project-tagline" style="color:var(--brand-indigo);"><?= e(t('projects.mtex.tagline')) ?></div>
                            <p class="project-desc"><?= e(t('projects.mtex.description')) ?></p>

                            <div class="project-tags">
                                <?php foreach (t('projects.mtex.tags') as $tag): ?>
                                    <span class="project-tag"><?= e($tag) ?></span>
                                <?php endforeach; ?>
                            </div>

                            <ul class="project-features">
                                <?php foreach (t('projects.mtex.features') as $feature): ?>
                                    <li>
                                        <svg fill="currentColor" viewBox="0 0 20 20" style="color:var(--brand-indigo);">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span><?= e($feature) ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <div class="project-actions">
                            <a href="<?= e(t('projects.mtex.url')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-sm" style="background:var(--gradient-hero);">
                                <span><?= e(t('projects.view_project')) ?></span>
                                <span class="btn-icon-right">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;height:14px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                </span>
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
                                <div class="project-title-area">
                                    <div class="project-icon" style="color:var(--brand-amber);">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <h3><?= e(t('projects.mailfree.title')) ?></h3>
                                </div>
                                <span class="badge badge-amber"><?= e(t('projects.mailfree.badge')) ?></span>
                            </div>

                            <div class="project-tagline" style="color:var(--brand-amber);"><?= e(t('projects.mailfree.tagline')) ?></div>
                            <p class="project-desc"><?= e(t('projects.mailfree.description')) ?></p>

                            <div class="project-tags">
                                <?php foreach (t('projects.mailfree.tags') as $tag): ?>
                                    <span class="project-tag"><?= e($tag) ?></span>
                                <?php endforeach; ?>
                            </div>

                            <ul class="project-features">
                                <?php foreach (t('projects.mailfree.features') as $feature): ?>
                                    <li>
                                        <svg fill="currentColor" viewBox="0 0 20 20" style="color:var(--brand-amber);">
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
                                <div class="project-title-area">
                                    <div class="project-icon" style="color:var(--brand-cyan);">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                        </svg>
                                    </div>
                                    <h3><?= e(t('projects.staticre.title')) ?></h3>
                                </div>
                                <span class="badge badge-amber"><?= e(t('projects.staticre.badge')) ?></span>
                            </div>

                            <div class="project-tagline"><?= e(t('projects.staticre.tagline')) ?></div>
                            <p class="project-desc"><?= e(t('projects.staticre.description')) ?></p>

                            <div class="project-tags">
                                <?php foreach (t('projects.staticre.tags') as $tag): ?>
                                    <span class="project-tag"><?= e($tag) ?></span>
                                <?php endforeach; ?>
                            </div>

                            <ul class="project-features">
                                <?php foreach (t('projects.staticre.features') as $feature): ?>
                                    <li>
                                        <svg fill="currentColor" viewBox="0 0 20 20" style="color:var(--brand-cyan);">
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
                        <span class="badge badge-indigo"><?= e(t('playground.badge')) ?></span>
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
                                <button type="button" id="btn-run-api" class="btn btn-primary btn-sm" style="width:100%;">
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
                                    <span class="badge badge-teal" style="font-size:0.7rem;padding:0.15rem 0.5rem;"><?= e(t('playground.status_label')) ?></span>
                                    <span style="font-size:0.75rem;font-family:var(--font-mono);color:var(--text-muted);"><?= e(t('playground.latency_label')) ?>: <strong id="api-latency-val" style="color:var(--brand-cyan);">28ms</strong></span>
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
                        <div class="playground-tip">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <span><?= e(t('playground.tip')) ?></span>
                        </div>
                        <a href="https://getmy.name" target="_blank" rel="noopener noreferrer" style="color:var(--brand-cyan);font-weight:600;font-size:0.825rem;">
                            getmy.name Docs →
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
                            <span class="badge badge-cyan"><?= e(t('maintainer.badge')) ?></span>
                        </div>
                        <h2><?= e(t('maintainer.title')) ?></h2>
                        <p><?= e(t('maintainer.subtitle')) ?></p>
                        <p><?= e(t('maintainer.desc1')) ?></p>
                        <p><?= e(t('maintainer.desc2')) ?></p>

                        <div class="maintainer-links">
                            <a href="https://ternis.dev" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-sm">
                                <span><?= e(t('maintainer.link_ternis_dev')) ?></span>
                                <span class="btn-icon-right">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;height:14px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                </span>
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
                            <div class="studio-avatar" style="background:var(--gradient-hero);">EDV</div>
                            <div class="studio-meta">
                                <h4>ternis-edv.de</h4>
                                <p>Web Engineering Studio • Germany</p>
                            </div>
                        </div>
                        <div class="studio-item">
                            <div class="studio-avatar" style="background:rgba(16,185,129,0.2);color:var(--brand-teal);">MTX</div>
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
                        <span class="badge badge-teal"><?= e(t('roadmap.badge')) ?></span>
                    </div>
                    <h2 class="section-title"><?= e(t('roadmap.title')) ?></h2>
                    <p class="section-subtitle"><?= e(t('roadmap.subtitle')) ?></p>
                </div>

                <div class="roadmap-grid">
                    <div class="roadmap-card">
                        <div class="roadmap-badge-wrap">
                            <span class="badge badge-teal"><?= e(t('roadmap.q1_badge')) ?></span>
                        </div>
                        <h3><?= e(t('roadmap.q1_title')) ?></h3>
                        <p><?= e(t('roadmap.q1_desc')) ?></p>
                    </div>

                    <div class="roadmap-card">
                        <div class="roadmap-badge-wrap">
                            <span class="badge badge-amber"><?= e(t('roadmap.q2_badge')) ?></span>
                        </div>
                        <h3><?= e(t('roadmap.q2_title')) ?></h3>
                        <p><?= e(t('roadmap.q2_desc')) ?></p>
                    </div>

                    <div class="roadmap-card">
                        <div class="roadmap-badge-wrap">
                            <span class="badge badge-cyan"><?= e(t('roadmap.q3_badge')) ?></span>
                        </div>
                        <h3><?= e(t('roadmap.q3_title')) ?></h3>
                        <p><?= e(t('roadmap.q3_desc')) ?></p>
                    </div>

                    <div class="roadmap-card">
                        <div class="roadmap-badge-wrap">
                            <span class="badge badge-indigo"><?= e(t('roadmap.q4_badge')) ?></span>
                        </div>
                        <h3><?= e(t('roadmap.q4_title')) ?></h3>
                        <p><?= e(t('roadmap.q4_desc')) ?></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Open Source & Community Hub -->
        <section id="opensource">
            <div class="container">
                <div class="section-header">
                    <div class="section-badge">
                        <span class="badge badge-cyan"><?= e(t('opensource.badge')) ?></span>
                    </div>
                    <h2 class="section-title"><?= e(t('opensource.title')) ?></h2>
                    <p class="section-subtitle"><?= e(t('opensource.subtitle')) ?></p>
                </div>

                <div class="mission-grid">
                    <div class="mission-card">
                        <div class="card-icon-wrap">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3><?= e(t('opensource.card_code_title')) ?></h3>
                        <p><?= e(t('opensource.card_code_desc')) ?></p>
                    </div>

                    <div class="mission-card">
                        <div class="card-icon-wrap" style="color:var(--brand-teal);background:rgba(16,185,129,0.1);border-color:rgba(16,185,129,0.2);">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                            </svg>
                        </div>
                        <h3><?= e(t('opensource.card_issues_title')) ?></h3>
                        <p><?= e(t('opensource.card_issues_desc')) ?></p>
                    </div>

                    <div class="mission-card">
                        <div class="card-icon-wrap" style="color:var(--brand-indigo);background:rgba(99,102,241,0.1);border-color:rgba(99,102,241,0.2);">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                            </svg>
                        </div>
                        <h3><?= e(t('opensource.card_host_title')) ?></h3>
                        <p><?= e(t('opensource.card_host_desc')) ?></p>
                    </div>
                </div>

                <div style="text-align:center;margin-top:3.5rem;">
                    <a href="https://github.com/ternis-org" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                        <svg fill="currentColor" viewBox="0 0 24 24" style="width:20px;height:20px;">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"></path>
                        </svg>
                        <span><?= e(t('opensource.btn_github_org')) ?></span>
                    </a>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section id="faq">
            <div class="container">
                <div class="section-header">
                    <div class="section-badge">
                        <span class="badge badge-teal"><?= e(t('faq.badge')) ?></span>
                    </div>
                    <h2 class="section-title"><?= e(t('faq.title')) ?></h2>
                    <p class="section-subtitle"><?= e(t('faq.subtitle')) ?></p>
                </div>

                <div class="faq-list">
                    <?php foreach (t('faq.items') as $idx => $faqItem): ?>
                        <div class="faq-item <?= $idx === 0 ? 'active' : '' ?>">
                            <button type="button" class="faq-question">
                                <span><?= e($faqItem['q']) ?></span>
                                <span class="faq-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </span>
                            </button>
                            <div class="faq-answer">
                                <p><?= e($faqItem['a']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section">
            <div class="container">
                <div class="cta-box">
                    <h2><?= e(t('cta.title')) ?></h2>
                    <p><?= e(t('cta.subtitle')) ?></p>
                    <div class="cta-buttons">
                        <a href="https://github.com/ternis-org" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                            <svg fill="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px;">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"></path>
                            </svg>
                            <span><?= e(t('cta.btn_github')) ?></span>
                        </a>
                        <a href="https://ternis.dev" target="_blank" rel="noopener noreferrer" class="btn btn-secondary">
                            <span><?= e(t('cta.btn_contact')) ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <h3>ternis.org</h3>
                    <p><?= e(t('footer.description')) ?></p>
                </div>

                <div class="footer-col">
                    <h4><?= e(t('footer.col_projects')) ?></h4>
                    <ul>
                        <li><a href="https://getmy.name" target="_blank" rel="noopener noreferrer">getmy.name</a></li>
                        <li><a href="https://mtex.dev" target="_blank" rel="noopener noreferrer">MTEX.dev</a></li>
                        <li><a href="https://mail-free.eu" target="_blank" rel="noopener noreferrer">mail-free.eu</a></li>
                        <li><a href="https://mail-free.uk" target="_blank" rel="noopener noreferrer">mail-free.uk</a></li>
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
                    <h4><?= e(t('footer.col_community')) ?></h4>
                    <ul>
                        <li><a href="https://github.com/ternis-org" target="_blank" rel="noopener noreferrer">GitHub</a></li>
                        <li><a href="https://github.com/ternis-org/getmy-name" target="_blank" rel="noopener noreferrer">Contribute</a></li>
                        <li><a href="https://github.com/sponsors/fternis" target="_blank" rel="noopener noreferrer">Sponsor</a></li>
                        <li><a href="/sitemap.xml">Sitemap.xml</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4><?= e(t('footer.col_legal')) ?></h4>
                    <ul>
                        <li><a href="/<?= e($lang) ?>/legal/imprint"><?= e(t('nav.imprint')) ?></a></li>
                        <li><a href="/<?= e($lang) ?>/legal/privacy"><?= e(t('nav.privacy')) ?></a></li>
                        <li><a href="/<?= e($lang) ?>/legal/license"><?= e(t('nav.license')) ?></a></li>
                    </ul>
                </div>
            </div>

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

    <!-- Scripts -->
    <script src="<?= e(asset_url('/assets/js/app.js')) ?>" defer></script>
</body>
</html>
