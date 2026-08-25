<?php

declare(strict_types=1);

/**
 * Error view template (404 / 500) (Rendered inside layouts/main.php)
 * @var string $lang
 * @var int $code
 * @var string $message
 */

$lang = $lang ?? current_lang();
$code = $code ?? 404;
$message = $message ?? t('error.not_found');
?>
<section style="padding: 10rem 0 6rem; text-align: center; display: flex; align-items: center; justify-content: center;">
    <div class="container" style="max-width: 640px;">
        <div style="font-size: clamp(4.5rem, 12vw, 8rem); font-weight: 300; font-family: var(--font-mono); color: var(--primary); line-height: 1; margin-bottom: 1.5rem;" aria-hidden="true">
            <?= e($code) ?>
        </div>
        <h1 style="font-size: 2rem; font-weight: 600; color: var(--primary); margin-bottom: 1rem;">
            <?= e($message) ?>
        </h1>
        <p style="color: var(--secondary); font-size: 1.15rem; margin-bottom: 2.5rem; line-height: 1.6;">
            <?= e(t('error.desc')) ?>
        </p>
        <div style="display: flex; justify-content: center; gap: 1.25rem; flex-wrap: wrap;">
            <a href="/<?= e($lang) ?>" class="btn">
                &larr; <?= e(t('error.back_home')) ?>
            </a>
            <a href="/<?= e($lang) ?>#projects" class="btn btn-secondary">
                <?= e(t('error.explore_proj')) ?>
            </a>
            <a href="https://getmy.name/api-docs" target="_blank" rel="noopener noreferrer" class="btn btn-outline">
                <span>API Docs</span>
            </a>
        </div>
    </div>
</section>
