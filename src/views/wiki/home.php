<?php

declare(strict_types=1);

/**
 * Wiki home: /{lang}/wiki (Rendered inside layouts/wiki.php)
 * @var string $lang
 * @var array $categories  slug => meta + count
 * @var array $featured    flat index entries
 * @var string $query
 */

$lang = $lang ?? current_lang();
$categories = $categories ?? [];
$featured = $featured ?? [];
$query = $query ?? '';
?>
<div class="wiki-page wiki-home-page">
    <!-- Hero Section -->
    <section class="wiki-hero">
        <div class="wiki-wrap wiki-hero-inner">
            <nav aria-label="Breadcrumb" class="wiki-crumbs">
                <a href="/<?= e($lang) ?>" class="wiki-crumb-link">
                    <?= wiki_icon('home', 'wiki-crumb-icon') ?>
                    <span><?= e(t('wiki.back_to_site')) ?></span>
                </a>
                <span class="wiki-crumb-sep" aria-hidden="true"><?= wiki_icon('chevron-right') ?></span>
                <span class="wiki-crumb-current" aria-current="page"><?= e(t('nav.wiki')) ?></span>
            </nav>

            <div class="wiki-kicker">
                <span class="wiki-kicker-ico"><?= wiki_icon('book') ?></span>
                <span><?= e(t('wiki.kicker')) ?></span>
            </div>

            <h1 class="wiki-hero-title"><?= e(t('wiki.home_title')) ?></h1>
            <p class="wiki-lead"><?= e(t('wiki.home_subtitle')) ?></p>

            <!-- Search Form with Instant Dropdown -->
            <div class="wiki-search-box">
                <form class="wiki-search" action="/<?= e($lang) ?>/wiki/search" method="get" role="search">
                    <span class="wiki-search-ico"><?= wiki_icon('search') ?></span>
                    <input type="search" name="q" value="<?= e($query) ?>" placeholder="<?= e(t('wiki.search_modal_placeholder')) ?>"
                        aria-label="<?= e(t('wiki.search_placeholder')) ?>" autocomplete="off" spellcheck="false" data-wiki-search-input>
                    <span class="wiki-search-kbd"><kbd class="wiki-kbd">/</kbd></span>
                    <button type="submit" class="wiki-btn wiki-btn-primary">
                        <?= wiki_icon('search', 'wiki-btn-ico') ?>
                        <span><?= e(t('wiki.search_button')) ?></span>
                    </button>
                </form>
                <div class="wiki-search-results" data-wiki-search-results hidden></div>
            </div>

            <!-- Fast Category Pills -->
            <div class="wiki-quick-pills">
                <span class="wiki-quick-label"><?= e(t('wiki.in_this_category')) ?>:</span>
                <div class="wiki-pills-list">
                    <?php 
                    $pills = ['dns', 'linux', 'homelab', 'networking', 'php', 'sql', 'security'];
                    foreach ($pills as $pSlug): 
                        if (!isset($categories[$pSlug])) continue;
                        $pMeta = $categories[$pSlug];
                    ?>
                        <a href="/<?= e($lang) ?>/wiki/<?= e($pSlug) ?>" class="wiki-pill">
                            <?= wiki_icon($pMeta['icon'], 'wiki-pill-ico') ?>
                            <span><?= e($lang === 'de' ? $pMeta['de'] : $pMeta['en']) ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Ticker -->
    <section class="wiki-stats-bar">
        <div class="wiki-wrap wiki-stats-inner">
            <div class="wiki-stat-item">
                <span class="wiki-stat-icon"><?= wiki_icon('sparkles') ?></span>
                <div class="wiki-stat-text">
                    <strong>16</strong>
                    <span><?= e(t('wiki.stats_categories')) ?></span>
                </div>
            </div>
            <div class="wiki-stat-item">
                <span class="wiki-stat-icon"><?= wiki_icon('book') ?></span>
                <div class="wiki-stat-text">
                    <strong>50+</strong>
                    <span><?= e(t('wiki.stats_articles')) ?></span>
                </div>
            </div>
            <div class="wiki-stat-item">
                <span class="wiki-stat-icon"><?= wiki_icon('lock') ?></span>
                <div class="wiki-stat-text">
                    <strong>100%</strong>
                    <span><?= e(t('wiki.stats_opensource')) ?></span>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Grid Section -->
    <section class="wiki-section" id="categories">
        <div class="wiki-wrap wiki-wrap-wide">
            <div class="wiki-section-header">
                <div>
                    <h2 class="wiki-h2"><?= e(t('wiki.all_categories')) ?></h2>
                    <p class="wiki-section-sub"><?= e(t('wiki.home_subtitle')) ?></p>
                </div>
            </div>

            <div class="wiki-grid">
                <?php foreach ($categories as $slug => $cat): ?>
                    <a class="wiki-card" href="/<?= e($lang) ?>/wiki/<?= e($slug) ?>">
                        <div class="wiki-card-top">
                            <span class="wiki-card-ico"><?= wiki_icon($cat['icon']) ?></span>
                            <span class="wiki-card-count">
                                <?= wiki_icon('book', 'wiki-card-count-ico') ?>
                                <span><?= e((string) $cat['count']) ?> <?= e(t('wiki.articles')) ?></span>
                            </span>
                        </div>
                        <h3 class="wiki-card-title"><?= e($lang === 'de' ? $cat['de'] : $cat['en']) ?></h3>
                        <p class="wiki-card-desc"><?= e($lang === 'de' ? $cat['desc_de'] : $cat['desc_en']) ?></p>
                        <span class="wiki-card-foot">
                            <span class="wiki-card-link-text"><?= e(t('wiki.browse_all')) ?></span>
                            <span class="wiki-card-go" aria-hidden="true"><?= wiki_icon('arrow-right') ?></span>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Featured Guides Section -->
            <?php if ($featured !== []): ?>
                <div class="wiki-featured-wrap">
                    <div class="wiki-section-header">
                        <div>
                            <h2 class="wiki-h2"><?= e(t('wiki.featured')) ?></h2>
                            <p class="wiki-section-sub"><?= e(t('wiki.search_hint')) ?></p>
                        </div>
                    </div>

                    <div class="wiki-featured-grid">
                        <?php foreach ($featured as $entry): ?>
                            <?php 
                            $catIcon = $categories[$entry['category']]['icon'] ?? 'book';
                            ?>
                            <a class="wiki-featured-card" href="<?= e($entry['url']) ?>">
                                <div class="wiki-featured-head">
                                    <span class="wiki-badge-cat">
                                        <?= wiki_icon($catIcon, 'wiki-ico-xs') ?>
                                        <span><?= e($entry['category']) ?></span>
                                    </span>
                                    <span class="wiki-featured-arrow" aria-hidden="true"><?= wiki_icon('arrow-right') ?></span>
                                </div>
                                <h3 class="wiki-featured-title"><?= e($entry['title']) ?></h3>
                                <p class="wiki-featured-desc"><?= e($entry['description']) ?></p>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- GitHub Open Source Contribution Banner -->
            <div class="wiki-banner-contribute">
                <div class="wiki-banner-icon"><?= wiki_icon('github') ?></div>
                <div class="wiki-banner-body">
                    <h3><?= e(t('wiki.edit_on_github')) ?></h3>
                    <p><?= e(t('about.card1_desc')) ?></p>
                </div>
                <a href="<?= e(config('repo_url')) ?>" target="_blank" rel="noopener noreferrer" class="wiki-btn wiki-btn-ghost">
                    <?= wiki_icon('github', 'wiki-btn-ico') ?>
                    <span>GitHub Repository</span>
                </a>
            </div>
        </div>
    </section>
</div>
