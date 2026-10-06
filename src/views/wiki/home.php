<?php

declare(strict_types=1);

/**
 * Wiki home: /{lang}/wiki (Rendered inside layouts/main.php)
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
<section class="wiki-hero">
    <div class="container" style="max-width: 960px;">
        <nav aria-label="Breadcrumb" class="wiki-crumbs">
            <a href="/<?= e($lang) ?>">&larr; <?= e(t('error.back_home')) ?></a>
            <span aria-hidden="true">/</span>
            <span aria-current="page"><?= e(t('nav.wiki')) ?></span>
        </nav>
        <h1><?= e(t('wiki.home_title')) ?></h1>
        <p class="wiki-lead"><?= e(t('wiki.home_subtitle')) ?></p>
        <form class="wiki-search" action="/<?= e($lang) ?>/wiki/search" method="get" role="search">
            <input type="search" name="q" value="<?= e($query) ?>" placeholder="<?= e(t('wiki.search_placeholder')) ?>"
                aria-label="<?= e(t('wiki.search_placeholder')) ?>" autocomplete="off" data-wiki-search-input>
            <button type="submit" class="btn btn-sm"><?= e(t('wiki.search_button')) ?></button>
        </form>
        <div class="wiki-search-results" data-wiki-search-results hidden></div>
    </div>
</section>

<section class="wiki-section">
    <div class="container" style="max-width: 1080px;">
        <div class="wiki-grid">
            <?php foreach ($categories as $slug => $cat): ?>
                <a class="wiki-card" href="/<?= e($lang) ?>/wiki/<?= e($slug) ?>">
                    <span class="wiki-card-icon" aria-hidden="true"><?= e($cat['icon']) ?></span>
                    <h3><?= e($lang === 'de' ? $cat['de'] : $cat['en']) ?></h3>
                    <p><?= e($lang === 'de' ? $cat['desc_de'] : $cat['desc_en']) ?></p>
                    <span class="wiki-card-count">
                        <?= e((string) $cat['count']) ?> <?= e(t('wiki.articles')) ?>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if ($featured !== []): ?>
            <h2 class="wiki-h2"><?= e(t('wiki.featured')) ?></h2>
            <div class="wiki-list">
                <?php foreach ($featured as $entry): ?>
                    <a class="wiki-row" href="<?= e($entry['url']) ?>">
                        <span class="wiki-row-cat"><?= e($entry['category']) ?></span>
                        <span class="wiki-row-main">
                            <strong><?= e($entry['title']) ?></strong>
                            <small><?= e($entry['description']) ?></small>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
