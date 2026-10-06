<?php

declare(strict_types=1);

/**
 * Dedicated Layout for ternis.org Wiki / Documentation
 * @var string $slot
 * @var string $lang
 * @var string|null $title
 * @var string|null $metaDescription
 * @var string|null $metaKeywords
 * @var string|null $canonicalUrl
 * @var string|null $category
 * @var string|null $slug
 */

$lang            = $lang ?? current_lang();
$altLang         = $lang === 'en' ? 'de' : 'en';
$pageTitle       = $title ?? t('wiki.meta_title');
$metaDescription = $metaDescription ?? t('wiki.meta_description');
$metaKeywords    = $metaKeywords ?? 'wiki, docs, networking, homelab, dns, linux, pdo, sql, ternis.org';
$canonical       = $canonicalUrl ?? ('https://ternis.org/' . $lang . '/wiki');
$canonicalPath   = parse_url($canonical, PHP_URL_PATH) ?? ('/' . $lang . '/wiki');
$altUrl          = 'https://ternis.org' . lang_url($altLang, $canonicalPath);
$xDefaultUrl     = 'https://ternis.org' . lang_url('en', $canonicalPath);
$versionShort    = app_version_hash(true);
$allCategories   = wiki_categories_with_counts($lang);
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
    <link rel="alternate" hreflang="<?= e($lang) ?>" href="<?= e($canonical) ?>">
    <link rel="alternate" hreflang="<?= e($altLang) ?>" href="<?= e($altUrl) ?>">
    <link rel="alternate" hreflang="x-default" href="<?= e($xDefaultUrl) ?>">
    <link rel="alternate" type="application/atom+xml" title="ternis.org Wiki Feed" href="/wiki/feed.xml">

    <!-- Open Graph / Twitter -->
    <meta property="og:type" content="<?= !empty($slug) ? 'article' : 'website' ?>">
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
    <meta name="theme-color" content="#c2410c">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="icon" type="image/x-icon" href="/favicon.ico" sizes="32x32">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="manifest" href="/manifest.json">

    <!-- Structured Data (Schema.org JSON-LD) -->
<?php
    $breadcrumbItems = [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Home',
            'item' => 'https://ternis.org/' . $lang,
        ],
        [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => 'Wiki',
            'item' => 'https://ternis.org/' . $lang . '/wiki',
        ],
    ];

    if (!empty($category)) {
        $categoryData = wiki_categories()[$category] ?? [];
        $categoryLabel = $categoryData[$lang] ?? $categoryData['en'] ?? ucfirst((string) $category);
        $breadcrumbItems[] = [
            '@type' => 'ListItem',
            'position' => count($breadcrumbItems) + 1,
            'name' => $categoryLabel,
            'item' => 'https://ternis.org/' . $lang . '/wiki/' . $category,
        ];
    }

    if (!empty($slug) && !empty($article)) {
        $breadcrumbItems[] = [
            '@type' => 'ListItem',
            'position' => count($breadcrumbItems) + 1,
            'name' => $article['title'] ?? $slug,
            'item' => $canonical,
        ];
    }

    $breadcrumbSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $breadcrumbItems,
    ];

    $articleSchema = null;
    if (!empty($article)) {
        $articleSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'TechArticle',
            'headline' => $article['title'],
            'description' => $article['description'],
            'inLanguage' => $lang,
            'mainEntityOfPage' => $canonical,
            'dateModified' => $article['updated'] ?? date('Y-m-d'),
            'author' => [
                '@type' => 'Organization',
                'name' => 'ternis.org',
                'url' => 'https://ternis.org',
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'ternis.org',
                'url' => 'https://ternis.org',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => 'https://ternis.org/favicon.svg',
                ],
            ],
            'keywords' => $article['tags'] ?? [],
        ];
    }

    $websiteSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => 'ternis.org Technical Wiki',
        'url' => 'https://ternis.org/' . $lang . '/wiki',
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => 'https://ternis.org/' . $lang . '/wiki/search?q={search_term_string}',
            'query-input' => 'required name=search_term_string',
        ],
    ];
