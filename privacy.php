<?php
/**
 * privacy.php — Privacy policy.
 */

declare(strict_types=1);

require __DIR__ . '/config.php';
require __DIR__ . '/includes/bootstrap.php';

security_headers();

$currentPageFile = 'privacy.php';

require __DIR__ . '/includes/nav.php';

$bodyClass       = 'page-legal';
$transparent     = false;
$showModal       = false;
$pageTitle       = 'Privacy Policy | ' . SITE_NAME;
$pageDesc        = 'Privacy policy for the website of Adv. Javed Pashu Sayyed, advocate and litigator.';
$canonical       = SITE_URL . '/privacy.php';

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main" class="legal-page">
    <div class="container legal-container">

        <nav class="legal-breadcrumb" aria-label="Breadcrumb">
            <a href="./">Home</a>
            <span aria-hidden="true">&rsaquo;</span>
            <span aria-current="page">Privacy Policy</span>
        </nav>

        <h1>Privacy Policy</h1>
        <p class="legal-lead">Last updated: January 2026</p>

        <h2>Scope</h2>
        <p>
            This policy explains what information this website collects and how it is used. It applies to
            the website of Adv. Javed Pashu Sayyed (&ldquo;the chamber&rdquo;).
        </p>

        <h2>Information you submit</h2>
        <p>
            When you use the enquiry form, the chamber receives your name, email address, telephone number,
            the area of law you select, your subject and your message. This information is used solely to
            respond to your enquiry and, if the enquiry proceeds, to establish the engagement.
        </p>

        <h2>Information collected automatically</h2>
        <p>
            The website does not run analytics scripts by default. A single session cookie is used to protect
            the enquiry form against cross-site request forgery (CSRF). This cookie is strictly functional
            and does not identify you for marketing purposes.
        </p>

        <h2>Handling and retention</h2>
        <p>
            Enquiries are received by email at the chamber&rsquo;s correspondence address. They are retained
            as part of ordinary professional correspondence. Your information is not sold, rented or shared
            with third parties for marketing.
        </p>

        <h2>Security</h2>
        <p>
            Reasonable technical measures are applied to the enquiry form, including CSRF protection,
            input validation and rate limiting. No transmission over the internet is completely secure, and
            the chamber cannot guarantee the security of information sent to it.
        </p>

        <h2>Your rights</h2>
        <p>
            You may ask the chamber to update or delete the personal information you have submitted through
            this website. To do so, write to <a href="mailto:<?= e(EMAIL_MAILTO) ?>"><?= e(EMAIL_DISPLAY) ?></a>.
        </p>

        <h2>Changes to this policy</h2>
        <p>
            This policy may be updated from time to time. Changes will be posted on this page.
        </p>
    </div>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>