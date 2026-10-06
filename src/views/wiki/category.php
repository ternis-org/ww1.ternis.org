<?php

declare(strict_types=1);

/**
 * Wiki category index: /{lang}/wiki/{category}
 * @var string $lang
 * @var string $category
 * @var array $meta  category meta
 * @var array $articles
 * @var array $categories all categories with counts
 */

$lang = $lang ?? current_lang();
$categories = $categories ?? wiki_categories_with_counts($lang);
$title = $lang === 'de' ? ($meta['de'] ?? $category) : ($meta['en'] ?? $category);
$desc = $lang === 'de' ? ($meta['desc_de'] ?? '') : ($meta['desc_en'] ?? '');
?>
<div class="wiki-page wiki-category-page">
    <div class="wiki-wrap wiki-wrap-wide">
        <!-- Breadcrumbs -->
        <nav aria-label="Breadcrumb" class="wiki-crumbs">
            <a href="/<?= e($lang) ?>" class="wiki-crumb-link">
                <?= wiki_icon('home', 'wiki-crumb-icon') ?>
                <span><?= e(t('wiki.back_to_site')) ?></span>
            </a>
            <span class="wiki-crumb-sep" aria-hidden="true"><?= wiki_icon('chevron-right') ?></span>
            <a href="/<?= e($lang) ?>/wiki" class="wiki-crumb-link"><?= e(t('nav.wiki')) ?></a>
            <span class="wiki-crumb-sep" aria-hidden="true"><?= wiki_icon('chevron-right') ?></span>
            <span class="wiki-crumb-current" aria-current="page"><?= e($title) ?></span>
        </nav>

        <div class="wiki-doc-layout">
            <!-- Left Sidebar Navigation -->
            <aside class="wiki-doc-sidebar" aria-label="<?= e(t('wiki.all_categories')) ?>">
                <div class="wiki-sidebar-box">
                    <span class="wiki-sidebar-heading">
                        <?= wiki_icon('book', 'wiki-ico-sm') ?>
                        <span><?= e(t('wiki.all_categories')) ?></span>
                    </span>
                    <ul class="wiki-sidebar-list">
                        <?php foreach ($categories as $sSlug => $sMeta): ?>
                            <li>
                                <a href="/<?= e($lang) ?>/wiki/<?= e($sSlug) ?>" 
                                   class="wiki-sidebar-item <?= $sSlug === $category ? 'is-active' : '' ?>">
                                    <span class="wiki-sidebar-item-ico"><?= wiki_icon($sMeta['icon']) ?></span>
                                    <span class="wiki-sidebar-item-label"><?= e($lang === 'de' ? $sMeta['de'] : $sMeta['en']) ?></span>
                                    <span class="wiki-sidebar-item-badge"><?= e((string) $sMeta['count']) ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </aside>

            <!-- Main Content Area -->
            <section class="wiki-doc-main">
                <header class="wiki-cat-header">
                    <div class="wiki-cat-badge">
                        <?= wiki_icon($meta['icon'] ?? 'globe') ?>
                    </div>
                    <div class="wiki-cat-info">
                        <div class="wiki-kicker">
                            <span class="wiki-kicker-ico"><?= wiki_icon('tag', 'wiki-ico-sm') ?></span>
                            <span>Topic Overview</span>
                        </div>
                        <h1 class="wiki-cat-title"><?= e($title) ?></h1>
                        <p class="wiki-lead"><?= e($desc) ?></p>
                        <div class="wiki-cat-meta-bar">
                            <span class="wiki-badge-pill">
                                <?= wiki_icon('book', 'wiki-ico-xs') ?>
                                <span><?= count($articles) ?> <?= e(t('wiki.articles')) ?></span>
                            </span>
                        </div>
                    </div>
                </header>

                <!-- Filter Articles in this category -->
                <?php if (count($articles) > 3): ?>
                    <div class="wiki-filter-bar">
                        <span class="wiki-filter-ico"><?= wiki_icon('search', 'wiki-ico-sm') ?></span>
                        <input type="text" class="wiki-filter-input" placeholder="<?= e(t('wiki.filter_articles')) ?>" 
                            data-wiki-category-filter aria-label="<?= e(t('wiki.filter_articles')) ?>">
                    </div>
                <?php endif; ?>

                <!-- Article List Cards -->
                <?php if ($articles === []): ?>
                    <div class="wiki-empty-state">
                        <div class="wiki-empty-ico"><?= wiki_icon('info') ?></div>
                        <p class="wiki-empty-text"><?= e(t('wiki.empty_category')) ?></p>
                        <a href="/<?= e($lang) ?>/wiki" class="wiki-btn wiki-btn-ghost">
                            <?= wiki_icon('arrow-left', 'wiki-btn-ico') ?>
                            <span><?= e(t('nav.wiki')) ?></span>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="wiki-articles-list" data-wiki-article-list>
                        <?php foreach ($articles as $a): ?>
                            <a class="wiki-article-card" href="/<?= e($lang) ?>/wiki/<?= e($category) ?>/<?= e($a['slug']) ?>" data-article-item>
                                <div class="wiki-article-card-main">
                                    <h2 class="wiki-article-card-title"><?= e($a['title']) ?></h2>
                                    <?php if (!empty($a['description'])): ?>
                                        <p class="wiki-article-card-desc"><?= e($a['description']) ?></p>
                                    <?php endif; ?>

                                    <div class="wiki-article-card-meta">
                                        <span class="wiki-meta-item">
                                            <?= wiki_icon('clock', 'wiki-meta-ico') ?>
                                            <span><?= e(t('wiki.reading_time', ['minutes' => (string) $a['reading_minutes']])) ?></span>
                                        </span>
                                        <span class="wiki-meta-item">
                                            <?= wiki_icon('calendar', 'wiki-meta-ico') ?>
                                            <span><?= e($a['updated']) ?></span>
                                        </span>
                                        <?php if (!empty($a['tags'])): ?>
                                            <div class="wiki-meta-tags">
                                                <?php foreach (array_slice($a['tags'], 0, 3) as $t): ?>
                                                    <span class="wiki-tag">
                                                        <?= wiki_icon('tag', 'wiki-tag-ico') ?>
                                                        <span><?= e($t) ?></span>
                                                    </span>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="wiki-article-card-arrow" aria-hidden="true">
                                    <?= wiki_icon('arrow-right') ?>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </div>
</div>

<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        { "@type": "ListItem", "position": 1, "name": "Home", "item": "https://ternis.org/<?= e($lang) ?>" },
        { "@type": "ListItem", "position": 2, "name": "<?= e(t('nav.wiki')) ?>", "item": "https://ternis.org/<?= e($lang) ?>/wiki" },
        { "@type": "ListItem", "position": 3, "name": "<?= e($title) ?>", "item": "https://ternis.org/<?= e($lang) ?>/wiki/<?= e($category) ?>" }
    ]
}
</script>
