<?php
/**
 * terms.php — Terms of use.
 */

declare(strict_types=1);

require __DIR__ . '/config.php';
require __DIR__ . '/includes/bootstrap.php';

security_headers();

$currentPageFile = 'terms.php';

require __DIR__ . '/includes/nav.php';

$bodyClass       = 'page-legal';
$transparent     = false;
$showModal       = false;
$pageTitle       = 'Terms of Use | ' . SITE_NAME;
$pageDesc        = 'Terms of use for the website of Adv. Javed Pashu Sayyed, advocate and litigator.';
$canonical       = SITE_URL . '/terms.php';

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main" class="legal-page">
    <div class="container legal-container">

        <nav class="legal-breadcrumb" aria-label="Breadcrumb">
            <a href="./">Home</a>
            <span aria-hidden="true">&rsaquo;</span>
            <span aria-current="page">Terms of Use</span>
        </nav>

        <h1>Terms of Use</h1>
        <p class="legal-lead">Last updated: January 2026</p>

        <h2>Acceptance</h2>
        <p>
            By accessing this website you accept these terms of use. If you do not agree with them, please do
            not use the website.
        </p>

        <h2>Informational purpose</h2>
        <p>
            This website is maintained for general information only. It does not constitute legal advice, and
            it does not create a lawyer&ndash;client relationship between you and the chamber. No reliance
            should be placed on the contents of this website for any specific matter.
        </p>

        <h2>No solicitation</h2>
        <p>
            The rules of the Bar Council of India prohibit advocates from soliciting work or advertising.
            This website is not intended as solicitation or advertising, and its use is at the visitor&rsquo;s
            own request and volition.
        </p>

        <h2>Intellectual property</h2>
        <p>
            The text, design, layout and code of this website are the property of, or are used under licence by,
            the chamber, unless stated otherwise. You may not reproduce or redistribute the content for
            commercial purposes without prior written consent.
        </p>

        <h2>Links and third-party content</h2>
        <p>
            The website may contain links to external resources. The chamber is not responsible for the
            content or practices of any third-party website.
        </p>

        <h2>Limitation of liability</h2>
        <p>
            The chamber accepts no liability for any loss or damage arising out of, or in connection with, the
            use of this website or the information contained in it. You use the website at your own risk.
        </p>

        <h2>Governing law</h2>
        <p>
            These terms are governed by the laws of India. Any dispute concerning this website is subject to
            the jurisdiction of the courts at Pune.
        </p>
    </div>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>