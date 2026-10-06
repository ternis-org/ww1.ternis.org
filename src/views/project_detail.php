<?php

declare(strict_types=1);

/**
 * Project Detail View: /{lang}/projects/{slug}
 * Rendered inside layouts/main.php
 * @var string $lang
 * @var array $project
 * @var array $categoryMeta
 * @var array $relatedWikiArticles
 * @var array $otherProjects
 */

$lang = $lang ?? current_lang();
$isDe = $lang === 'de';
$catLabel = $isDe ? $categoryMeta['de'] : $categoryMeta['en'];
?>
<div class="project-detail-page">
    <div class="container" style="padding-top: 2rem; padding-bottom: 5rem;">

        <!-- Breadcrumb Navigation -->
        <nav aria-label="Breadcrumb" class="infra-crumbs" style="display:flex;align-items:center;gap:0.5rem;font-size:0.875rem;color:var(--text-muted);margin-bottom:2rem;">
            <a href="/<?= e($lang) ?>" style="display:inline-flex;align-items:center;gap:0.35rem;color:var(--text-muted);text-decoration:none;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                <span>ternis.org</span>
            </a>
            <span aria-hidden="true">&rsaquo;</span>
            <a href="/<?= e($lang) ?>/projects" style="color:var(--text-muted);text-decoration:none;">
                <?= $isDe ? 'Projekte' : 'Projects' ?>
            </a>
            <span aria-hidden="true">&rsaquo;</span>
            <span style="color:var(--text-main);font-weight:600;"><?= e($project['title']) ?></span>
        </nav>

        <!-- Project Hero Card -->
        <header class="project-hero" style="background:var(--surface);border:1px solid var(--border-subtle);border-radius:18px;padding:clamp(1.75rem, 4vw, 3rem);margin-bottom:3rem;position:relative;">
            <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.25rem;">
                <!-- Category Badge -->
                <div style="display:inline-flex;align-items:center;gap:0.5rem;">
                    <span style="font-family:var(--font-mono);font-size:0.75rem;padding:0.3rem 0.75rem;background:rgba(234,88,12,0.12);color:var(--primary);border-radius:9999px;font-weight:600;text-transform:uppercase;letter-spacing:0.04em;">
                        <?= e($catLabel) ?>
                    </span>
                    <span style="display:inline-flex;align-items:center;gap:0.35rem;font-size:0.8125rem;color:#22c55e;font-weight:500;">
                        <span style="width:6px;height:6px;border-radius:50%;background:#22c55e;"></span>
                        <?= e($project['status']) ?>
                    </span>
                </div>

                <!-- Tags list -->
                <div style="display:flex;flex-wrap:wrap;gap:0.4rem;">
                    <?php foreach ($project['tags'] as $tag): ?>
                        <span style="font-size:0.6875rem;padding:0.25rem 0.55rem;background:var(--bg-color);border:1px solid var(--border-subtle);border-radius:4px;color:var(--text-muted);font-family:var(--font-mono);">
                            <?= e($tag) ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>

            <h1 style="font-size:clamp(2.25rem, 5vw, 3.5rem);font-weight:800;letter-spacing:-0.03em;margin:0 0 0.5rem;line-height:1.15;">
                <?= e($project['title']) ?>
            </h1>
            <div style="font-size:clamp(1.125rem, 2.5vw, 1.35rem);font-weight:500;color:var(--primary);margin-bottom:1.5rem;font-family:var(--font-mono);">
                <?= e($project['tagline']) ?>
            </div>
            <p style="font-size:1.125rem;color:var(--text-muted);line-height:1.7;max-width:860px;margin:0 0 2rem;">
                <?= e($project['overview']) ?>
            </p>

            <!-- Action Buttons -->
            <div style="display:flex;flex-wrap:wrap;gap:0.75rem;">
                <a href="<?= e($project['url']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary" style="padding:0.75rem 1.5rem;">
                    <span><?= $isDe ? 'Dienst / Website öffnen' : 'Launch Live Service' ?></span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                </a>
                <?php if (!empty($project['repo_url'])): ?>
                    <a href="<?= e($project['repo_url']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline" style="padding:0.75rem 1.25rem;">
                        <svg fill="currentColor" viewBox="0 0 24 24" style="width:16px;height:16px;" aria-hidden="true"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"></path></svg>
                        <span>GitHub</span>
                    </a>
                <?php endif; ?>
                <?php if (!empty($project['codeberg'])): ?>
                    <a href="<?= e($project['codeberg']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline" style="padding:0.75rem 1.25rem;">
                        <span>Codeberg</span>
                    </a>
                <?php endif; ?>
                <?php if (!empty($project['docs_url'])): ?>
                    <a href="<?= e($project['docs_url']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline" style="padding:0.75rem 1.25rem;">
                        <span><?= $isDe ? 'API-Dokumentation' : 'API Docs' ?></span>
                    </a>
                <?php endif; ?>
            </div>
        </header>

        <!-- Two Column Architecture Grid -->
        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(320px, 1fr));gap:2rem;margin-bottom:3.5rem;">
            
            <!-- Features & Capabilities -->
            <div style="background:var(--surface);border:1px solid var(--border-subtle);border-radius:16px;padding:2rem;">
                <h2 style="font-size:1.35rem;font-weight:700;margin:0 0 1.25rem;display:flex;align-items:center;gap:0.5rem;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span><?= $isDe ? 'Schlüsselmerkmale' : 'Key Features & Capabilities' ?></span>
                </h2>
                <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:1rem;">
                    <?php foreach ($project['features'] as $feature): ?>
                        <li style="display:flex;align-items:flex-start;gap:0.75rem;font-size:0.9375rem;color:var(--text-main);line-height:1.55;">
                            <span style="color:#22c55e;flex-shrink:0;margin-top:0.15rem;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </span>
                            <span><?= e($feature) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Technical Specifications -->
            <div style="background:var(--surface);border:1px solid var(--border-subtle);border-radius:16px;padding:2rem;">
                <h2 style="font-size:1.35rem;font-weight:700;margin:0 0 1.25rem;display:flex;align-items:center;gap:0.5rem;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    <span><?= $isDe ? 'Technische Spezifikationen' : 'Technical Specifications' ?></span>
                </h2>
                <div style="display:flex;flex-direction:column;gap:0.85rem;font-family:var(--font-mono);font-size:0.8125rem;">
                    <?php foreach ($project['specs'] as $specKey => $specVal): ?>
                        <div style="display:flex;flex-wrap:wrap;justify-content:space-between;gap:0.5rem;padding-bottom:0.75rem;border-bottom:1px solid var(--border-subtle);">
                            <span style="color:var(--text-muted);font-weight:500;"><?= e($specKey) ?>:</span>
                            <span style="color:var(--text-main);font-weight:600;text-align:right;"><?= e($specVal) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>

        <!-- Integration / Quickstart Code Snippet -->
        <?php if (!empty($project['snippet'])): ?>
            <section style="margin-bottom: 3.5rem;">
                <div style="background:var(--surface);border:1px solid var(--border-subtle);border-radius:16px;padding:2rem;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                        <h2 style="font-size:1.25rem;font-weight:700;margin:0;">
                            <?= e($project['snippet_label'] ?? ($isDe ? 'Befehl / Integration' : 'Quickstart Example')) ?>
                        </h2>
                        <button type="button" class="btn btn-outline btn-sm copy-chip-btn" data-copy="<?= e($project['snippet']) ?>" data-toast="<?= $isDe ? 'Kopiert!' : 'Copied!' ?>" style="font-size:0.75rem;">
                            <span><?= $isDe ? 'Kopieren' : 'Copy' ?></span>
                        </button>
                    </div>
                    <div style="background:#090d13;border:1px solid #1f2937;border-radius:8px;padding:1.25rem;overflow-x:auto;">
                        <pre style="margin:0;font-family:var(--font-mono);font-size:0.875rem;color:#38bdf8;line-height:1.6;white-space:pre-wrap;"><code><?= e($project['snippet']) ?></code></pre>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <!-- Related Technical Wiki Articles -->
        <?php if (!empty($relatedWikiArticles)): ?>
            <section style="margin-bottom: 3.5rem;">
                <h2 style="font-size:1.5rem;font-weight:700;margin:0 0 0.35rem;">
                    <?= $isDe ? 'Verwandte Leitfäden im Technik-Wiki' : 'Related Technical Wiki Documentation' ?>
                </h2>
                <p style="font-size:0.9375rem;color:var(--text-muted);margin:0 0 1.5rem;">
                    <?= $isDe ? 'Ausführliche Hintergrund-Tutorials zu den Technologien dieses Dienstes.' : 'In-depth implementation tutorials covering the technologies used by this service.' ?>
                </p>

                <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:1.25rem;">
                    <?php foreach ($relatedWikiArticles as $wikiArt): ?>
                        <a href="/<?= e($lang) ?>/wiki/<?= e($wikiArt['category']) ?>/<?= e($wikiArt['slug']) ?>" style="display:block;padding:1.5rem;background:var(--surface);border:1px solid var(--border-subtle);border-radius:12px;text-decoration:none;color:inherit;transition:border-color 0.15s ease;">
                            <div style="font-family:var(--font-mono);font-size:0.75rem;color:var(--primary);margin-bottom:0.4rem;text-transform:uppercase;">
                                <?= e($wikiArt['category']) ?> // GUIDE
                            </div>
                            <strong style="display:block;font-size:1.05rem;margin-bottom:0.4rem;color:var(--text-main);">
                                <?= e($wikiArt['title']) ?>
                            </strong>
                            <?php if (!empty($wikiArt['description'])): ?>
                                <p style="font-size:0.8125rem;color:var(--text-muted);line-height:1.5;margin:0;">
                                    <?= e($wikiArt['description']) ?>
                                </p>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <!-- Other Ecosystem Projects -->
        <?php if (!empty($otherProjects)): ?>
            <section style="border-top:1px solid var(--border-subtle);padding-top:3rem;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
                    <h2 style="font-size:1.35rem;font-weight:700;margin:0;">
                        <?= $isDe ? 'Weitere Projekte im Ökosystem' : 'Other Projects in the Ecosystem' ?>
                    </h2>
                    <a href="/<?= e($lang) ?>/projects" style="font-size:0.875rem;color:var(--primary);text-decoration:none;font-weight:600;">
                        <?= $isDe ? 'Alle ansehen &rarr;' : 'View all &rarr;' ?>
                    </a>
                </div>

                <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:1.25rem;">
                    <?php foreach ($otherProjects as $other): ?>
                        <a href="/<?= e($lang) ?>/projects/<?= e($other['slug']) ?>" style="display:block;padding:1.25rem;background:var(--surface);border:1px solid var(--border-subtle);border-radius:12px;text-decoration:none;color:inherit;transition:border-color 0.15s ease;">
                            <strong style="display:block;font-size:1rem;margin-bottom:0.25rem;color:var(--text-main);">
                                <?= e($other['title']) ?>
                            </strong>
                            <div style="font-size:0.8125rem;color:var(--primary);margin-bottom:0.5rem;font-family:var(--font-mono);">
                                <?= e($other['tagline']) ?>
                            </div>
                            <p style="font-size:0.8125rem;color:var(--text-muted);line-height:1.45;margin:0;">
                                <?= e($other['description']) ?>
                            </p>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

    </div>
</div>
