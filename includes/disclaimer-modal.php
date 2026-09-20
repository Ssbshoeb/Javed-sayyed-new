<?php
/**
 * includes/disclaimer-modal.php — Full-screen legal disclaimer overlay.
 * Only included on the home page. See README for how to modify the wording.
 */

if (!defined('SITE_NAME')) {
    http_response_code(403);
    exit('Forbidden');
}
?>
<div class="disclaimer-overlay" id="disclaimerModal" role="dialog" aria-modal="true" aria-labelledby="disclaimerTitle" aria-describedby="disclaimerText">
    <div class="disclaimer-card" tabindex="-1">

        <div class="disclaimer-card-head">
            <p class="label label--gold">The Rules of the Bar Council of India</p>
            <p class="disclaimer-title" id="disclaimerTitle">Disclaimer</p>
            <p class="disclaimer-lead"><?= e($disclaimerLead) ?></p>
        </div>

        <div class="disclaimer-body" id="disclaimerText">
            <p class="disclaimer-intro"><?= e($disclaimerIntro) ?></p>
            <ul class="disclaimer-points">
                <?php foreach ($disclaimerPoints as $point): ?>
                    <li><?= e($point) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="disclaimer-actions">
            <button type="button" class="btn btn-ghost" id="disclaimerDecline">Decline</button>
            <button type="button" class="btn btn-primary" id="disclaimerAccept">I Agree</button>
        </div>

        <p class="disclaimer-message" id="disclaimerMessage" role="alert" hidden>
            The website cannot be accessed without accepting the disclaimer.
        </p>

        <noscript>
            <p class="disclaimer-message" style="display:block">
                JavaScript is required to accept the disclaimer and view the website.
            </p>
        </noscript>

    </div>
</div>