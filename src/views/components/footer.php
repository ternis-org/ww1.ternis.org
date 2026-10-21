<?php

declare(strict_types=1);

/**
 * Reusable Footer Component
 * @var string $lang
 * @var string $versionShort
 */

$lang = $lang ?? current_lang();
$versionShort = $versionShort ?? app_version_hash(true);
$commitUrl = app_repo_commit_url($versionShort);
?>
<!-- Sculpted Organic Footer -->
<footer id="connect" class="sculpted-footer">
    <div class="container">
        <div class="footer-top">
            <div class="footer-brand-block scroll-reveal scroll-reveal-left">
                <a class="footer-brand" href="/<?= e($lang) ?>" aria-label="ternis.org Homepage"><?php component('brand', ['inverted' => true, 'monochrome' => true]); ?></a>
                <p class="footer-tagline"><?= e(t('footer.tagline')) ?></p>
                <p class="footer-description"><?= e(t('footer.description')) ?></p>
                <a class="btn footer-cta-btn" href="https://ternis.dev" target="_blank" rel="noopener noreferrer">
                    <span><?= e(t('cta.btn_contact')) ?></span>
                    <svg class="arrow-svg" viewBox="0 0 35 12" fill="none" aria-hidden="true">
                        <path d="M 28.833 1 L 33.244 5.411 C 33.57 5.736 33.57 6.264 33.244 6.589 L 28.833 11" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M 1.5 6 L 32 6" stroke-width="1.5" stroke-linecap="round" class="line"/>
                    </svg>
                </a>
            </div>

            <nav class="footer-links-grid stagger-children" aria-label="Footer">
                <div class="footer-col">
                    <h4><?= e(t('footer.col_projects')) ?></h4>
                    <ul>
                        <li><a href="/<?= e($lang) ?>/projects" class="footer-col-lead">&rarr; <?= $lang === 'de' ? 'Alle Projekte' : 'All Projects' ?></a></li>
                        <li><a href="https://httpclient.de" target="_blank" rel="noopener noreferrer">httpclient.de</a></li>
                        <li><a href="https://api-sandbox.de" target="_blank" rel="noopener noreferrer">api-sandbox.de</a></li>
                        <li><a href="https://mtex.dev" target="_blank" rel="noopener noreferrer">MTEX.dev</a></li>
                        <li><a href="https://getmy.name" target="_blank" rel="noopener noreferrer">getmy.name</a></li>
                        <li><a href="https://example-dns.com" target="_blank" rel="noopener noreferrer">example-dns.com</a></li>
                        <li><a href="https://web-search.org" target="_blank" rel="noopener noreferrer">web-search.org</a></li>
                        <li><a href="https://mail-free.eu" target="_blank" rel="noopener noreferrer">mail-free.eu</a></li>
                        <li><a href="https://static.re" target="_blank" rel="noopener noreferrer">static.re</a></li>
                        <li><a href="https://drophtml.de" target="_blank" rel="noopener noreferrer">drophtml.de</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4><?= $lang === 'de' ? 'Werkzeuge' : 'Tools' ?></h4>
                    <ul>
                        <li><a href="/<?= e($lang) ?>/tools" class="footer-col-lead">&rarr; <?= $lang === 'de' ? 'Alle Werkzeuge' : 'All Tools' ?></a></li>
                        <li><a href="/<?= e($lang) ?>/tools/shortlink">Shortlink &amp; QR Studio</a></li>
                        <li><a href="/<?= e($lang) ?>/tools/dns">DNS Looking Glass</a></li>
                        <li><a href="/<?= e($lang) ?>/tools/secret-generator"><?= $lang === 'de' ? 'Token &amp; Secret Generator' : 'Token &amp; Secret Generator' ?></a></li>
                        <li><a href="/<?= e($lang) ?>/tools/shortlink/api"><?= $lang === 'de' ? 'Shortlink API Leitfaden' : 'Shortlink API Guide' ?></a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4><?= e(t('footer.col_ecosystem')) ?></h4>
                    <ul>
                        <li><a href="/<?= e($lang) ?>/infrastructure" class="footer-col-lead">&rarr; <?= $lang === 'de' ? 'Infrastruktur (ternis.net)' : 'Infrastructure (ternis.net)' ?></a></li>
                        <li><a href="https://ternis.dev" target="_blank" rel="noopener noreferrer">ternis.dev</a></li>
                        <li><a href="https://ternis-edv.de" target="_blank" rel="noopener noreferrer">ternis-edv.de</a></li>
                        <li><a href="https://ternisdomains.de" target="_blank" rel="noopener noreferrer">ternisdomains.de</a></li>
                        <li><a href="https://codeberg.org/ternis" target="_blank" rel="noopener noreferrer" class="footer-inline-brand"><?php component('codeberg_icon', ['size' => 14]); ?> <span>Codeberg</span></a></li>
                        <li><a href="https://github.com/ternis-org" target="_blank" rel="noopener noreferrer" class="footer-inline-brand"><svg fill="currentColor" viewBox="0 0 24 24" aria-hidden="true" width="14" height="14"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"></path></svg> <span>GitHub Org</span></a></li>
                        <li><a href="https://codeberg.org/example-dns/example-dns" target="_blank" rel="noopener noreferrer">example-dns (Codeberg)</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4><?= e(t('footer.col_resources')) ?></h4>
                    <ul>
                        <li><a href="/<?= e($lang) ?>/branding" class="footer-col-lead">&rarr; <?= $lang === 'de' ? 'Branding &amp; Assets' : 'Branding &amp; Assets' ?></a></li>
                        <li><a href="/<?= e($lang) ?>/wiki"><?= e(t('nav.wiki')) ?></a></li>
                        <li><a href="/sitemap.xml">Sitemap.xml</a></li>
                        <li><a href="/api/ver">Version Hash</a></li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="footer-bottom scroll-reveal delay-2">
            <p class="footer-copyright">&copy; <?= date('Y') ?> ternis.org &bull; <?= e(t('footer.rights')) ?></p>

            <ul class="footer-bottom-links">
                <li><a href="/<?= e($lang) ?>/legal/imprint"><?= e(t('nav.imprint')) ?></a></li>
                <li><a href="/<?= e($lang) ?>/legal/privacy"><?= e(t('nav.privacy')) ?></a></li>
                <li><a href="/<?= e($lang) ?>/legal/license"><?= e(t('nav.license')) ?></a></li>
            </ul>

            <div class="footer-bottom-actions">
                <div class="footer-social-strip" aria-label="Social &amp; Repositories">
                    <a href="https://codeberg.org/ternis" target="_blank" rel="noopener noreferrer" class="footer-social-btn" aria-label="ternis on Codeberg" title="ternis on Codeberg">
                        <?php component('codeberg_icon', ['size' => 15]); ?>
                    </a>
                    <a href="https://github.com/ternis-org" target="_blank" rel="noopener noreferrer" class="footer-social-btn" aria-label="ternis-org on GitHub" title="ternis-org on GitHub">
                        <svg fill="currentColor" viewBox="0 0 24 24" aria-hidden="true" width="15" height="15">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"></path>
                        </svg>
                    </a>
                </div>
                <a href="<?= e($commitUrl) ?>" target="_blank" rel="noopener noreferrer" class="footer-version-link" title="<?= e(t('footer.version')) ?> <?= e($versionShort) ?> on GitHub">v<?= e($versionShort) ?></a>
            </div>
        </div>
    </div>
</footer>
