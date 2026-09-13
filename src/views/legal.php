<?php

declare(strict_types=1);

/**
 * Legal document view template (Rendered inside layouts/main.php)
 * @var string $lang
 * @var string $slug
 * @var array $doc
 */

$lang = $lang ?? current_lang();
$slug = $slug ?? 'imprint';
$doc = $doc ?? [];
?>
<section class="legal-section">
    <div class="container" style="max-width: 880px;">
        <!-- Breadcrumbs -->
        <nav aria-label="Breadcrumb" style="margin-bottom: 2rem; display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; color: var(--secondary);">
            <a href="/<?= e($lang) ?>">&larr; <?= e(t('error.back_home')) ?></a>
            <span aria-hidden="true">/</span>
            <span><?= e(t('nav.legal')) ?></span>
            <span aria-hidden="true">/</span>
            <span style="color: var(--primary); font-weight: 600;" aria-current="page"><?= e($doc['title'] ?? '') ?></span>
        </nav>

        <!-- Legal Nav Tabs -->
        <div style="display: flex; gap: 0.75rem; margin-bottom: 2.5rem; flex-wrap: wrap;" role="tablist">
            <a href="/<?= e($lang) ?>/legal/imprint" class="btn <?= $slug === 'imprint' ? '' : 'btn-secondary' ?> btn-sm" role="tab" aria-selected="<?= $slug === 'imprint' ? 'true' : 'false' ?>">
                <?= e(t('nav.imprint')) ?>
            </a>
            <a href="/<?= e($lang) ?>/legal/privacy" class="btn <?= $slug === 'privacy' ? '' : 'btn-secondary' ?> btn-sm" role="tab" aria-selected="<?= $slug === 'privacy' ? 'true' : 'false' ?>">
                <?= e(t('nav.privacy')) ?>
            </a>
            <a href="/<?= e($lang) ?>/legal/license" class="btn <?= $slug === 'license' ? '' : 'btn-secondary' ?> btn-sm" role="tab" aria-selected="<?= $slug === 'license' ? 'true' : 'false' ?>">
                <?= e(t('nav.license')) ?>
            </a>
        </div>

        <div class="legal-card">
            <div class="legal-header" style="margin-bottom: 2.5rem;">
                <h1 style="font-size: 2.5rem; font-weight: 600; color: var(--primary); line-height: 1.15; margin-bottom: 0.75rem;">
                    <?= e($doc['title'] ?? '') ?>
                </h1>
                <?php if (!empty($doc['subtitle'])): ?>
                    <p style="color: var(--secondary); font-size: 1.15rem;"><?= e($doc['subtitle']) ?></p>
                <?php endif; ?>
            </div>

            <div class="legal-content">
                <?php if ($slug === 'imprint'): ?>
                    <h3><?= e($doc['operator_heading'] ?? 'Provider Information') ?></h3>
                    <p style="white-space: pre-line; line-height: 1.8;">
                        <?= e($doc['operator_text'] ?? '') ?>
                    </p>

                    <h3><?= e($doc['contact_heading'] ?? 'Contact') ?></h3>
                    <p style="line-height: 1.8;">
                        <strong>E-Mail:</strong> <a href="mailto:contact@ternis.dev" style="color: var(--primary); text-decoration: underline;">contact@ternis.dev</a> &bull; <a href="mailto:edv@ternismail.de" style="color: var(--primary); text-decoration: underline;">edv@ternismail.de</a><br>
                        <strong>Web:</strong> <a href="https://ternis.dev" target="_blank" rel="noopener noreferrer" style="color: var(--primary); text-decoration: underline;">ternis.dev</a> | <a href="https://ternis-edv.de" target="_blank" rel="noopener noreferrer" style="color: var(--primary); text-decoration: underline;">ternis-edv.de</a>
                    </p>

                    <h3><?= e($doc['disclaimer_heading'] ?? 'Disclaimer') ?></h3>
                    <p><?= e($doc['disclaimer_text'] ?? '') ?></p>

                <?php elseif ($slug === 'privacy'): ?>
                    <h3><?= e($doc['controller_heading'] ?? 'Data Controller') ?></h3>
                    <p><?= e($doc['controller_text'] ?? '') ?></p>

                    <h3><?= e($doc['principles_heading'] ?? 'Privacy Principles') ?></h3>
                    <p><?= e($doc['principles_text'] ?? '') ?></p>

                    <h3><?= e($doc['logging_heading'] ?? 'Server Logs & Infrastructure') ?></h3>
                    <p><?= e($doc['logging_text'] ?? '') ?></p>

                    <h3><?= e($doc['cookies_heading'] ?? 'Cookies & Local Storage') ?></h3>
                    <p><?= e($doc['cookies_text'] ?? '') ?></p>

                    <h3><?= e($doc['rights_heading'] ?? 'Your Rights') ?></h3>
                    <p><?= e($doc['rights_text'] ?? '') ?></p>

                <?php elseif ($slug === 'license'): ?>
                    <h3><?= e($doc['mit_heading'] ?? 'MIT License') ?></h3>
                    <p><?= e($doc['mit_desc'] ?? '') ?></p>
                    <pre><?= e($doc['mit_license_text'] ?? '') ?></pre>

                    <h3><?= e($doc['contributions_heading'] ?? 'Contributions') ?></h3>
                    <p><?= e($doc['contributions_text'] ?? '') ?></p>

                <?php else: ?>
                    <p><?= e($doc['content'] ?? '') ?></p>
                <?php endif; ?>
            </div>

            <div style="margin-top: 3.5rem; padding-top: 2rem; border-top: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <a href="/<?= e($lang) ?>" class="btn btn-secondary btn-sm">
                    &larr; <?= e(t('error.back_home')) ?>
                </a>
                <span style="font-size: 0.85rem; color: var(--secondary); font-family: var(--font-mono);">
                    ternis.org legal disclosure &bull; <?= date('Y') ?>
                </span>
            </div>
        </div>
    </div>
</section>

<!-- Schema.org BreadcrumbList Structured Data -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {
            "@type": "ListItem",
            "position": 1,
            "name": "Home",
            "item": "https://ternis.org/<?= e($lang) ?>"
        },
        {
            "@type": "ListItem",
            "position": 2,
            "name": "<?= e(t('nav.legal')) ?>",
            "item": "https://ternis.org/<?= e($lang) ?>/legal/imprint"
        },
        {
            "@type": "ListItem",
            "position": 3,
            "name": "<?= e($doc['title'] ?? '') ?>",
            "item": "https://ternis.org/<?= e($lang) ?>/legal/<?= e($slug) ?>"
        }
    ]
}
</script>
