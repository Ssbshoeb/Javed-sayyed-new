<?php
/**
 * includes/bootstrap.php — Shared helpers: escaping, CSRF, honeypot,
 * validation, rate limiting, security headers and the enquiry mailer.
 *
 * Direct include is not allowed; always reached via index.php or a sub-page.
 */

declare(strict_types=1);

if (!defined('SITE_NAME')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ------------------------------------------------------------------ */
/* Output escaping                                                     */
/* ------------------------------------------------------------------ */

/** Escape a value for safe output inside HTML. */
function e(?string $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/* ------------------------------------------------------------------ */
/* Sessions & CSRF                                                     */
/* ------------------------------------------------------------------ */

function is_https(): bool
{
    return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['SERVER_PORT'] ?? '') === '443')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
}

function ensure_session(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_name('advchamber_sess');
        session_set_cookie_params([
            'lifetime' => 0,
            'path'     => '/',
            'secure'   => is_https(),
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        session_start();
    }
}

/** Create (or reuse) the CSRF token for the current session. */
function csrf_token(): string
{
    ensure_session();
    if (empty($_SESSION['csrf_token']) || !is_string($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/** Hidden CSRF field for forms. */
function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function verify_csrf(?string $token): bool
{
    ensure_session();
    $stored = $_SESSION['csrf_token'] ?? null;
    return is_string($stored) && is_string($token)
        && $token !== '' && hash_equals($stored, $token);
}

/* ------------------------------------------------------------------ */
/* Honeypot                                                            */
/* ------------------------------------------------------------------ */

/** Hidden anti-bot field. Real users never see or fill it. */
function honeypot_field(): string
{
    return '<div class="hp-wrap" aria-hidden="true">'
        . '<label for="hp_company">Leave this field empty</label>'
        . '<input type="text" id="hp_company" name="company_website" tabindex="-1" autocomplete="off">'
        . '</div>';
}

/* ------------------------------------------------------------------ */
/* Validation & sanitisation                                           */
/* ------------------------------------------------------------------ */

function valid_email(?string $email): bool
{
    return is_string($email)
        && strlen($email) <= 254
        && filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Sanitise free text. Removes control characters. CR/LF are converted to
 * spaces, which prevents header injection when the value is later used in
 * mail() header strings.
 */
function clean_text(?string $value, int $max = 2000): string
{
    $value = trim((string)$value);
    if ($value === '') {
        return '';
    }
    $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $value) ?? '';
    $value = str_replace(["\r", "\n"], ' ', $value);
    return mb_substr($value, 0, $max);
}

/** Like clean_text() but preserves line breaks (used for the message body only). */
function clean_message(?string $value, int $max = 4000): string
{
    $value = trim((string)$value);
    if ($value === '') {
        return '';
    }
    $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $value) ?? '';
    $value = preg_replace('/\r\n?/', "\n", $value);
    return mb_substr($value, 0, $max);
}

/* ------------------------------------------------------------------ */
/* Rate limiting (simple, file-based; no database required)            */
/* ------------------------------------------------------------------ */

function rate_limit_ok(): bool
{
    $ip   = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $file = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR)
        . DIRECTORY_SEPARATOR . 'advchamber_rl_' . sha1('adv' . $ip) . '.lock';

    $fp = @fopen($file, 'c+');
    if ($fp === false) {
        /* Cannot open a lock file — do not block legitimate users. */
        return true;
    }

    $ok = true;
    if (flock($fp, LOCK_EX)) {
        $now     = time();
        $raw     = '';
        while (!feof($fp)) {
            $raw .= fread($fp, 4096);
        }
        $data    = $raw !== '' ? json_decode($raw, true) : null;
        if (!is_array($data)) {
            $data = ['count' => 0, 'first' => $now];
        }
        if (($now - (int)($data['first'] ?? $now)) > RATE_LIMIT_WINDOW_SECONDS) {
            $data = ['count' => 0, 'first' => $now];
        }
        $data['count'] = (int)($data['count'] ?? 0) + 1;
        $ok = $data['count'] <= RATE_LIMIT_MAX_PER_WINDOW;

        ftruncate($fp, 0);
        rewind($fp);
        fwrite($fp, json_encode($data));
        fflush($fp);
        flock($fp, LOCK_UN);
    }
    fclose($fp);
    return $ok;
}

/* ------------------------------------------------------------------ */
/* Security headers                                                    */
/* ------------------------------------------------------------------ */

function security_headers(): void
{
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
    header(
        "Content-Security-Policy: "
        . "default-src 'self'; "
        . "img-src 'self' data:; "
        . "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; "
        . "font-src 'self' https://fonts.gstatic.com; "
        . "script-src 'self'; "
        . "connect-src 'self'; "
        . "base-uri 'self'; "
        . "form-action 'self'; "
        . "frame-ancestors 'self'"
    );
}

/* ------------------------------------------------------------------ */
/* Mailer                                                              */
/* ------------------------------------------------------------------ */

/**
 * Send the enquiry email using PHP's mail() function.
 *
 * A more robust transport (SMTP via PHPMailer) can be added later without
 * changing anything in the frontend: implement send_enquiry() the same way
 * and keep the return contract ['ok' => bool, 'error' => ?string].
 */
function send_enquiry(array $d): array
{
    $to      = MAIL_TO;
    $from    = MAIL_FROM_ADDRESS;
    $subject = 'Chamber enquiry — ' . ($d['area'] !== '' ? $d['area'] : 'Not specified')
        . ' (via ' . (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'website') . ')';

    $body  = "A new enquiry was submitted through the website.\r\n";
    $body .= str_repeat('-', 48) . "\r\n";
    $body .= "Full name : " . $d['name'] . "\r\n";
    $body .= "Email     : " . $d['email'] . "\r\n";
    $body .= "Telephone : " . $d['telephone'] . "\r\n";
    $body .= "Area      : " . $d['area'] . "\r\n";
    $body .= "Subject   : " . $d['subject'] . "\r\n";
    $body .= str_repeat('-', 48) . "\r\n";
    $body .= "Message:\r\n" . $d['message'] . "\r\n";
    $body .= str_repeat('-', 48) . "\r\n";
    $body .= "Sent: " . date('d M Y H:i:s T') . "\r\n";
    $body .= "IP  : " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . "\r\n";

    $headers = [
        'From: ' . MAIL_FROM_NAME . ' <' . $from . '>',
        'Reply-To: ' . ($d['name'] !== '' ? $d['name'] : 'Enquirer') . ' <' . $d['email'] . '>',
        'MIME-Version: 1.0',
        'Content-Type: text/plain; charset=UTF-8',
        'Content-Transfer-Encoding: 8bit',
        'X-Mailer: PHP/' . PHP_VERSION,
    ];

    /* All header inputs were sanitised with clean_text(), so CR/LF cannot smuggle headers. */

    if (!function_exists('mail')) {
        error_log('[advchamber] mail() is not available on this server');
        return ['ok' => false, 'error' => 'The mail function is not available on this server.'];
    }

    $ok = @mail($to, $subject, $body, implode("\r\n", $headers));
    if (!$ok) {
        error_log('[advchamber] mail() returned false for enquiry from ' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
        return ['ok' => false, 'error' => 'The message could not be sent. Please email the chamber directly.'];
    }
    return ['ok' => true, 'error' => null];
}

/* ------------------------------------------------------------------ */
/* Case conversion                                                     */
/* ------------------------------------------------------------------ */

/** Convert "corporate & commercial law" to "Corporate & Commercial Law". */
function title_case(string $value): string
{
    return ucwords(trim($value), " \t\n\r\x0B\v&-/");
}