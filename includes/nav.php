<?php
/**
 * includes/nav.php — Primary navigation items shared by header and footer.
 */

if (!defined('SITE_NAME')) {
    http_response_code(403);
    exit('Forbidden');
}

/* Anchor links resolve to the current page on the home page, and to the home
 * page itself when the current page is a legal sub-page. */
$navPrefix = (($currentPageFile ?? 'index.php') === 'index.php') ? '' : './';

$primaryNav = [
    ['label' => 'Home',     'href' => $navPrefix . '#home',     'index' => true],
    ['label' => 'About',    'href' => $navPrefix . '#about',    'index' => true],
    ['label' => 'Practice', 'href' => $navPrefix . '#practice', 'index' => true],
    ['label' => 'Courts',   'href' => $navPrefix . '#courts',   'index' => true],
    ['label' => 'Approach', 'href' => $navPrefix . '#approach', 'index' => true],
    ['label' => 'Contact',  'href' => $navPrefix . '#contact',  'index' => true],
];

/* Footer footer navigation — anchors work on the home page and degrade to the
 * 'about' anchor targets on the legal sub-pages (kept unchanged). */