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
    <div class="wiki-wrap">
        <nav aria-label="Breadcrumb" class="wiki-crumbs">
            <a href="/<?= e($lang) ?>"><?= e(t('error.back_home')) ?></a>
            <span aria-hidden="true">›</span>
            <a href="/<?= e($lang) ?>/wiki"><?= e(t('nav.wiki')) ?></a>
            <span aria-hidden="true">›</span>
            <span aria-current="page"><?= e($title) ?></span>
        </nav>
        <div class="wiki-cat-head">
            <span class="wiki-card-ico wiki-card-ico-lg"><?= wiki_icon($meta['icon'] ?? 'globe') ?></span>
            <h1><?= e($title) ?></h1>
        </div>
        <p class="wiki-lead"><?= e($desc) ?></p>
    </div>
</section>

<section class="wiki-section">
    <div class="wiki-wrap">
        <?php if ($articles === []): ?>
            <div class="wiki-empty">
                <p><?= e(t('wiki.empty_category')) ?></p>
                <a href="/<?= e($lang) ?>/wiki" class="wiki-btn wiki-btn-ghost">&larr; <?= e(t('nav.wiki')) ?></a>
            </div>
        <?php else: ?>
            <ol class="wiki-list">
                <?php foreach ($articles as $a): ?>
                    <li>
                        <a class="wiki-row" href="/<?= e($lang) ?>/wiki/<?= e($category) ?>/<?= e($a['slug']) ?>">
                            <span class="wiki-row-main">
                                <strong><?= e($a['title']) ?></strong>
                                <small><?= e($a['description']) ?></small>
                            </span>
                            <span class="wiki-row-meta"><?= e($a['reading_minutes']) ?> min</span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ol>
        <?php endif; ?>
    </div>
</section>

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
