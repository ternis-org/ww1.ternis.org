<?php

declare(strict_types=1);

/**
 * Reusable Navbar Component
 * @var string $lang
 * @var string|null $altUrl
 */

$lang = $lang ?? current_lang();
$altLang = $lang === 'en' ? 'de' : 'en';
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/' . $lang;
$enUrl = lang_url('en', $currentPath);
$deUrl = lang_url('de', $currentPath);
$homePrefix = (str_contains($currentPath, '/legal') || str_contains($currentPath, '/error')) ? '/' . $lang : '';
?>
<!-- Floating Pill Navigation -->
<div class="nav-container-fixed">
    <nav class="floating-nav" aria-label="Main Navigation">
        <a href="/<?= e($lang) ?>" class="logo" aria-label="ternis.org Homepage">
            <span>ternis.org</span>
        </a>

        <div class="nav-links">
            <a href="<?= e($homePrefix) ?>#projects"><?= e(t('nav.projects')) ?></a>
            <a href="<?= e($homePrefix) ?>#nameservers"><?= e(t('nav.nameservers')) ?></a>
            <a href="<?= e($homePrefix) ?>#about"><?= e(t('nav.about')) ?></a>
        </div>

        <div class="nav-actions">
            <!-- Language Switcher -->
            <div class="lang-switcher" role="group" aria-label="Language selection">
                <a href="<?= e($enUrl) ?>" class="lang-btn <?= $lang === 'en' ? 'active' : '' ?>" aria-label="English">EN</a>
                <a href="<?= e($deUrl) ?>" class="lang-btn <?= $lang === 'de' ? 'active' : '' ?>" aria-label="Deutsch">DE</a>
            </div>

            <!-- Theme Toggle -->
            <button type="button" class="btn-icon btn-theme-toggle" aria-label="<?= e(t('nav.toggle_theme')) ?>" title="<?= e(t('nav.toggle_theme')) ?>">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </button>

            <!-- GitHub Org Link -->
            <a href="https://github.com/ternis-org" target="_blank" rel="noopener noreferrer" class="btn-icon" aria-label="GitHub Organization" title="ternis-org on GitHub">
                <svg fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"></path>
                </svg>
            </a>

            <!-- Mobile Hamburger Toggle -->
            <button type="button" class="btn-icon mobile-toggle" aria-label="Toggle navigation menu" aria-expanded="false" aria-controls="mobile-nav-drawer">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </nav>
</div>

<!-- Mobile Drawer -->
<div id="mobile-nav-drawer" class="mobile-drawer" role="dialog" aria-label="Mobile Navigation" aria-modal="true">
    <a href="<?= e($homePrefix) ?>#projects" class="nav-link"><?= e(t('nav.projects')) ?></a>
    <a href="<?= e($homePrefix) ?>#nameservers" class="nav-link"><?= e(t('nav.nameservers')) ?></a>
    <a href="<?= e($homePrefix) ?>#about" class="nav-link"><?= e(t('nav.about')) ?></a>
    <a href="/<?= e($lang) ?>/legal/imprint" class="nav-link"><?= e(t('nav.imprint')) ?></a>
    <a href="/<?= e($lang) ?>/legal/privacy" class="nav-link"><?= e(t('nav.privacy')) ?></a>
    <a href="/<?= e($lang) ?>/legal/license" class="nav-link"><?= e(t('nav.license')) ?></a>
    
    <div style="display:flex;gap:0.75rem;margin-top:1.5rem;padding-top:1.5rem;border-top:1px solid var(--border-subtle);justify-content:center;">
        <a href="<?= e($enUrl) ?>" class="btn <?= $lang === 'en' ? '' : 'btn-secondary' ?> btn-sm">English (EN)</a>
        <a href="<?= e($deUrl) ?>" class="btn <?= $lang === 'de' ? '' : 'btn-secondary' ?> btn-sm">Deutsch (DE)</a>
    </div>
</div>
