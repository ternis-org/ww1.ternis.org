<?php

declare(strict_types=1);

/**
 * Main index view for ternis.org (Rendered inside layouts/main.php)
 * @var string $lang
 */

$lang = $lang ?? current_lang();
?>
<!-- Hero Section -->
<section id="hero">
    <div class="container">
        <h1>
            <?= e(t('hero.title_line1')) ?><br>
            <strong><?= e(t('hero.title_line2')) ?></strong>
        </h1>

        <p class="hero-p">
            <?= e(t('hero.description')) ?>
        </p>

        <div class="hero-actions">
            <!-- Main CTA with Expanding Arrow -->
            <a href="#projects" class="btn btn-expanding">
                <span><?= e(t('hero.cta_projects')) ?></span>
                <svg class="arrow-svg" viewBox="0 0 35 12" fill="none">
                    <path d="M 28.833 1 L 33.244 5.411 C 33.57 5.736 33.57 6.264 33.244 6.589 L 28.833 11" stroke-width="1.5" stroke-linecap="round"/>
                    <path d="M 1.5 6 L 32 6" stroke-width="1.5" stroke-linecap="round" class="line"/>
                </svg>
            </a>
            <a href="https://getmy.name/api-docs" target="_blank" rel="noopener noreferrer" class="btn btn-secondary">
                <span><?= e(t('hero.cta_playground')) ?></span>
            </a>
            <a href="https://github.com/ternis-org" target="_blank" rel="noopener noreferrer" class="btn btn-outline">
                <svg fill="currentColor" viewBox="0 0 24 24" style="width:16px;height:16px;">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"></path>
                </svg>
                <span><?= e(t('hero.cta_github')) ?></span>
            </a>
        </div>

        <!-- Hero Stats Bar -->
        <div class="hero-stats">
            <div class="stat-item">
                <div class="stat-value"><?= e(t('hero.stat_open_source')) ?></div>
                <div class="stat-label"><?= e(t('hero.stat_open_source_sub')) ?></div>
            </div>
            <div class="stat-item">
                <div class="stat-value"><?= e(t('hero.stat_privacy')) ?></div>
                <div class="stat-label"><?= e(t('hero.stat_privacy_sub')) ?></div>
            </div>
            <div class="stat-item">
                <div class="stat-value"><?= e(t('hero.stat_latency')) ?></div>
                <div class="stat-label"><?= e(t('hero.stat_latency_sub')) ?></div>
            </div>
            <div class="stat-item">
                <div class="stat-value"><?= e(t('hero.stat_uptime')) ?></div>
                <div class="stat-label"><?= e(t('hero.stat_uptime_sub')) ?></div>
            </div>
        </div>
    </div>
</section>

