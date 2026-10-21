<?php
/** Theme-aware official artwork. Pass variant="icon" for the standalone mark. */
$variant = ($variant ?? 'wordmark') === 'icon' ? 'icon' : 'wordmark';
?>
<span class="brand-art brand-art-<?= e($variant) ?>">
    <img class="brand-light" src="<?= e(asset_url('/assets/brand/ternis-' . $variant . '-light.svg')) ?>" width="<?= $variant === 'icon' ? 589 : 1720 ?>" height="<?= $variant === 'icon' ? 421 : 430 ?>" alt="ternis.org">
    <img class="brand-dark" src="<?= e(asset_url('/assets/brand/ternis-' . $variant . '-dark.svg')) ?>" width="<?= $variant === 'icon' ? 589 : 1720 ?>" height="<?= $variant === 'icon' ? 421 : 430 ?>" alt="ternis.org">
</span>