?>
    <script type="application/ld+json">
    <?= json_encode($breadcrumbSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>
    </script>
<?php if ($articleSchema): ?>
    <script type="application/ld+json">
    <?= json_encode($articleSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>
    </script>
<?php endif; ?>
    <script type="application/ld+json">
    <?= json_encode($websiteSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>
    </script>

    <!-- Dedicated Wiki Stylesheet -->
    <link rel="stylesheet" href="<?= e(asset_url('/assets/css/wiki.css')) ?>">
</head>
<body class="wiki-body">

    <!-- Top Reading Progress Bar -->
    <div id="wiki-progress" class="wiki-progress-bar" aria-hidden="true">
        <div class="wiki-progress-fill"></div>
    </div>

    <!-- Wiki Sticky Top Header -->
    <header class="wiki-topbar">
        <div class="wiki-topbar-inner">
            <div class="wiki-topbar-left">
                <button type="button" class="wiki-icon-btn wiki-menu-toggle" aria-label="Open documentation menu" data-wiki-drawer-toggle>
                    <?= wiki_icon('menu') ?>
                </button>
                <a href="/<?= e($lang) ?>/wiki" class="wiki-brand" aria-label="ternis.org Wiki">
                    <span class="wiki-brand-logo">ternis<span class="wiki-brand-dot">.</span>org</span>
                    <span class="wiki-badge">WIKI</span>
                </a>
                <a href="/<?= e($lang) ?>" class="wiki-nav-link wiki-back-link" title="<?= e(t('wiki.back_to_site')) ?>">
                    <?= wiki_icon('arrow-left', 'wiki-ico-sm') ?>
                    <span><?= e(t('wiki.back_to_site')) ?></span>
                </a>
            </div>

            <!-- Global Search Trigger Bar -->
            <div class="wiki-topbar-center">
                <button type="button" class="wiki-search-trigger" data-wiki-search-trigger aria-label="<?= e(t('wiki.search_modal_placeholder')) ?>">
                    <span class="wiki-search-trigger-lead">
                        <?= wiki_icon('search', 'wiki-ico-sm') ?>
                        <span><?= e(t('wiki.search_modal_placeholder')) ?></span>
                    </span>
                    <span class="wiki-kbd-group">
                        <kbd class="wiki-kbd">Ctrl K</kbd>
                    </span>
                </button>
            </div>

            <div class="wiki-topbar-right">
                <a href="/<?= e($lang) ?>/wiki#categories" class="wiki-nav-link wiki-categories-link">
                    <?= wiki_icon('book', 'wiki-ico-sm') ?>
                    <span><?= e(t('wiki.all_categories')) ?></span>
                </a>

                <!-- Language Switcher (Preserves Current Article) -->
                <div class="wiki-lang-switch" role="group" aria-label="Language selection">
                    <a href="<?= e(lang_url('en', $canonicalPath)) ?>" class="wiki-lang-btn <?= $lang === 'en' ? 'is-active' : '' ?>">EN</a>
                    <a href="<?= e(lang_url('de', $canonicalPath)) ?>" class="wiki-lang-btn <?= $lang === 'de' ? 'is-active' : '' ?>">DE</a>
                </div>

                <!-- GitHub Repo Link -->
                <a href="<?= e(config('repo_url')) ?>" target="_blank" rel="noopener noreferrer" class="wiki-icon-btn" title="GitHub Repository" aria-label="GitHub Repository">
                    <?= wiki_icon('github') ?>
                </a>

                <!-- Theme Toggle -->
                <button type="button" class="wiki-icon-btn wiki-theme-btn" aria-label="Toggle dark/light theme" title="Toggle theme" data-wiki-theme-toggle>
                    <span class="wiki-icon-sun" aria-hidden="true"><?= wiki_icon('sun') ?></span>
                    <span class="wiki-icon-moon" aria-hidden="true"><?= wiki_icon('moon') ?></span>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content Slot -->
    <main id="wiki-main" class="wiki-main-container">
        <?= $slot ?>
    </main>

    <!-- Dedicated Wiki Footer -->
    <footer class="wiki-footer">
        <div class="wiki-footer-inner">
            <div class="wiki-footer-brand-col">
                <div class="wiki-footer-brand">
                    <span class="wiki-brand-logo">ternis<span class="wiki-brand-dot">.</span>org</span>
                    <span class="wiki-badge">WIKI</span>
                </div>
                <p class="wiki-footer-tagline"><?= e(t('wiki.home_subtitle')) ?></p>
                <div class="wiki-footer-badges">
                    <span class="wiki-chip-badge"><?= wiki_icon('sparkles', 'wiki-ico-sm') ?> <?= e(t('wiki.stats_categories')) ?></span>
                    <span class="wiki-chip-badge"><?= wiki_icon('book', 'wiki-ico-sm') ?> <?= e(t('wiki.stats_articles')) ?></span>
                    <span class="wiki-chip-badge"><?= wiki_icon('lock', 'wiki-ico-sm') ?> <?= e(t('wiki.stats_opensource')) ?></span>
                </div>
            </div>

            <div class="wiki-footer-links-col">
                <strong class="wiki-footer-heading"><?= e(t('wiki.all_categories')) ?></strong>
                <ul class="wiki-footer-list">
                    <?php foreach (array_slice($allCategories, 0, 8, true) as $cSlug => $cMeta): ?>
                        <li>
                            <a href="/<?= e($lang) ?>/wiki/<?= e($cSlug) ?>">
                                <?= wiki_icon($cMeta['icon'], 'wiki-ico-sm') ?>
                                <span><?= e($lang === 'de' ? $cMeta['de'] : $cMeta['en']) ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="wiki-footer-links-col">
                <strong class="wiki-footer-heading">ternis.org</strong>
                <ul class="wiki-footer-list">
                    <li>
                        <a href="/<?= e($lang) ?>">
                            <?= wiki_icon('home', 'wiki-ico-sm') ?>
                            <span><?= e(t('wiki.back_to_site')) ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= e(config('repo_url')) ?>" target="_blank" rel="noopener noreferrer">
                            <?= wiki_icon('github', 'wiki-ico-sm') ?>
                            <span>GitHub</span>
                        </a>
                    </li>
                    <li>
                        <a href="/<?= e($lang) ?>/legal/imprint">
                            <?= wiki_icon('link', 'wiki-ico-sm') ?>
                            <span><?= e(t('nav.imprint')) ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="/<?= e($lang) ?>/legal/privacy">
                            <?= wiki_icon('lock', 'wiki-ico-sm') ?>
                            <span><?= e(t('nav.privacy')) ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="/<?= e($lang) ?>/legal/license">
                            <?= wiki_icon('table', 'wiki-ico-sm') ?>
                            <span><?= e(t('nav.license')) ?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="wiki-footer-bottom">
            <div class="wiki-footer-bottom-inner">
                <p>&copy; <?= date('Y') ?> ternis.org <span class="wiki-sep-dot"><?= wiki_icon('dot', 'wiki-ico-xs') ?></span> European Digital Sovereignty <span class="wiki-sep-dot"><?= wiki_icon('dot', 'wiki-ico-xs') ?></span> Zero Trackers</p>
                <div class="wiki-footer-kbd-hint">
                    <?= wiki_icon('search', 'wiki-ico-sm') ?>
                    <span><?= e(t('wiki.keyboard_hint')) ?></span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating Back to Top Button -->
    <button type="button" id="wiki-back-to-top" class="wiki-back-to-top" aria-label="<?= e(t('wiki.back_to_top')) ?>" title="<?= e(t('wiki.back_to_top')) ?>">
        <?= wiki_icon('arrow-up') ?>
    </button>

    <!-- Global Command Palette / Search Modal -->
    <div id="wiki-search-modal" class="wiki-modal" role="dialog" aria-modal="true" aria-label="<?= e(t('wiki.search_modal_placeholder')) ?>" hidden>
        <div class="wiki-modal-backdrop" data-wiki-modal-close></div>
        <div class="wiki-modal-card">
            <div class="wiki-modal-head">
                <span class="wiki-modal-search-ico"><?= wiki_icon('search') ?></span>
                <input type="search" class="wiki-modal-input" placeholder="<?= e(t('wiki.search_modal_placeholder')) ?>"
                    aria-label="<?= e(t('wiki.search_modal_placeholder')) ?>" autocomplete="off" spellcheck="false" data-wiki-modal-input>
                <button type="button" class="wiki-modal-close-btn" data-wiki-modal-close aria-label="Close search">
                    <?= wiki_icon('x') ?>
                </button>
            </div>
            <div class="wiki-modal-body" data-wiki-modal-results>
                <div class="wiki-modal-empty">
                    <p class="wiki-modal-hint"><?= e(t('wiki.search_hint')) ?></p>
                </div>
            </div>
            <div class="wiki-modal-foot">
                <span class="wiki-modal-shortcut"><kbd class="wiki-kbd">Up / Down</kbd> Navigate</span>
                <span class="wiki-modal-shortcut"><kbd class="wiki-kbd">Enter</kbd> Select</span>
                <span class="wiki-modal-shortcut"><kbd class="wiki-kbd">ESC</kbd> Close</span>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Drawer -->
    <div id="wiki-mobile-drawer-backdrop" class="wiki-drawer-backdrop" data-wiki-drawer-close hidden></div>
    <aside id="wiki-mobile-drawer" class="wiki-drawer" aria-label="Mobile Navigation" hidden>
        <div class="wiki-drawer-header">
            <a href="/<?= e($lang) ?>/wiki" class="wiki-brand">
                <span class="wiki-brand-logo">ternis<span class="wiki-brand-dot">.</span>org</span>
                <span class="wiki-badge">WIKI</span>
            </a>
            <button type="button" class="wiki-icon-btn" data-wiki-drawer-close aria-label="Close menu">
                <?= wiki_icon('x') ?>
            </button>
        </div>
        <div class="wiki-drawer-content">
            <button type="button" class="wiki-search-trigger wiki-search-trigger-mobile" data-wiki-search-trigger>
                <?= wiki_icon('search', 'wiki-ico-sm') ?>
                <span><?= e(t('wiki.search_modal_placeholder')) ?></span>
            </button>
            <div class="wiki-drawer-nav">
                <a href="/<?= e($lang) ?>" class="wiki-drawer-link">
                    <?= wiki_icon('home') ?>
                    <span><?= e(t('wiki.back_to_site')) ?></span>
                </a>
                <a href="/<?= e($lang) ?>/wiki" class="wiki-drawer-link">
                    <?= wiki_icon('book') ?>
                    <span><?= e(t('wiki.home_title')) ?></span>
                </a>
            </div>
            <div class="wiki-drawer-section">
                <span class="wiki-drawer-label"><?= e(t('wiki.all_categories')) ?></span>
                <ul class="wiki-drawer-cats">
                    <?php foreach ($allCategories as $cSlug => $cMeta): ?>
                        <li>
                            <a href="/<?= e($lang) ?>/wiki/<?= e($cSlug) ?>" class="wiki-drawer-cat-link <?= ($category ?? '') === $cSlug ? 'is-active' : '' ?>">
                                <span class="wiki-drawer-cat-icon"><?= wiki_icon($cMeta['icon']) ?></span>
                                <span class="wiki-drawer-cat-title"><?= e($lang === 'de' ? $cMeta['de'] : $cMeta['en']) ?></span>
                                <span class="wiki-drawer-cat-count"><?= e((string) $cMeta['count']) ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="wiki-drawer-footer">
                <div class="wiki-lang-switch wiki-lang-switch-full">
                    <a href="<?= e(lang_url('en', $canonicalPath)) ?>" class="wiki-lang-btn <?= $lang === 'en' ? 'is-active' : '' ?>">English (EN)</a>
                    <a href="<?= e(lang_url('de', $canonicalPath)) ?>" class="wiki-lang-btn <?= $lang === 'de' ? 'is-active' : '' ?>">Deutsch (DE)</a>
                </div>
            </div>
        </div>
    </aside>

    <!-- Wiki Script -->
    <script src="<?= e(asset_url('/assets/js/wiki.js')) ?>" defer></script>
</body>
</html>
