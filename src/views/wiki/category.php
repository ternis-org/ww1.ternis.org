<?php

declare(strict_types=1);

/**
 * Wiki category index: /{lang}/wiki/{category}
 * @var string $lang
 * @var string $category
 * @var array $meta  category meta
 * @var array $articles
 */

$lang = $lang ?? current_lang();
$title = $lang === 'de' ? ($meta['de'] ?? $category) : ($meta['en'] ?? $category);
$desc = $lang === 'de' ? ($meta['desc_de'] ?? '') : ($meta['desc_en'] ?? '');
?>
<section class="wiki-hero wiki-hero-slim">
    <div class="container" style="max-width: 960px;">
        <nav aria-label="Breadcrumb" class="wiki-crumbs">
            <a href="/<?= e($lang) ?>"><?= e(t('error.back_home')) ?></a>
            <span aria-hidden="true">/</span>
            <a href="/<?= e($lang) ?>/wiki"><?= e(t('nav.wiki')) ?></a>
            <span aria-hidden="true">/</span>
            <span aria-current="page"><?= e($title) ?></span>
        </nav>
        <h1><span aria-hidden="true"><?= e($meta['icon'] ?? '') ?></span> <?= e($title) ?></h1>
        <p class="wiki-lead"><?= e($desc) ?></p>
    </div>
</section>

<section class="wiki-section">
    <div class="container" style="max-width: 960px;">
        <?php if ($articles === []): ?>
            <div class="wiki-empty">
                <p><?= e(t('wiki.empty_category')) ?></p>
                <a href="/<?= e($lang) ?>/wiki" class="btn btn-secondary btn-sm">&larr; <?= e(t('nav.wiki')) ?></a>
            </div>
        <?php else: ?>
            <div class="wiki-list">
                <?php foreach ($articles as $a): ?>
                    <a class="wiki-row" href="/<?= e($lang) ?>/wiki/<?= e($category) ?>/<?= e($a['slug']) ?>">
                        <span class="wiki-row-main">
                            <strong><?= e($a['title']) ?></strong>
                            <small><?= e($a['description']) ?></small>
                        </span>
                        <span class="wiki-row-meta"><?= e($a['reading_minutes']) ?> min</span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
