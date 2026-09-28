<?php
/**
 * includes/head.php — Document head: metadata, SEO, Open Graph, fonts, CSS, JSON-LD.
 *
 * Expected variables (set by the including page before this include):
 *   $pageTitle    string  document <title>
 *   $pageDesc     string  meta description
 *   $canonical    string  canonical URL
 *   $pageType     string  'website' (default) or 'article'
 *   $bodyClass    string  optional extra class(es) for <body>
 *   $showModal    bool    whether the legal disclaimer modal is present on this page
 */

if (!defined('SITE_NAME')) {
    http_response_code(403);
    exit('Forbidden');
}

$pageTitle = $pageTitle ?? SITE_TITLE_BASE;
$pageDesc  = $pageDesc ?? SITE_DESC;
$canonical = $canonical ?? SITE_URL . '/';
$pageType  = $pageType ?? 'website';
$bodyClass = $bodyClass ?? '';

/* JSON-LD — Person schema. Only verified factual information is included.
 * No ratings, reviews or legal-service claims are fabricated. */
$personSchema = [
    '@context'    => 'https://schema.org',
    '@type'       => 'Person',
    'name'        => 'Javed Pashu Sayyed',
    'honorificPrefix' => 'Adv.',
    'jobTitle'    => SITE_TAGLINE,
    'url'         => SITE_URL,
    'image'       => SITE_URL . '/assets/images/javed-pashu-sayyed.jpg',
    'email'       => 'adv.syedhc@gmail.com',
    'address'     => [
        '@type'           => 'PostalAddress',
        'streetAddress'   => 'Chamber No. 52/B, District & Sessions Court Pune, Chhatrapati Shivaji Maharaj Rd, Shivajinagar',
        'addressLocality' => 'Pune',
        'addressRegion'   => 'Maharashtra',
        'postalCode'      => '411005',
        'addressCountry'  => 'IN',
    ],
    'knowsAbout'  => array_merge(['Litigation'], AREAS_OF_LAW),
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<meta name="format-detection" content="telephone=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?= e($pageTitle) ?></title>
<meta name="description" content="<?= e($pageDesc) ?>">
<meta name="robots" content="index, follow, max-image-preview:large">
<link rel="canonical" href="<?= e($canonical) ?>">

<!-- Open Graph -->
<meta property="og:type" content="<?= e($pageType) ?>">
<meta property="og:site_name" content="<?= e(SITE_NAME) ?>">
<meta property="og:locale" content="en_IN">
<meta property="og:title" content="<?= e($pageTitle) ?>">
<meta property="og:description" content="<?= e($pageDesc) ?>">
<meta property="og:url" content="<?= e($canonical) ?>">
<meta property="og:image" content="<?= e(SITE_URL) ?>/assets/images/og-cover.jpg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="Adv. Javed Pashu Sayyed — Advocate, Litigator, Legal Advisor">

<!-- Twitter / X -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= e($pageTitle) ?>">
<meta name="twitter:description" content="<?= e($pageDesc) ?>">
<meta name="twitter:image" content="<?= e(SITE_URL) ?>/assets/images/og-cover.jpg">

<meta name="theme-color" content="#111310">

<!-- Favicon -->
<link rel="icon" type="image/png" sizes="32x32" href="assets/icons/favicon-32.png">
<link rel="apple-touch-icon" href="assets/icons/apple-touch-icon.png">

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:ital,opsz,wght@0,8..60,400;0,8..60,500;0,8..60,600;1,8..60,400&family=Source+Sans+3:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- Styles -->
<link rel="stylesheet" href="assets/css/style.css">

<!-- Preload the hero portrait placeholder so the hero paints quickly. -->
<link rel="preload" as="image" href="<?= e(PORTRAIT_SRC) ?>" fetchpriority="high">

<script type="application/ld+json"><?= json_encode($personSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?></script>
</head>
<body class="<?= e($bodyClass) ?>">