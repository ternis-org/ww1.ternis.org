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

        <!-- DNS & Infrastructure Notice Bar -->
        <div class="infra-notice-bar">
            <div class="infra-notice-content">
                <span class="infra-notice-prefix">DNS &amp; Nameservers</span>
                <span class="infra-notice-text"><?= e(t('projects.dnbx_note')) ?></span>
            </div>
            <div class="infra-notice-links">
                <a href="#nameservers" class="infra-link">
                    <span><?= e(t('nav.nameservers')) ?></span>
                    <svg class="arrow-svg arrow-svg-sm" viewBox="0 0 35 12" fill="none">
                        <path d="M 28.833 1 L 33.244 5.411 C 33.57 5.736 33.57 6.264 33.244 6.589 L 28.833 11" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M 1.5 6 L 32 6" stroke-width="1.5" stroke-linecap="round" class="line"/>
                    </svg>
                </a>
                <a href="https://dnbx.de" target="_blank" rel="noopener noreferrer" class="infra-link">
                    <span>dnbx.de</span>
                    <svg class="arrow-svg arrow-svg-sm" viewBox="0 0 35 12" fill="none">
                        <path d="M 28.833 1 L 33.244 5.411 C 33.57 5.736 33.57 6.264 33.244 6.589 L 28.833 11" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M 1.5 6 L 32 6" stroke-width="1.5" stroke-linecap="round" class="line"/>
                    </svg>
                </a>
            </div>
        </div>

        <div class="projects-grid">
            <!-- Project 1: httpclient.de -->
            <div class="project-card">
                <div>
                    <div class="project-header">
                        <h3><?= e(t('projects.httpclient.title')) ?></h3>
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
                </div>
            </div>

            <!-- Project 4: web-search.org -->
            <div class="project-card">
                <div>
                    <div class="project-header">
                        <h3><?= e(t('projects.websearch.title')) ?></h3>
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

            <!-- Project 7: example-dns -->
            <div class="project-card project-card-full">
                <div>
                    <div class="project-header">
                        <h3><?= e(t('projects.exampledns.title')) ?></h3>
                    </div>
                    <div class="project-tagline"><?= e(t('projects.exampledns.tagline')) ?></div>
                    <p class="project-desc"><?= e(t('projects.exampledns.description')) ?></p>
                    <div class="project-tags">
                        <?php foreach (t_array('projects.exampledns.tags') as $tag): ?>
                            <span class="project-tag"><?= e($tag) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="project-actions">
                    <a href="<?= e(t('projects.exampledns.url_web')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm">
                        <span>example-dns.com</span>
                    </a>
                    <a href="<?= e(t('projects.exampledns.url_github')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">
                        <svg fill="currentColor" viewBox="0 0 24 24" style="width:14px;height:14px;">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"></path>
                        </svg>
                        <span>GitHub</span>
                    </a>
                    <a href="<?= e(t('projects.exampledns.url_codeberg')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">
                        <span>Codeberg</span>
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