<!-- Projects Showcase Section -->
<section id="projects" style="padding-top: 4rem;">
    <div class="container">
        <div class="section-header" style="margin-bottom: 2.5rem;">
            <h2><?= e(t('projects.title')) ?></h2>
            <p class="section-subtitle"><?= e(t('projects.subtitle')) ?></p>
        </div>

        <!-- dnbx.de Domain Management Notice Bar -->
        <div style="background: var(--bg-card); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 1rem 1.75rem; margin-bottom: 2.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <span class="badge badge-primary" style="font-size:0.75rem;">DNS & Infrastructure</span>
                <span style="font-size: 0.95rem; color: var(--text-dark);"><?= e(t('projects.dnbx_note')) ?></span>
            </div>
            <a href="https://dnbx.de" target="_blank" rel="noopener noreferrer" class="btn-expanding" style="font-family: var(--font-mono); font-size: 0.85rem; font-weight: 600; color: var(--primary); display: inline-flex; align-items: center; gap: 0.45rem;">
                <span>dnbx.de</span>
                <svg class="arrow-svg arrow-svg-sm" viewBox="0 0 35 12" fill="none">
                    <path d="M 28.833 1 L 33.244 5.411 C 33.57 5.736 33.57 6.264 33.244 6.589 L 28.833 11" stroke-width="1.5" stroke-linecap="round"/>
                    <path d="M 1.5 6 L 32 6" stroke-width="1.5" stroke-linecap="round" class="line"/>
                </svg>
            </a>
        </div>

        <div class="projects-grid">
            <!-- Project 1: httpclient.de -->
            <div class="project-card">
                <div>
                    <div class="project-header">
                        <h3><?= e(t('projects.httpclient.title')) ?></h3>
                        <span class="badge badge-accent"><?= e(t('projects.httpclient.badge')) ?></span>
                    </div>
                    <div class="project-tagline"><?= e(t('projects.httpclient.tagline')) ?></div>
                    <p class="project-desc"><?= e(t('projects.httpclient.description')) ?></p>
                    <div class="project-tags">
                        <?php foreach (t_array('projects.httpclient.tags') as $tag): ?>
                            <span class="project-tag"><?= e($tag) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="project-actions">
                    <a href="<?= e(t('projects.httpclient.url')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm">
                        <span><?= e(t('projects.view_project')) ?></span>
                    </a>
                </div>
            </div>

            <!-- Project 2: api-sandbox.de -->
            <div class="project-card">
                <div>
                    <div class="project-header">
                        <h3><?= e(t('projects.apisandbox.title')) ?></h3>
                        <span class="badge badge-secondary"><?= e(t('projects.apisandbox.badge')) ?></span>
                    </div>
                    <div class="project-tagline"><?= e(t('projects.apisandbox.tagline')) ?></div>
                    <p class="project-desc"><?= e(t('projects.apisandbox.description')) ?></p>
                    <div class="project-tags">
                        <?php foreach (t_array('projects.apisandbox.tags') as $tag): ?>
                            <span class="project-tag"><?= e($tag) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="project-actions">
                    <a href="<?= e(t('projects.apisandbox.url')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm">
                        <span><?= e(t('projects.view_project')) ?></span>
                    </a>
                </div>
            </div>

            <!-- Project 3: MTEX.dev (e.g. getmy.name) -->
            <div class="project-card">
                <div>
                    <div class="project-header">
                        <h3><?= e(t('projects.mtex.title')) ?></h3>
                        <span class="badge badge-primary"><?= e(t('projects.mtex.badge')) ?></span>
                    </div>
                    <div class="project-tagline"><?= e(t('projects.mtex.tagline')) ?></div>
                    <p class="project-desc"><?= e(t('projects.mtex.description')) ?></p>
                    <div class="project-tags">
                        <?php foreach (t_array('projects.mtex.tags') as $tag): ?>
                            <span class="project-tag"><?= e($tag) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="project-actions">
                    <a href="<?= e(t('projects.mtex.url')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm">
                        <span><?= e(t('projects.view_project')) ?></span>
                    </a>
                    <a href="https://getmy.name" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">
                        <span>getmy.name</span>
                    </a>
                    <a href="https://getmy.name/api-docs" target="_blank" rel="noopener noreferrer" class="btn btn-outline btn-sm">
                        <span><?= e(t('projects.view_docs')) ?></span>
                    </a>
                </div>
            </div>

            <!-- Project 4: web-search.org -->
            <div class="project-card">
                <div>
                    <div class="project-header">
                        <h3><?= e(t('projects.websearch.title')) ?></h3>
                        <span class="badge badge-accent"><?= e(t('projects.websearch.badge')) ?></span>
                    </div>
                    <div class="project-tagline"><?= e(t('projects.websearch.tagline')) ?></div>
                    <p class="project-desc"><?= e(t('projects.websearch.description')) ?></p>
                    <div class="project-tags">
                        <?php foreach (t_array('projects.websearch.tags') as $tag): ?>
                            <span class="project-tag"><?= e($tag) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="project-actions">
                    <a href="<?= e(t('projects.websearch.url')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm">
                        <span><?= e(t('projects.view_project')) ?></span>
                    </a>
                </div>
            </div>

            <!-- Project 5: mail-free.eu + mail-free.uk -->
            <div class="project-card">
                <div>
                    <div class="project-header">
                        <h3><?= e(t('projects.mailfree.title')) ?></h3>
                        <span class="badge badge-secondary"><?= e(t('projects.mailfree.badge')) ?></span>
                    </div>
                    <div class="project-tagline"><?= e(t('projects.mailfree.tagline')) ?></div>
                    <p class="project-desc"><?= e(t('projects.mailfree.description')) ?></p>
                    <div class="project-tags">
                        <?php foreach (t_array('projects.mailfree.tags') as $tag): ?>
                            <span class="project-tag"><?= e($tag) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="project-actions">
                    <a href="<?= e(t('projects.mailfree.url_eu')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">
                        <span>mail-free.eu</span>
                    </a>
                    <a href="<?= e(t('projects.mailfree.url_uk')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">
                        <span>mail-free.uk</span>
                    </a>
                </div>
            </div>

            <!-- Project 6: static.re -->
            <div class="project-card">
                <div>
                    <div class="project-header">
                        <h3><?= e(t('projects.staticre.title')) ?></h3>
                        <span class="badge badge-accent"><?= e(t('projects.staticre.badge')) ?></span>
                    </div>
                    <div class="project-tagline"><?= e(t('projects.staticre.tagline')) ?></div>
                    <p class="project-desc"><?= e(t('projects.staticre.description')) ?></p>
                    <div class="project-tags">
                        <?php foreach (t_array('projects.staticre.tags') as $tag): ?>
                            <span class="project-tag"><?= e($tag) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="project-actions">
                    <a href="<?= e(t('projects.staticre.url')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">
                        <span><?= e(t('projects.view_project')) ?></span>
                    </a>
                </div>
            </div>
        </div>

        <!-- More Projects Indicator Card -->
        <div style="text-align: center; margin-top: 3.5rem; padding: 2.5rem; background: var(--bg-card); border: 1px dashed var(--border-highlight); border-radius: var(--radius-lg);">
            <h3 style="font-size: 1.4rem; font-weight: 600; color: var(--primary); margin-bottom: 0.5rem;">... and more projects in active development</h3>
            <p style="color: var(--text-muted); max-width: 580px; margin: 0 auto 1.5rem; font-size: 0.95rem;">
                Discover our full suite of open-source utilities, repositories, and upcoming developer tools on the ternis-org GitHub organization.
            </p>
            <a href="https://github.com/ternis-org" target="_blank" rel="noopener noreferrer" class="btn btn-outline btn-sm btn-expanding">
                <svg fill="currentColor" viewBox="0 0 24 24" style="width:16px;height:16px;">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"></path>
                </svg>
                <span>Explore ternis-org on GitHub</span>
                <svg class="arrow-svg" viewBox="0 0 35 12" fill="none">
                    <path d="M 28.833 1 L 33.244 5.411 C 33.57 5.736 33.57 6.264 33.244 6.589 L 28.833 11" stroke-width="1.5" stroke-linecap="round"/>
                    <path d="M 1.5 6 L 32 6" stroke-width="1.5" stroke-linecap="round" class="line"/>
                </svg>
            </a>
        </div>
    </div>
</section>
