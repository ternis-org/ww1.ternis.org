<?php
/** Official artwork; inverse surfaces can request inverted, monochrome variants. */
$variant = ($variant ?? 'wordmark') === 'icon' ? 'icon' : 'wordmark';
$lightArtwork = !empty($monochrome) ? 'onecolor-charcoal' : 'light';
$darkArtwork = !empty($monochrome) ? 'onecolor-cream' : 'dark';
if (!empty($inverted)) {
    [$lightArtwork, $darkArtwork] = [$darkArtwork, $lightArtwork];
}
?>
<span class="brand-art brand-art-<?= e($variant) ?>">
    <img class="brand-light" src="<?= e(asset_url('/assets/brand/ternis-' . $variant . '-' . $lightArtwork . '.svg')) ?>" width="<?= $variant === 'icon' ? 589 : 1720 ?>" height="<?= $variant === 'icon' ? 421 : 430 ?>" alt="ternis.org">
    <img class="brand-dark" src="<?= e(asset_url('/assets/brand/ternis-' . $variant . '-' . $darkArtwork . '.svg')) ?>" width="<?= $variant === 'icon' ? 589 : 1720 ?>" height="<?= $variant === 'icon' ? 421 : 430 ?>" alt="ternis.org">
</span>
