<?php

declare(strict_types=1);

/**
 * Wiki search: /{lang}/wiki/search?q=...
 * @var string $lang
 * @var string $query
 * @var array $results
 */

$lang = $lang ?? current_lang();
$query = $query ?? '';
$results = $results ?? [];
?>
<section class="wiki-hero wiki-hero-slim">
    <div class="container" style="max-width: 960px;">
        <nav aria-label="Breadcrumb" class="wiki-crumbs">
            <a href="/<?= e($lang) ?>/wiki"><?= e(t('nav.wiki')) ?></a>
            <span aria-hidden="true">/</span>
            <span aria-current="page"><?= e(t('wiki.search_title')) ?></span>
        </nav>
        <h1><?= e(t('wiki.search_title')) ?></h1>
        <form class="wiki-search" action="/<?= e($lang) ?>/wiki/search" method="get" role="search">
            <input type="search" name="q" value="<?= e($query) ?>" placeholder="<?= e(t('wiki.search_placeholder')) ?>"
                aria-label="<?= e(t('wiki.search_placeholder')) ?>" autocomplete="off" data-wiki-search-input>
            <button type="submit" class="btn btn-sm"><?= e(t('wiki.search_button')) ?></button>
        </form>
    </div>
</section>

<section class="wiki-section">
    <div class="container" style="max-width: 960px;">
        <div class="wiki-search-results" data-wiki-search-results hidden></div>
        <?php if ($query === ''): ?>
            <p class="wiki-muted"><?= e(t('wiki.search_hint')) ?></p>
        <?php elseif ($results === []): ?>
            <p class="wiki-muted"><?= e(t('wiki.search_empty')) ?></p>
        <?php else: ?>
            <p class="wiki-muted"><?= e(t('wiki.search_count', ['count' => (string) count($results)])) ?></p>
            <div class="wiki-list">
                <?php foreach ($results as $entry): ?>
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
