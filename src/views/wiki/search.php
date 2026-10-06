<?php

declare(strict_types=1);

/**
 * Wiki search: /{lang}/wiki/search?q=... (Rendered inside layouts/wiki.php)
 * @var string $lang
 * @var string $query
 * @var array $results
 * @var array $categories
 */

$lang = $lang ?? current_lang();
$query = $query ?? '';
$results = $results ?? [];
$categories = $categories ?? wiki_categories_with_counts($lang);
?>
<div class="wiki-page wiki-search-page">
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
            <span class="wiki-crumb-current" aria-current="page"><?= e(t('wiki.search_title')) ?></span>
        </nav>

        <section class="wiki-search-hero">
            <div class="wiki-kicker">
                <span class="wiki-kicker-ico"><?= wiki_icon('search', 'wiki-ico-sm') ?></span>
                <span><?= e(t('wiki.kicker')) ?></span>
            </div>
            <h1 class="wiki-hero-title"><?= e(t('wiki.search_title')) ?></h1>

            <form class="wiki-search wiki-search-wide" action="/<?= e($lang) ?>/wiki/search" method="get" role="search">
                <span class="wiki-search-ico"><?= wiki_icon('search') ?></span>
                <input type="search" name="q" value="<?= e($query) ?>" placeholder="<?= e(t('wiki.search_modal_placeholder')) ?>"
                    aria-label="<?= e(t('wiki.search_placeholder')) ?>" autocomplete="off" autofocus data-wiki-search-input>
                <button type="submit" class="wiki-btn wiki-btn-primary">
                    <?= wiki_icon('search', 'wiki-btn-ico') ?>
                    <span><?= e(t('wiki.search_button')) ?></span>
                </button>
            </form>
            <div class="wiki-search-results" data-wiki-search-results hidden></div>
        </section>

        <section class="wiki-search-results-section">
            <?php if ($query === ''): ?>
                <div class="wiki-empty-state">
                    <div class="wiki-empty-ico"><?= wiki_icon('search') ?></div>
                    <p class="wiki-empty-text"><?= e(t('wiki.search_hint')) ?></p>
                </div>
            <?php elseif ($results === []): ?>
                <div class="wiki-empty-state">
                    <div class="wiki-empty-ico"><?= wiki_icon('info') ?></div>
                    <p class="wiki-empty-text"><?= e(t('wiki.search_empty')) ?></p>
                    <a href="/<?= e($lang) ?>/wiki" class="wiki-btn wiki-btn-ghost">
                        <?= wiki_icon('arrow-left', 'wiki-btn-ico') ?>
                        <span><?= e(t('wiki.all_categories')) ?></span>
                    </a>
                </div>
            <?php else: ?>
                <div class="wiki-search-status-bar">
                    <span class="wiki-badge-pill">
                        <?= wiki_icon('sparkles', 'wiki-ico-xs') ?>
                        <span><?= e(t('wiki.search_count', ['count' => (string) count($results)])) ?></span>
                    </span>
                </div>

                <div class="wiki-articles-list">
                    <?php foreach ($results as $entry): ?>
                        <?php 
                        $catIcon = $categories[$entry['category']]['icon'] ?? 'book';
                        ?>
                        <a class="wiki-article-card" href="<?= e($entry['url']) ?>">
                            <div class="wiki-article-card-main">
                                <div class="wiki-card-meta-top">
                                    <span class="wiki-badge-cat">
                                        <?= wiki_icon($catIcon, 'wiki-ico-xs') ?>
                                        <span><?= e($entry['category']) ?></span>
                                    </span>
                                </div>
                                <h2 class="wiki-article-card-title"><?= e($entry['title']) ?></h2>
                                <?php if (!empty($entry['description'])): ?>
                                    <p class="wiki-article-card-desc"><?= e($entry['description']) ?></p>
                                <?php endif; ?>
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
