<?php

declare(strict_types=1);

/**
 * Wiki article: /{lang}/wiki/{category}/{slug}
 * @var string $lang
 * @var string $category
 * @var array $article
 * @var array|null $prev
 * @var array|null $next
 * @var array $relatedArticles  resolved article arrays
 * @var array $categoryMeta
 */

$lang = $lang ?? current_lang();
$catTitle = $lang === 'de' ? ($categoryMeta['de'] ?? $category) : ($categoryMeta['en'] ?? $category);
$editUrl = rtrim(app_repo_url(), '/') . '/blob/master/content/wiki/'
    . ($article['fallback_lang'] ?? $lang) . '/' . $category . '/' . $article['slug'] . '.md';
?>
<section class="wiki-article-head">
    <div class="wiki-wrap">
        <nav aria-label="Breadcrumb" class="wiki-crumbs">
            <a href="/<?= e($lang) ?>"><?= e(t('error.back_home')) ?></a>
            <span aria-hidden="true">›</span>
            <a href="/<?= e($lang) ?>/wiki"><?= e(t('nav.wiki')) ?></a>
            <span aria-hidden="true">›</span>
            <a href="/<?= e($lang) ?>/wiki/<?= e($category) ?>"><?= e($catTitle) ?></a>
            <span aria-hidden="true">›</span>
            <span aria-current="page"><?= e($article['title']) ?></span>
        </nav>
        <?php if (!empty($article['fallback_lang'])): ?>
            <div class="wiki-fallback" role="status">
                <?= e(t('wiki.fallback_notice')) ?>
                <a href="<?= e(lang_url('en', '/' . $lang . '/wiki/' . $category . '/' . $article['slug'])) ?>">English</a>
            </div>
        <?php endif; ?>
        <p class="wiki-kicker"><span class="wiki-kicker-ico"><?= wiki_icon($categoryMeta['icon'] ?? 'globe') ?></span><?= e($catTitle) ?></p>
        <h1><?= e($article['title']) ?></h1>
        <?php if ($article['description'] !== ''): ?>
            <p class="wiki-lead"><?= e($article['description']) ?></p>
        <?php endif; ?>
        <div class="wiki-meta">
            <span><?= e(t('wiki.reading_time', ['minutes' => (string) $article['reading_minutes']])) ?></span>
            <span aria-hidden="true">·</span>
            <span><?= e(t('wiki.last_updated')) ?>: <?= e($article['updated']) ?></span>
            <?php foreach ($article['tags'] as $tag): ?>
                <span class="wiki-tag"><?= e($tag) ?></span>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<div class="wiki-wrap wiki-wrap-wide wiki-article-wrap">
    <?php if ($article['toc'] !== []): ?>
        <details class="wiki-toc-mobile">
            <summary><?= e(t('wiki.on_this_page')) ?></summary>
            <ol>
                <?php foreach ($article['toc'] as $item): ?>
                    <li class="wiki-toc-lvl-<?= e((string) $item['level']) ?>">
                        <a href="#<?= e($item['id']) ?>"><?= e($item['text']) ?></a>
                    </li>
                <?php endforeach; ?>
            </ol>
        </details>
    <?php endif; ?>

    <div class="wiki-article-cols">
        <article class="wiki-prose">
            <?= $article['html'] ?>
            <footer class="wiki-article-foot">
                <a href="<?= e($editUrl) ?>" target="_blank" rel="noopener noreferrer" class="wiki-btn wiki-btn-ghost">
                    <?= e(t('wiki.edit_on_github')) ?>
                </a>
            </footer>

            <?php if ($relatedArticles !== []): ?>
                <h2 class="wiki-h2" id="related"><?= e(t('wiki.related')) ?></h2>
                <ol class="wiki-list">
                    <?php foreach ($relatedArticles as $rel): ?>
                        <li>
                            <a class="wiki-row" href="/<?= e($lang) ?>/wiki/<?= e($rel['category']) ?>/<?= e($rel['slug']) ?>">
                                <span class="wiki-row-cat"><?= e($rel['category']) ?></span>
                                <span class="wiki-row-main"><strong><?= e($rel['title']) ?></strong></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ol>
            <?php endif; ?>

            <nav class="wiki-pager" aria-label="More articles">
                <?php if ($prev !== null): ?>
                    <a href="/<?= e($lang) ?>/wiki/<?= e($category) ?>/<?= e($prev['slug']) ?>" rel="prev">
                        <small>&larr; <?= e(t('wiki.prev_article')) ?></small>
                        <strong><?= e($prev['title']) ?></strong>
                    </a>
                <?php endif; ?>
                <?php if ($next !== null): ?>
                    <a href="/<?= e($lang) ?>/wiki/<?= e($category) ?>/<?= e($next['slug']) ?>" rel="next">
                        <small><?= e(t('wiki.next_article')) ?> &rarr;</small>
                        <strong><?= e($next['title']) ?></strong>
                    </a>
                <?php endif; ?>
            </nav>
        </article>

        <?php if ($article['toc'] !== []): ?>
            <aside class="wiki-toc" aria-label="<?= e(t('wiki.on_this_page')) ?>">
                <strong><?= e(t('wiki.on_this_page')) ?></strong>
                <ol>
                    <?php foreach ($article['toc'] as $item): ?>
                        <li class="wiki-toc-lvl-<?= e((string) $item['level']) ?>">
                            <a href="#<?= e($item['id']) ?>"><?= e($item['text']) ?></a>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </aside>
        <?php endif; ?>
    </div>
</div>

<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Article",
    "headline": <?= json_encode($article['title'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>,
    "description": <?= json_encode($article['description'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>,
    "author": { "@type": "Organization", "name": "ternis.org", "url": "https://ternis.org" },
    "dateModified": <?= json_encode($article['updated'], JSON_UNESCAPED_SLASHES) ?>,
    "mainEntityOfPage": "https://ternis.org/<?= e($lang) ?>/wiki/<?= e($category) ?>/<?= e($article['slug']) ?>"
}
</script>
