<?php
/**
 * includes/practice-page.php — Shared template for a single practice-area page.
 *
 * Each public page (e.g. criminal-lawyer-pune.php) sets $practiceSlug and
 * requires this file. Content lives in includes/practice-data.php.
 */

declare(strict_types=1);

require __DIR__ . '/../config.php';
require __DIR__ . '/bootstrap.php';
require __DIR__ . '/practice-data.php';

if (!isset($practiceSlug, $practicePages[$practiceSlug])) {
    http_response_code(404);
    exit('Not found');
}

security_headers();

$page            = $practicePages[$practiceSlug];
$currentPageFile = $practiceSlug . '.php';

require __DIR__ . '/nav.php';
require __DIR__ . '/disclaimer-text.php';

$bodyClass   = 'page-legal page-practice';
$transparent = false;
/* Visitors often land here straight from Google, so they see the disclaimer too. */
$showModal   = true;
$pageTitle   = $page['title'];
$pageDesc    = $page['desc'];
$canonical   = SITE_URL . '/' . $practiceSlug . '.php';

/* Extra JSON-LD for this page: breadcrumb, the service described, and FAQs. */
$extraSchema = [
    [
        '@type'           => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => SITE_URL . '/'],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Practice areas', 'item' => SITE_URL . '/#practice'],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $page['h1'], 'item' => $canonical],
        ],
    ],
    [
        '@type'       => 'Service',
        'name'        => $page['h1'],
        'serviceType' => $page['name'],
        'description' => $page['desc'],
        'provider'    => ['@id' => SITE_URL . '/#person'],
        'areaServed'  => [
            ['@type' => 'City', 'name' => 'Pune'],
            ['@type' => 'State', 'name' => 'Maharashtra'],
        ],
        'url'         => $canonical,
    ],
];
if (!empty($page['faqs'])) {
    $extraSchema[] = [
        '@type'      => 'FAQPage',
        'mainEntity' => array_map(
            static fn(string $q, string $a): array => [
                '@type'          => 'Question',
                'name'           => $q,
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $a],
            ],
            array_keys($page['faqs']),
            array_values($page['faqs'])
        ),
    ];
}

require __DIR__ . '/head.php';
require __DIR__ . '/header.php';
require __DIR__ . '/disclaimer-modal.php';
?>
<main id="main" class="legal-page">
    <div class="container legal-container">

        <nav class="legal-breadcrumb" aria-label="Breadcrumb">
            <a href="./">Home</a>
            <span aria-hidden="true">&rsaquo;</span>
            <a href="./#practice">Practice areas</a>
            <span aria-hidden="true">&rsaquo;</span>
            <span aria-current="page"><?= e($page['name']) ?></span>
        </nav>

        <p class="label label--gold">Adv. Javed Pashu Sayyed &middot; Advocate, Pune</p>
        <h1><?= e($page['h1']) ?></h1>
        <p class="practice-lead"><?= e($page['lead']) ?></p>

        <?php foreach ($page['sections'] as $heading => $body): ?>
            <h2><?= e($heading) ?></h2>
            <?php if (isset($body['list'])): ?>
                <ul>
                    <?php foreach ($body['list'] as $item): ?>
                        <li><?= e($item) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <?php foreach ($body as $para): ?>
                    <p><?= e($para) ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>

        <?php if (!empty($page['faqs'])): ?>
            <h2>Frequently asked questions</h2>
            <div class="faq-list">
                <?php foreach ($page['faqs'] as $q => $a): ?>
                    <details class="faq-item">
                        <summary><?= e($q) ?></summary>
                        <p><?= e($a) ?></p>
                    </details>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <aside class="practice-cta" aria-label="Request an appointment">
            <p class="practice-cta-title">Consultations by appointment</p>
            <p>
                <?php foreach (OFFICE_ADDRESS_LINES as $line): ?>
                    <?= e($line) ?><br>
                <?php endforeach; ?>
                <?= e(OFFICE_HOURS) ?>
            </p>
            <a class="btn btn-primary" href="./#contact">Request an appointment</a>
        </aside>

        <h2>Other areas of practice</h2>
        <ul class="related-list">
            <?php foreach ($practicePages as $slug => $other): ?>
                <?php if ($slug !== $practiceSlug): ?>
                    <li><a href="<?= e($slug) ?>.php"><?= e($other['h1']) ?></a></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>

        <p class="legal-closing">
            This page gives general information about the law and is not legal advice. See the
            <a href="disclaimer.php">disclaimer</a>.
        </p>
    </div>
</main>
<?php require __DIR__ . '/footer.php'; ?>
