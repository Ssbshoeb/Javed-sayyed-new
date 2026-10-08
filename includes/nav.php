<?php
if (!defined('SITE_NAME')) { http_response_code(403); exit('Forbidden'); }
$navPrefix = (($currentPageFile ?? 'index.php') === 'index.php') ? '' : './';
$primaryNav = [
    ['label' => 'Home',     'href' => $navPrefix . '#home',     'index' => true],
    ['label' => 'About',    'href' => $navPrefix . '#about',    'index' => true],
    ['label' => 'Practice', 'href' => $navPrefix . '#practice', 'index' => true],
    ['label' => 'Courts',   'href' => $navPrefix . '#courts',   'index' => true],
    ['label' => 'Approach', 'href' => $navPrefix . '#approach', 'index' => true],
    ['label' => 'Media',    'href' => './media.php',            'index' => false],
    ['label' => 'Contact',  'href' => $navPrefix . '#contact',  'index' => true],
];