<!-- Dedicated Nameservers & DNS Infrastructure Section -->
<section id="nameservers" style="padding-top: 5rem; padding-bottom: 4rem;">
    <div class="container">
        <div class="section-header" style="margin-bottom: 2.5rem;">
            <h2><?= e(t('nameservers.title')) ?></h2>
            <p class="section-subtitle"><?= e(t('nameservers.subtitle')) ?></p>
        </div>

        <div class="ns-grid">
            <!-- Node 1: Primary Nameserver -->
            <div class="ns-card">
                <div>
                    <div class="ns-card-header">
                        <div class="ns-status-indicator">
                            <span class="ns-dot-live"></span>
                            <span><?= e(t('nameservers.status_active')) ?></span>
                        </div>
                        <span class="ns-node-badge">NS1</span>
                    </div>
                    <h3 class="ns-hostname"><?= e(t('nameservers.node1_host')) ?></h3>
                    <div class="ns-alias">
                        <span><?= e(t('nameservers.alias_label')) ?>:</span>
                        <code><?= e(t('nameservers.node1_alias')) ?></code>
                    </div>
                    <p class="ns-desc"><?= e(t('nameservers.node1_desc')) ?></p>
                </div>
                <div class="ns-specs">
                    <span class="ns-spec-chip">IPv4 / IPv6</span>
                    <span class="ns-spec-chip">DNSSEC Ready</span>
                    <span class="ns-spec-chip">Authoritative</span>
                    <span class="ns-spec-chip">European Cloud</span>
                </div>
            </div>

            <!-- Node 2: Secondary Nameserver -->
            <div class="ns-card">
                <div>
                    <div class="ns-card-header">
                        <div class="ns-status-indicator">
                            <span class="ns-dot-live"></span>
                            <span><?= e(t('nameservers.status_active')) ?></span>
                        </div>
                        <span class="ns-node-badge">NS2</span>
                    </div>
                    <h3 class="ns-hostname"><?= e(t('nameservers.node2_host')) ?></h3>
                    <div class="ns-alias">
                        <span><?= e(t('nameservers.alias_label')) ?>:</span>
                        <code><?= e(t('nameservers.node2_alias')) ?></code>
                    </div>
                    <p class="ns-desc"><?= e(t('nameservers.node2_desc')) ?></p>
                </div>
                <div class="ns-specs">
                    <span class="ns-spec-chip">IPv4 / IPv6</span>
                    <span class="ns-spec-chip">DNSSEC Ready</span>
                    <span class="ns-spec-chip">Redundant Node</span>
                    <span class="ns-spec-chip">Zone Sync</span>
                </div>
            </div>
        </div>

        <!-- Infrastructure Domains & Verification Terminal -->
        <div class="ns-meta-card">
            <div class="ns-meta-left">
                <div class="ns-domains-header">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:20px;height:20px;color:var(--primary);flex-shrink:0;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h4><?= e(t('nameservers.domains_title')) ?></h4>
                </div>
                <p class="ns-meta-desc"><?= e(t('nameservers.domains_desc')) ?></p>
                <div class="ns-domain-chips">
                    <a href="https://example-dns.com" target="_blank" rel="noopener noreferrer" class="ns-domain-pill">example-dns.com</a>
                    <a href="https://example-dns.net" target="_blank" rel="noopener noreferrer" class="ns-domain-pill">example-dns.net</a>
                    <a href="https://example-dns.org" target="_blank" rel="noopener noreferrer" class="ns-domain-pill">example-dns.org</a>
                </div>
            </div>

            <div class="ns-terminal">
                <div class="ns-terminal-header">
                    <span class="dot red"></span>
                    <span class="dot yellow"></span>
                    <span class="dot green"></span>
                    <span class="ns-terminal-title"><?= e(t('nameservers.terminal_title')) ?></span>
                </div>
                <pre class="ns-terminal-code"><code><span class="term-prompt">$</span> dig @one.ns.ternis.net ternis.org +noall +answer
ternis.org.  300  IN  A  &lt;sovereign-ip&gt;

<span class="term-prompt">$</span> host -t NS ternis.org
ternis.org name server one.ns.ternis.net.
ternis.org name server two.ns.ternis.net.</code></pre>
            </div>
        </div>

        <!-- Infrastructure Action Links -->
        <div class="ns-actions-bar">
            <a href="https://example-dns.com" target="_blank" rel="noopener noreferrer" class="btn btn-sm">
                <span><?= e(t('nameservers.btn_visit')) ?></span>
            </a>
            <a href="https://github.com/example-dns/example-dns" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">
                <svg fill="currentColor" viewBox="0 0 24 24" style="width:14px;height:14px;">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"></path>
                </svg>
                <span><?= e(t('nameservers.btn_github')) ?></span>
            </a>
            <a href="https://codeberg.org/example-dns/example-dns" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">
                <span><?= e(t('nameservers.btn_codeberg')) ?></span>
            </a>
            <a href="https://dnbx.de" target="_blank" rel="noopener noreferrer" class="btn btn-outline btn-sm btn-expanding">
                <span><?= e(t('nameservers.btn_dnbx')) ?></span>
                <svg class="arrow-svg arrow-svg-sm" viewBox="0 0 35 12" fill="none">
                    <path d="M 28.833 1 L 33.244 5.411 C 33.57 5.736 33.57 6.264 33.244 6.589 L 28.833 11" stroke-width="1.5" stroke-linecap="round"/>
                    <path d="M 1.5 6 L 32 6" stroke-width="1.5" stroke-linecap="round" class="line"/>
                </svg>
            </a>
        </div>
    </div>
</section>
