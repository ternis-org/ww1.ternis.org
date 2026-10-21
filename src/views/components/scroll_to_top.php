<?php

declare(strict_types=1);

/**
 * Reusable Back-to-Top Button
 */
?>
<!-- Back-to-top button; reading progress is shown once at the top edge. -->
<div class="scroll-top-tracker">
    <button type="button" id="scroll-to-top" class="scroll-to-top" aria-label="<?= current_lang() === 'de' ? 'Nach oben' : 'Back to top' ?>" title="<?= current_lang() === 'de' ? 'Nach oben' : 'Back to top' ?>">
        <svg class="scroll-arrow-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M12 19V5M5 12l7-7 7 7"/>
        </svg>
    </button>
</div>
