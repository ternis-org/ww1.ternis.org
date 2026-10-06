<?php

declare(strict_types=1);

/**
 * Wiki article: /{lang}/wiki/{category}/{slug} (Rendered inside layouts/wiki.php)
 * @var string $lang
 * @var string $category
 * @var string $slug
 * @var array $article
 * @var array|null $prev
 * @var array|null $next
 * @var array $relatedArticles  resolved article arrays
 * @var array $categoryMeta
 * @var array $categoryArticles list of all articles in category
 * @var array $categories       all categories with counts
 */

$lang = $lang ?? current_lang();
$catTitle = $lang === 'de' ? ($categoryMeta['de'] ?? $category) : ($categoryMeta['en'] ?? $category);
$categoryArticles = $categoryArticles ?? [];
$editUrl = rtrim(app_repo_url(), '/') . '/blob/master/content/wiki/'
    . ($article['fallback_lang'] ?? $lang) . '/' . $category . '/' . $article['slug'] . '.md';
?>
<div class="wiki-page wiki-article-page">
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
            <a href="/<?= e($lang) ?>/wiki/<?= e($category) ?>" class="wiki-crumb-link"><?= e($catTitle) ?></a>
            <span class="wiki-crumb-sep" aria-hidden="true"><?= wiki_icon('chevron-right') ?></span>
            <span class="wiki-crumb-current" aria-current="page"><?= e($article['title']) ?></span>
        </nav>

        <div class="wiki-article-layout">
            <!-- Left Sidebar: Category Articles Tree -->
            <aside class="wiki-sidebar-nav" aria-label="Category navigation">
                <div class="wiki-sidebar-box">
                    <a href="/<?= e($lang) ?>/wiki/<?= e($category) ?>" class="wiki-sidebar-cat-head">
                        <span class="wiki-sidebar-cat-ico"><?= wiki_icon($categoryMeta['icon'] ?? 'globe') ?></span>
                        <span class="wiki-sidebar-cat-name"><?= e($catTitle) ?></span>
                    </a>
                    <span class="wiki-sidebar-section-title"><?= e(t('wiki.in_this_category')) ?></span>
                    <ul class="wiki-sidebar-article-list">
                        <?php foreach ($categoryArticles as $ca): ?>
                            <li>
                                <a href="/<?= e($lang) ?>/wiki/<?= e($category) ?>/<?= e($ca['slug']) ?>" 
                                   class="wiki-sidebar-article-link <?= $ca['slug'] === $slug ? 'is-active' : '' ?>">
                                    <span class="wiki-sidebar-dot" aria-hidden="true">
                                        <?= wiki_icon($ca['slug'] === $slug ? 'check' : 'dot', 'wiki-sidebar-dot-ico') ?>
                                    </span>
                                    <span class="wiki-sidebar-article-title"><?= e($ca['title']) ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <div class="wiki-sidebar-nav-footer">
                        <a href="/<?= e($lang) ?>/wiki#categories" class="wiki-sidebar-back-link">
                            <?= wiki_icon('arrow-left', 'wiki-ico-xs') ?>
                            <span><?= e(t('wiki.all_categories')) ?></span>
                        </a>
                    </div>
                </div>
            </aside>

            <!-- Center Column: Article Content -->
            <div class="wiki-article-center">
                <article class="wiki-article-main">
                    <!-- Fallback Notice -->
                    <?php if (!empty($article['fallback_lang'])): ?>
                        <div class="wiki-notice wiki-notice-info" role="status">
                            <span class="wiki-notice-ico"><?= wiki_icon('info') ?></span>
                            <div class="wiki-notice-text">
                                <?= e(t('wiki.fallback_notice')) ?>
                                <a href="<?= e(lang_url('en', '/' . $lang . '/wiki/' . $category . '/' . $article['slug'])) ?>">English</a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Article Header -->
                    <header class="wiki-article-header">
                        <div class="wiki-kicker">
                            <a href="/<?= e($lang) ?>/wiki/<?= e($category) ?>" class="wiki-kicker-link">
                                <span class="wiki-kicker-ico"><?= wiki_icon($categoryMeta['icon'] ?? 'globe') ?></span>
                                <span><?= e($catTitle) ?></span>
                            </a>
                        </div>
                        <h1 class="wiki-article-title"><?= e($article['title']) ?></h1>
                        <?php if ($article['description'] !== ''): ?>
                            <p class="wiki-article-lead"><?= e($article['description']) ?></p>
                        <?php endif; ?>

                        <!-- Metadata row -->
                        <div class="wiki-article-meta-bar">
                            <div class="wiki-meta-chips">
                                <span class="wiki-chip-item" title="Estimated reading time">
                                    <?= wiki_icon('clock', 'wiki-meta-ico') ?>
                                    <span><?= e(t('wiki.reading_time', ['minutes' => (string) $article['reading_minutes']])) ?></span>
                                </span>
                                <span class="wiki-chip-item" title="Last updated">
                                    <?= wiki_icon('calendar', 'wiki-meta-ico') ?>
                                    <span><?= e(t('wiki.last_updated')) ?>: <?= e($article['updated']) ?></span>
                                </span>
                            </div>

                            <div class="wiki-meta-actions">
                                <button type="button" class="wiki-meta-action-btn" data-wiki-copy-link 
                                    data-url="<?= e($canonicalUrl ?? ('https://ternis.org/' . $lang . '/wiki/' . $category . '/' . $slug)) ?>"
                                    title="<?= e(t('wiki.copy_link')) ?>">
                                    <span class="wiki-copy-link-ico"><?= wiki_icon('link', 'wiki-ico-xs') ?></span>
                                    <span class="wiki-copy-link-check"><?= wiki_icon('check', 'wiki-ico-xs') ?></span>
                                    <span class="wiki-copy-link-label"><?= e(t('wiki.copy_link')) ?></span>
                                </button>
                                <a href="<?= e($editUrl) ?>" target="_blank" rel="noopener noreferrer" 
                                   class="wiki-meta-action-btn" title="<?= e(t('wiki.edit_on_github')) ?>">
                                    <?= wiki_icon('github', 'wiki-ico-xs') ?>
                                    <span>GitHub</span>
                                </a>
                            </div>
                        </div>

                        <?php if (!empty($article['tags'])): ?>
                            <div class="wiki-tags-bar">
                                <?php foreach ($article['tags'] as $tag): ?>
                                    <a href="/<?= e($lang) ?>/wiki/search?q=<?= urlencode($tag) ?>" class="wiki-tag">
                                        <?= wiki_icon('tag', 'wiki-tag-ico') ?>
                                        <span><?= e($tag) ?></span>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </header>

                    <!-- Mobile Table of Contents Accordion -->
                    <?php if ($article['toc'] !== []): ?>
                        <details class="wiki-mobile-toc">
                            <summary class="wiki-mobile-toc-summary">
                                <span class="wiki-mobile-toc-title">
                                    <?= wiki_icon('toc', 'wiki-ico-sm') ?>
                                    <span><?= e(t('wiki.on_this_page')) ?></span>
                                </span>
                                <span class="wiki-mobile-toc-chevron"><?= wiki_icon('chevron-down', 'wiki-ico-sm') ?></span>
                            </summary>
                            <ol class="wiki-mobile-toc-list">
                                <?php foreach ($article['toc'] as $item): ?>
                                    <li class="wiki-toc-lvl-<?= e((string) $item['level']) ?>">
                                        <a href="#<?= e($item['id']) ?>"><?= e($item['text']) ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ol>
                        </details>
                    <?php endif; ?>

                    <!-- Prose Markdown Content -->
                    <div class="wiki-prose">
                        <?= $article['html'] ?>
                    </div>

                    <!-- Article Action Footer -->
                    <footer class="wiki-article-footer">
                        <div class="wiki-article-action-bar">
                            <a href="<?= e($editUrl) ?>" target="_blank" rel="noopener noreferrer" class="wiki-btn wiki-btn-ghost">
                                <?= wiki_icon('github', 'wiki-btn-ico') ?>
                                <span><?= e(t('wiki.edit_on_github')) ?></span>
                            </a>
                            <button type="button" class="wiki-btn wiki-btn-ghost" data-wiki-copy-link 
                                data-url="<?= e($canonicalUrl ?? ('https://ternis.org/' . $lang . '/wiki/' . $category . '/' . $slug)) ?>">
                                <span class="wiki-copy-link-ico"><?= wiki_icon('link', 'wiki-btn-ico') ?></span>
                                <span class="wiki-copy-link-check"><?= wiki_icon('check', 'wiki-btn-ico') ?></span>
                                <span class="wiki-copy-link-label"><?= e(t('wiki.copy_link')) ?></span>
                            </button>
                        </div>

                        <!-- Previous / Next Article Navigation Cards -->
                        <nav class="wiki-pager-grid" aria-label="Article navigation">
                            <?php if ($prev !== null): ?>
                                <a href="/<?= e($lang) ?>/wiki/<?= e($category) ?>/<?= e($prev['slug']) ?>" class="wiki-pager-card wiki-pager-prev" rel="prev">
                                    <span class="wiki-pager-hint">
                                        <?= wiki_icon('arrow-left', 'wiki-pager-ico') ?>
                                        <span><?= e(t('wiki.prev_article')) ?></span>
                                    </span>
                                    <strong class="wiki-pager-title"><?= e($prev['title']) ?></strong>
                                </a>
                            <?php else: ?>
                                <div class="wiki-pager-empty"></div>
                            <?php endif; ?>

                            <?php if ($next !== null): ?>
                                <a href="/<?= e($lang) ?>/wiki/<?= e($category) ?>/<?= e($next['slug']) ?>" class="wiki-pager-card wiki-pager-next" rel="next">
                                    <span class="wiki-pager-hint">
                                        <span><?= e(t('wiki.next_article')) ?></span>
                                        <?= wiki_icon('arrow-right', 'wiki-pager-ico') ?>
                                    </span>
                                    <strong class="wiki-pager-title"><?= e($next['title']) ?></strong>
                                </a>
                            <?php endif; ?>
                        </nav>

                        <!-- Related Articles -->
                        <?php if ($relatedArticles !== []): ?>
                            <div class="wiki-related-box">
                                <h3 class="wiki-related-heading">
                                    <?= wiki_icon('sparkles', 'wiki-ico-sm') ?>
                                    <span><?= e(t('wiki.related')) ?></span>
                                </h3>
                                <div class="wiki-related-grid">
                                    <?php foreach ($relatedArticles as $rel): ?>
                                        <a class="wiki-related-card" href="/<?= e($lang) ?>/wiki/<?= e($rel['category']) ?>/<?= e($rel['slug']) ?>">
                                            <span class="wiki-badge-cat">
                                                <?= wiki_icon($categories[$rel['category']]['icon'] ?? 'book', 'wiki-ico-xs') ?>
                                                <span><?= e($rel['category']) ?></span>
                                            </span>
                                            <strong class="wiki-related-title"><?= e($rel['title']) ?></strong>
                                            <?php if (!empty($rel['description'])): ?>
                                                <p class="wiki-related-desc"><?= e($rel['description']) ?></p>
                                            <?php endif; ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </footer>
                </article>
            </div>

            <!-- Right Column: Sticky Table of Contents -->
            <?php if ($article['toc'] !== []): ?>
                <aside class="wiki-toc-sidebar" aria-label="<?= e(t('wiki.on_this_page')) ?>">
                    <div class="wiki-toc-sticky-box">
                        <div class="wiki-toc-header">
                            <?= wiki_icon('toc', 'wiki-ico-sm') ?>
                            <span><?= e(t('wiki.on_this_page')) ?></span>
                        </div>
                        <nav class="wiki-toc-nav" data-wiki-toc-nav>
                            <ol class="wiki-toc-tree">
                                <?php foreach ($article['toc'] as $item): ?>
                                    <li class="wiki-toc-item wiki-toc-item-lvl-<?= e((string) $item['level']) ?>">
                                        <a href="#<?= e($item['id']) ?>" class="wiki-toc-link" data-toc-target="<?= e($item['id']) ?>">
                                            <?= e($item['text']) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ol>
                        </nav>

                        <div class="wiki-toc-quick-actions">
                            <a href="#wiki-progress" class="wiki-toc-top-link" data-wiki-scroll-top>
                                <?= wiki_icon('arrow-up', 'wiki-ico-xs') ?>
                                <span><?= e(t('wiki.back_to_top')) ?></span>
                            </a>
                        </div>
                    </div>
                </aside>
            <?php endif; ?>
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
        { "@type": "ListItem", "position": 3, "name": "<?= e($catTitle) ?>", "item": "https://ternis.org/<?= e($lang) ?>/wiki/<?= e($category) ?>" },
        { "@type": "ListItem", "position": 4, "name": <?= json_encode($article['title'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>, "item": "https://ternis.org/<?= e($lang) ?>/wiki/<?= e($category) ?>/<?= e($article['slug']) ?>" }
    ]
}
</script>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Article",
    "headline": <?= json_encode($article['title'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>,
    "description": <?= json_encode($article['description'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>,
    "author": { "@type": "Organization", "name": "ternis.org", "url": "https://ternis.org" },
    "publisher": { "@type": "Organization", "name": "ternis.org", "logo": { "@type": "ImageObject", "url": "https://ternis.org/favicon.svg" } },
    "dateModified": "<?= date('c', $article['source_mtime']) ?>",
    "mainEntityOfPage": "https://ternis.org/<?= e($lang) ?>/wiki/<?= e($category) ?>/<?= e($article['slug']) ?>"
}
</script>
