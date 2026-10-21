<?php

declare(strict_types=1);

/**
 * Official artwork; inverse surfaces can request inverted, monochrome variants.
 * An optional 'inline' flag renders the SVG paths directly into the document so
 * the load-in reveal ("the tern unfolds") can animate the individual leaves.
 * @var 'icon'|'wordmark' $variant
 * @var bool $inverted
 * @var bool $monochrome
 * @var bool $inline
 */

$variant = ($variant ?? 'wordmark') === 'icon' ? 'icon' : 'wordmark';
$lightArtwork = !empty($monochrome) ? 'onecolor-charcoal' : 'light';
$darkArtwork = !empty($monochrome) ? 'onecolor-cream' : 'dark';
if (!empty($inverted)) {
    [$lightArtwork, $darkArtwork] = [$darkArtwork, $lightArtwork];
}

/**
 * Prepares one artwork SVG for inline rendering and adds animation hook classes:
 * the three mark paths (stem + two leaves) and the letter group of the wordmark.
 */
$ternInlineArt = function (string $file): ?string {
    $svg = @file_get_contents(ROOT_PATH . '/public/assets/brand/' . $file);
    if ($svg === false || !str_contains($svg, '<svg')) {
        return null;
    }

    // The three mark paths are the only ones carrying a fill attribute.
    $n = 0;
    $names = ['brand-leaf-1', 'brand-leaf-2', 'brand-stem'];
    $svg = preg_replace_callback('/<path fill="/', function ($m) use (&$n, $names) {
        $name = $names[$n] ?? 'brand-stem';
        $n++;
        return '<path class="' . $name . '" fill="';
    }, $svg, 3) ?? $svg;
    if ($n !== 3) {
        return null; // Unexpected artwork structure — safer to fall back to <img>.
    }

    // The wordmark's letter group is the single <g fill="..."> (paths inherit its fill).
    $svg = str_replace('<g fill=', '<g class="brand-letters" fill=', $svg);

    return $svg;
};

$ternArtFile = fn (string $variant, string $art): string => 'ternis-' . $variant . '-' . $art . '.svg';
$light = !empty($inline) ? $ternInlineArt($ternArtFile($variant, $lightArtwork)) : null;
$dark = !empty($inline) ? $ternInlineArt($ternArtFile($variant, $darkArtwork)) : null;
?>
<?php if ($light !== null && $dark !== null): ?>
<span class="brand-art brand-art-<?= e($variant) ?> brand-inline-art">
    <span class="brand-inline brand-light"><?= $light ?></span>
    <span class="brand-inline brand-dark"><?= $dark ?></span>
</span>
<?php else: ?>
<span class="brand-art brand-art-<?= e($variant) ?>">
    <img class="brand-light" src="<?= e(asset_url('/assets/brand/' . $ternArtFile($variant, $lightArtwork))) ?>" width="<?= $variant === 'icon' ? 589 : 1720 ?>" height="<?= $variant === 'icon' ? 421 : 430 ?>" alt="ternis.org">
    <img class="brand-dark" src="<?= e(asset_url('/assets/brand/' . $ternArtFile($variant, $darkArtwork))) ?>" width="<?= $variant === 'icon' ? 589 : 1720 ?>" height="<?= $variant === 'icon' ? 421 : 430 ?>" alt="ternis.org">
</span>
<?php endif; ?>
