<?php
/**
 * includes/header.php — Site header: skip link, sticky navigation.
 *
 * Expected variables:
 *   $showModal    bool   include the legal disclaimer modal (index only)
 *   $transparent  bool   if true the header starts transparent over the hero
 */

if (!defined('SITE_NAME')) {
    http_response_code(403);
    exit('Forbidden');
}

$transparent = $transparent ?? false;
?>
<a class="skip-link" href="#main">Skip to content</a>

<header class="site-header<?= $transparent ? ' site-header--top' : '' ?>" id="siteHeader">
    <div class="container header-inner">

        <a class="brand" href="<?= e(($currentPageFile ?? 'index.php') === 'index.php' ? '' : 'index.php') ?>#home" aria-label="<?= e(SITE_NAME) ?> — home">
            <img class="brand-mark" src="assets/images/logo-official.jpg" alt="" aria-hidden="true" width="44" height="44">
            <span class="brand-text">
                <span class="brand-name">Adv. Javed Pashu Sayyed</span>
                <span class="brand-tag">Advocate · Litigator · Legal Advisor</span>
            </span>
        </a>

        <nav class="site-nav" id="siteNav" aria-label="Primary">
            <ul class="nav-list">
                <?php foreach ($primaryNav as $item): ?>
                    <li><a class="nav-link" href="<?= e($item['href']) ?>" data-navlink><span><?= e($item['label']) ?></span></a></li>
                <?php endforeach; ?>
                <li class="nav-cta-mobile">
                    <a class="btn btn-primary btn-block" href="<?= e($navPrefix) ?>#contact">Request an Appointment</a>
                </li>
            </ul>
            <p class="nav-foot" aria-hidden="true">Adv. Javed Pashu Sayyed — The Chamber</p>
        </nav>

        <div class="header-actions">
            <a class="btn btn-primary nav-cta" href="<?= e($navPrefix) ?>#contact">Request an Appointment</a>
            <button class="nav-toggle" id="navToggle" type="button" aria-expanded="false" aria-controls="siteNav" aria-label="Open menu">
                <span class="nav-toggle-bar"></span>
                <span class="nav-toggle-bar"></span>
                <span class="nav-toggle-bar"></span>
            </button>
        </div>

    </div>
</header>