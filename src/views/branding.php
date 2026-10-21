<?php

declare(strict_types=1);

$lang = $lang ?? current_lang();
$de = $lang === 'de';
$assets = [
    ['wordmark-light', $de ? 'Wortmarke · hell' : 'Wordmark · light', $de ? 'Für helle Hintergründe.' : 'For light backgrounds.', false, false],
    ['wordmark-dark', $de ? 'Wortmarke · dunkel' : 'Wordmark · dark', $de ? 'Für dunkle Hintergründe.' : 'For dark backgrounds.', true, false],
    ['icon-light', $de ? 'Bildmarke · hell' : 'Icon · light', $de ? 'Das kompakte Zeichen für helle Flächen.' : 'The compact mark for light surfaces.', false, true],
    ['icon-dark', $de ? 'Bildmarke · dunkel' : 'Icon · dark', $de ? 'Das kompakte Zeichen für dunkle Flächen.' : 'The compact mark for dark surfaces.', true, true],
    ['wordmark-onecolor-olive', $de ? 'Einfarbig · Olive' : 'One color · olive', $de ? 'Reduziert auf unsere Hauptfarbe.' : 'Reduced to our primary color.', false, false],
    ['wordmark-onecolor-cream', $de ? 'Einfarbig · Creme' : 'One color · cream', $de ? 'Eine warme, helle Alternative auf dunklen Flächen.' : 'A warm, light alternative on dark surfaces.', true, false],
    ['wordmark-onecolor-charcoal', $de ? 'Einfarbig · Anthrazit' : 'One color · charcoal', $de ? 'Für monochrome Anwendungen auf hellen Flächen.' : 'For monochrome use on light surfaces.', false, false],
    ['wordmark-onecolor-white', $de ? 'Einfarbig · Weiß' : 'One color · white', $de ? 'Für monochrome Anwendungen auf dunklen Flächen.' : 'For monochrome use on dark surfaces.', true, false],
];
$colors = [
    ['Olive', '#4A5D23'], ['Sage', '#8C9C6F'], ['Deep olive', '#3D4D1D'], ['Charcoal', '#2C3029'], ['Cream', '#F0F4EA'],
];
?>
<div class="brand-page">
    <div class="container">
        <header>
            <p class="brand-eyebrow">ternis.org / Branding</p>
            <h1><?= $de ? 'Ein Zeichen.<br>Viele Möglichkeiten.' : 'One identity.<br>Many possibilities.' ?></h1>
            <p class="brand-copy"><?= $de ? 'Offene Werkzeuge. Unabhängige Infrastruktur. Eine gemeinsame Identität. Hier findest du unsere offiziellen Logos und Farben für dein nächstes Projekt mit ternis.org.' : 'Open tools. Independent infrastructure. A shared identity. Here are our official logos and colors for your next project with ternis.org.' ?></p>
            <a class="btn" href="/assets/brand/ternis-brand.zip" download><?= $de ? 'Brand-Paket herunterladen' : 'Download brand kit' ?> &darr;</a>
            <nav class="brand-jump-links" aria-label="<?= $de ? 'Auf dieser Seite' : 'On this page' ?>">
                <a href="#logos">Logos &amp; SVGs</a>
                <a href="#colors"><?= $de ? 'Farben' : 'Colors' ?></a>
                <a href="#usage"><?= $de ? 'Verwendung' : 'Usage' ?></a>
            </nav>
            <div class="brand-page-hero"><?php component('brand'); ?></div>
        </header>

        <section id="logos" class="brand-page-section" aria-labelledby="brand-logos-title">
            <p class="brand-eyebrow">01 / Assets</p>
            <h2 id="brand-logos-title"><?= $de ? 'Das passende Logo.' : 'The right mark.' ?></h2>
            <p class="brand-copy"><?= $de ? 'Skalierbare SVGs mit Schrift als Vektorpfaden: keine zusätzliche Schriftdatei nötig. Alle Varianten sind im Paket enthalten.' : 'Scalable SVGs with lettering converted to vector paths: no extra font file needed. Every variant is included in the kit.' ?></p>
            <div class="brand-assets-grid">
                <?php foreach ($assets as [$file, $label, $description, $dark, $icon]): ?>
                <article class="brand-asset">
                    <div class="brand-preview<?= $dark ? ' brand-preview-dark' : '' ?><?= $icon ? ' brand-preview-icon' : '' ?>">
                        <img src="<?= e(asset_url('/assets/brand/ternis-' . $file . '.svg')) ?>" alt="ternis.org — <?= e($label) ?>" loading="lazy" width="<?= $icon ? 589 : 1720 ?>" height="<?= $icon ? 421 : 430 ?>">
                    </div>
                    <div class="brand-asset-info">
                        <h3><?= e($label) ?></h3>
                        <p><?= e($description) ?></p>
                        <div class="brand-downloads">
                            <a href="/assets/brand/ternis-<?= e($file) ?>.svg" download><?= $de ? 'SVG herunterladen' : 'Download SVG' ?> &darr;</a>
                            <?php if (str_starts_with($file, 'wordmark-onecolor-')): ?>
                            <a href="/assets/brand/ternis-<?= e(str_replace('wordmark', 'icon', $file)) ?>.svg" download><?= $de ? 'Bildmarke als SVG' : 'Icon SVG' ?> &darr;</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
            <p class="brand-note"><?= $de ? 'Das Paket enthält außerdem das Favicon und editierbare Wortmarken. Die editierbaren Dateien benötigen Inter Display ExtraBold; für die direkte Verwendung empfehlen wir die oben gezeigten Vektorversionen.' : 'The kit also includes the favicon and editable wordmarks. The editable files require Inter Display ExtraBold; for direct use, choose the outlined versions shown above.' ?></p>
        </section>

        <section id="colors" class="brand-page-section" aria-labelledby="brand-colors-title">
            <p class="brand-eyebrow">02 / Palette</p>
            <h2 id="brand-colors-title"><?= $de ? 'Natürlich. Klar. Wiedererkennbar.' : 'Natural. Clear. Recognizable.' ?></h2>
            <div class="brand-palette">
                <?php foreach ($colors as [$name, $hex]): ?>
                <div class="brand-swatch">
                    <div class="brand-swatch-color" style="background: <?= e($hex) ?>;"></div>
                    <div class="brand-swatch-label"><strong><?= e($name) ?></strong><code><?= e($hex) ?></code></div>
                </div>
                <?php endforeach; ?>
            </div>
            <p class="brand-copy"><?= $de ? 'Die dunkle Variante nutzt #94B858, #A8CC6A und #789456 für das Zeichen sowie #F0F4EA für die Wortmarke auf #0F140D.' : 'The dark variant uses #94B858, #A8CC6A, and #789456 for the mark, with #F0F4EA lettering on #0F140D.' ?></p>
        </section>

        <section id="usage" class="brand-page-section" aria-labelledby="brand-usage-title">
            <p class="brand-eyebrow">03 / Guidelines</p>
            <h2 id="brand-usage-title"><?= $de ? 'Raum für die Marke.' : 'Give the mark room.' ?></h2>
            <div class="brand-guidelines">
                <div><h3><?= $de ? 'Abstand halten' : 'Leave clear space' ?></h3><p><?= $de ? 'Lass um das Logo mindestens so viel Platz wie die Höhe des kleinen „t“ in der Wortmarke. Verwende die Bildmarke, wenn der Platz für die Wortmarke nicht ausreicht.' : 'Leave at least the height of the lowercase “t” in the wordmark as clear space around the logo. Use the icon when the wordmark would be too small to read.' ?></p></div>
                <div><h3><?= $de ? 'Kontrast bewahren' : 'Keep it legible' ?></h3><p><?= $de ? 'Wähle die passende helle oder dunkle Variante auf einer ruhigen Fläche. Für einfarbige Anwendungen stehen Olive, Anthrazit, Creme und Weiß zur Verfügung.' : 'Choose the light or dark variant for a calm, contrasting background. Olive, charcoal, cream, and white versions are available for single-color use.' ?></p></div>
                <div><h3><?= $de ? 'Form erhalten' : 'Respect the artwork' ?></h3><p><?= $de ? 'Skaliere proportional. Verändere weder Farben noch Proportionen, drehe das Logo nicht und füge keine Schatten oder Effekte hinzu. Erwecke keinen Eindruck einer offiziellen Partnerschaft ohne entsprechende Vereinbarung.' : 'Scale proportionally. Keep the supplied colors and proportions, avoid rotation, and do not add shadows or effects. Do not imply an official partnership without an agreement.' ?></p></div>
            </div>
        </section>
    </div>
</div>
