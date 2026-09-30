<?php
/**
 * disclaimer.php — Full disclaimer text page.
 */

declare(strict_types=1);

require __DIR__ . '/config.php';
require __DIR__ . '/includes/bootstrap.php';

security_headers();

$currentPageFile = 'disclaimer.php';

require __DIR__ . '/includes/nav.php';
require __DIR__ . '/includes/disclaimer-text.php';

$bodyClass       = 'page-legal';
$transparent     = false;
$showModal       = false;
$pageTitle       = 'Disclaimer | ' . SITE_NAME;
$pageDesc        = 'The legal disclaimer for the website of Adv. Javed Pashu Sayyed, advocate and litigator.';
$canonical       = SITE_URL . '/disclaimer.php';

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main" class="legal-page">
    <div class="container legal-container">

        <nav class="legal-breadcrumb" aria-label="Breadcrumb">
            <a href="./">Home</a>
            <span aria-hidden="true">&rsaquo;</span>
            <span aria-current="page">Disclaimer</span>
        </nav>

        <h1>Disclaimer</h1>
        <p class="legal-lead"><?= e($disclaimerLead) ?></p>

        <p><?= e($disclaimerIntro) ?></p>

        <h2>What this website is</h2>
        <p>
            This website is an informational resource. It describes the practice of Adv. Javed Pashu Sayyed
            and the matters in which the chamber offers assistance. It is not legal advice, and it is not
            an offer of any legal services.
        </p>

        <h2>No lawyer&ndash;client relationship</h2>
        <ul>
            <?php foreach ($disclaimerPoints as $point): ?>
                <li><?= e($point) ?></li>
            <?php endforeach; ?>
        </ul>

        <h2>Confidential information</h2>
        <p>
            You should not send confidential or privileged information through this website or to the
            chamber&rsquo;s email address unless an engagement has been confirmed in writing. Until an
            engagement is confirmed, information you provide may not be protected by privilege.
        </p>

        <h2>Legal advice</h2>
        <p>
            Legal issues depend on their specific facts. Nothing on this website should be relied upon as
            advice on any particular matter. If you have a specific legal issue, you should seek independent
            legal advice.
        </p>

        <p class="legal-closing">Adv. Javed Pashu Sayyed&nbsp;&mdash;&nbsp;The Chamber, District &amp; Sessions Court Pune.</p>
    </div>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>