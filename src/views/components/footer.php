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
        <div class="footer-content">
            <div class="footer-cta scroll-reveal scroll-reveal-left">
                Let's grow<br>
                <strong>something beautiful.</strong>
                <div style="margin-top:2.5rem;">
                    <a href="https://ternis.dev" target="_blank" rel="noopener noreferrer" class="btn btn-expanding" style="background:var(--bg-color);color:var(--primary);box-shadow:none;">
                        <span><?= e(t('cta.btn_contact')) ?></span>
                        <svg class="arrow-svg" viewBox="0 0 35 12" fill="none">
                            <path d="M 28.833 1 L 33.244 5.411 C 33.57 5.736 33.57 6.264 33.244 6.589 L 28.833 11" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M 1.5 6 L 32 6" stroke-width="1.5" stroke-linecap="round" class="line"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="footer-links-grid stagger-children">
                <div class="footer-col">
                    <h4><?= e(t('footer.col_projects')) ?></h4>
                    <ul>
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
                    <h4><?= e(t('footer.col_ecosystem')) ?></h4>
                    <ul>
                        <li><a href="https://dnbx.de" target="_blank" rel="noopener noreferrer">dnbx.de (DNS)</a></li>
                        <li><a href="https://github.com/example-dns/example-dns" target="_blank" rel="noopener noreferrer">example-dns (GitHub)</a></li>
                        <li><a href="https://codeberg.org/example-dns/example-dns" target="_blank" rel="noopener noreferrer">example-dns (Codeberg)</a></li>
                        <li><a href="https://ternis.dev" target="_blank" rel="noopener noreferrer">ternis.dev</a></li>
                        <li><a href="https://ternis-edv.de" target="_blank" rel="noopener noreferrer">ternis-edv.de</a></li>
                        <li><a href="https://github.com/ternis-org" target="_blank" rel="noopener noreferrer">GitHub Org</a></li>
                        <li><a href="/api/ver" target="_blank">Version Hash</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4><?= e(t('footer.col_legal')) ?></h4>
                    <ul>
                        <li><a href="/<?= e($lang) ?>/legal/imprint"><?= e(t('nav.imprint')) ?></a></li>
                        <li><a href="/<?= e($lang) ?>/legal/privacy"><?= e(t('nav.privacy')) ?></a></li>
                        <li><a href="/<?= e($lang) ?>/legal/license"><?= e(t('nav.license')) ?></a></li>
                        <li><a href="/sitemap.xml">Sitemap.xml</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-bottom scroll-reveal delay-2">
            <div>
                &copy; <?= date('Y') ?> ternis.org &bull; <?= e(t('footer.rights')) ?>
            </div>
            <div>
                <?= e(t('footer.version')) ?>: <a href="<?= e($commitUrl) ?>" target="_blank" rel="noopener noreferrer" class="footer-version-link" title="<?= e(t('footer.version')) ?> <?= e($versionShort) ?> on GitHub"><strong style="font-family:var(--font-mono);">v<?= e($versionShort) ?></strong></a>
            </div>
        </div>
    </div>
</footer>
