<?php
/**
 * contact.php — Secure handler for the enquiry form.
 *
 * - Server-side validation (required fields, email format)
 * - CSRF protection
 * - Honeypot anti-spam field
 * - Input sanitisation and header-injection prevention
 * - Simple rate limiting (no database required)
 * - Sends the enquiry via mail() with a clear structure for later SMTP
 * - Returns JSON for AJAX requests; redirects with a flash for no-JS fallback
 * - Never exposes PHP errors to the visitor
 */

declare(strict_types=1);

require __DIR__ . '/config.php';
require __DIR__ . '/includes/bootstrap.php';

security_headers();

/* A plain GET resolves to the contact section of the home page. */
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Location: index.php#contact', true, 303);
    exit;
}

ensure_session();

/* Decide the response mode up front. */
$wantsJson = stripos($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '', 'xmlhttprequest') !== false
    || strtolower($_SERVER['HTTP_ACCEPT'] ?? '') === 'application/json';

/** Emit the result either as JSON (AJAX) or as a redirect (no-JS). */
function respond(array $result): void
{
    global $wantsJson;

    if ($wantsJson) {
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    if (!empty($result['ok'])) {
        header('Location: index.php?sent=1#contact', true, 303);
    } else {
        $reason = $result['reason'] ?? 'invalid';
        header('Location: index.php?error=' . rawurlencode($reason) . '#contact', true, 303);
    }
    exit;
}

$input = $_POST;

/* ---- Honeypot: a real user never fills this in. ---- */
if (isset($input['company_website']) && trim((string)$input['company_website']) !== '') {
    /* Pretend success so bots learn nothing. */
    respond(['ok' => true, 'reason' => null]);
}

/* ---- Rate limiting. ---- */
if (!rate_limit_ok()) {
    respond([
        'ok'     => false,
        'reason' => 'rate',
        'error'  => 'Too many submissions from this connection. Please try again later.',
    ]);
}

/* ---- CSRF. ---- */
if (!verify_csrf($input['csrf_token'] ?? null)) {
    respond([
        'ok'     => false,
        'reason' => 'csrf',
        'error'  => 'The form token has expired. Please refresh the page and try again.',
    ]);
}

/* ---- Collect & sanitise. ---- */
$d = [
    'name'      => clean_text($input['name'] ?? '', 120),
    'email'     => clean_text($input['email'] ?? '', 254),
    'telephone' => clean_text($input['telephone'] ?? '', 30),
    'area'      => in_array($input['area'] ?? '', AREAS_OF_LAW, true) ? $input['area'] : '',
    'subject'   => clean_text($input['subject'] ?? '', 200),
    'message'   => clean_message($input['message'] ?? '', 4000),
    'consent'   => isset($input['consent']),
];

/* ---- Validation. ---- */
$errors = [];

if ($d['name'] === '') {
    $errors[] = 'your full name';
}
if ($d['email'] === '' || !valid_email($d['email'])) {
    $errors[] = 'a valid email address';
}
if ($d['telephone'] !== '' && preg_match('/\d/', $d['telephone']) === 0) {
    $errors[] = 'a telephone number containing digits';
}
if ($d['subject'] === '') {
    $errors[] = 'a subject';
}
if ($d['message'] === '') {
    $errors[] = 'a message';
}
if (!$d['consent']) {
    $errors[] = 'acceptance of the disclaimer';
}

if ($errors !== []) {
    respond([
        'ok'     => false,
        'reason' => 'invalid',
        'error'  => 'The form is missing: ' . implode(', ', $errors) . '.',
    ]);
}

/* ---- Send. ---- */
$result = send_enquiry($d);
respond($result);