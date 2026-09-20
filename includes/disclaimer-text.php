<?php
/**
 * includes/disclaimer-text.php — The legal disclaimer body text.
 * Shared by the index-page overlay and the /disclaimer.php page.
 */

if (!defined('SITE_NAME')) {
    http_response_code(403);
    exit('Forbidden');
}

$disclaimerLead = 'Please read carefully before proceeding.';

$disclaimerIntro = 'The rules of the Bar Council of India prohibit advocates from soliciting work or '
    . "advertising in any manner. This website has been prepared as an informational resource and is "
    . "made available only at the visitor's own request.";

$disclaimerPoints = [
    'This website contains general information only and does not constitute legal advice.',
    'Browsing or using this website does not create, and is not intended to create, an advocate–client relationship.',
    'The information is provided at the visitor’s own volition; any transmission, receipt or use of this website is entirely at the visitor’s choice.',
    'Nothing on this website constitutes solicitation, advertisement, or an invitation to offer or accept legal services.',
    'The chamber is not responsible for any consequence of action taken by a visitor relying on the information contained on this website.',
    'Visitors who have a specific legal issue should in all cases seek independent legal advice.',
    'Please do not submit confidential or privileged material through this website unless an engagement has been confirmed in writing.',
];