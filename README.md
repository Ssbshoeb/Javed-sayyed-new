# Adv. Javed Pashu Sayyed — Chamber Website

A single-page, premium personal website for **Adv. Javed Pashu Sayyed**,
Advocate · Litigator · Legal Advisor.

This is a purpose-built, hand-crafted site — **not** a template. It uses a
restrained editorial design (Source Serif 4 + Source Sans 3, muted ink/gold palette)
and communicates authority through typography, structure and restraint rather
than statistics or superlatives.

No facts are invented anywhere on the site. Where information was not verified
— languages, a portrait photograph, a phone number — the site shows a clearly
marked placeholder instead.

---

## 1. Project overview

```
/
├── index.php          Single-page website (home + all sections)
├── contact.php        Secure enquiry-form handler (POST)
├── config.php         All site-wide settings in one place
├── privacy.php        Privacy policy
├── disclaimer.php     Full disclaimer page
├── terms.php          Terms of use
├── includes/
│   ├── bootstrap.php  Helpers: escaping, CSRF, honeypot, rate limit, mailer, headers
│   ├── head.php       <head>: SEO meta, OG/Twitter, fonts, CSS, JSON-LD
│   ├── header.php     Skip link + sticky navigation
│   ├── nav.php        Primary navigation items
│   ├── disclaimer-text.php   Disclaimer wording (shared by modal + disclaimer page)
│   ├── disclaimer-modal.php  Full-screen disclaimer overlay
│   └── footer.php     Footer + floating actions + scripts
└── assets/
    ├── css/style.css      Complete design system (no frameworks)
    ├── js/main.js         Disclaimer, nav, scroll-spy, reveal, form AJAX (vanilla)
    ├── images/            Portrait placeholders, OG placeholder
    └── icons/favicon.svg  Monogram favicon
```

No database. No build step. No Node.js. No React/Vue. Plain PHP 8 + HTML5 +
CSS3 + a small amount of vanilla JavaScript.

## 2. Requirements

- PHP **8.0 or newer** (tested on 8.2) with the following extensions:
  `mbstring`, `json`, `session`, `filter`. `openssl` is used only by the
  fallback mail path, not required for the page itself.
- Apache (or any PHP-compatible web server).
- The site is fully usable on shared hosting (cPanel, etc.).

## 3. Installation

Copy the project folder to your web root, for example:

```
public_html/
└── (project contents here)
```

No database setup, no composer install and no build step are required.

## 4. Local development

With PHP's built-in server:

```bash
php -S localhost:8000
```

Then open <http://localhost:8000> in a browser (index.php is served automatically).

If you use VS Code, the **PHP Server** extension works the same way.

### Sending mail locally

`mail()` will not actually deliver email on most local installs. That is fine:

- the form still validates, and you get a clear success/failure response;
- to capture mail locally, enable a mail catcher such as
  [MailHog](https://github.com/mailhog/MailHog) (and check its inbox) or the
  logs of whatever stack you use (e.g. Laragon / XAMPP `sendmail` logs).

## 5. Hosting instructions

1. Upload **all files** to `public_html/` (or the equivalent docroot).
2. Ensure the folder the files live in is `index.php`-aware (default in Apache).
3. Ensure `config.php`, `includes/*` are **not** accidentally made web-accessible
   with exec rights — nothing extra to configure; the files already block
   direct access.
4. On cPanel, mail is sent through the server's `mail()` transport. Many hosts
   require the *From* address to belong to your own domain —
   see **How to change contact email** below and set `MAIL_FROM_ADDRESS`
   to an address on your own domain if the shared-host policy requires it.
5. After deploying, open the site and submit the test form to confirm delivery.

### .htaccess note

The project is delivered ready-to-use and does not depend on a custom
`.htaccess`. If your host supports it you may optionally add:

```apache
# Redirect www -> apex (adjust to your domain)
RewriteEngine On
RewriteCond %{HTTP_HOST} ^www\.(.+)$ [NC]
RewriteRule ^(.*)$ https://%1/$1 [R=301,L]

# Block direct access to includes/
RewriteRule ^includes/ - [F,L]
```

(The includes already exit on direct access, so this is belt-and-braces only.)

## 6. How to change the contact email

Edit `config.php`:

```php
const MAIL_TO           = 'adv.syedhc@gmail.com';  // where enquiries go
const EMAIL_DISPLAY     = 'adv.syedhc@gmail.com';  // shown on the site
const EMAIL_MAILTO      = 'adv.syedhc@gmail.com';  // mailto: links
const MAIL_FROM_ADDRESS = 'adv.syedhc@gmail.com';  // From header
```

At least `MAIL_TO` must be updated. Some shared hosts require
`MAIL_FROM_ADDRESS` to be on your own domain — change it to e.g.
`no-reply@yourdomain.com` if the host flags your email as spam or rejects it.

## 7. How to replace the advocate photo

The build ships with elegant **SVG monogram placeholders** — no fake human
portrait is included.

1. Prepare a real photograph: 4:5 crop, ~1200×1500 px.
2. Save it as `assets/images/javed-pashu-sayyed.jpg` (and optionally
   `javed-pashu-sayyed-about.jpg` for the About section).
3. In `config.php`, update:

```php
const PORTRAIT_SRC       = 'assets/images/javed-pashu-sayyed.jpg';
const PORTRAIT_ABOUT_SRC = 'assets/images/javed-pashu-sayyed-about.jpg';
```

The `width`/`height` attributes (`PORTRAIT_W` / `PORTRAIT_H`) prevent layout
shift; update them to match your file's rendered dimensions if you change
the crop.

If you also use a landmark photograph (Bombay High Court, etc.) confirm its
licence first and add a credit line in the footer as appropriate.

## 8. How to change practice areas

The practice areas are listed in the `$practiceAreas` array at the top of `index.php` (deliberate: they
are hand-written editorial content, not data). To change a description, edit
that array, and keep `AREAS_OF_LAW` in `config.php` (form dropdown + SEO schema) in step.

The practice areas offered in the **contact form dropdown** are driven by
`config.php`:

```php
const AREAS_OF_LAW = [
    'Corporate & Commercial Law',
    // …
];
```

## 9. How to modify the disclaimer

The wording lives in `includes/disclaimer-text.php` (intro + bullet list) and
is shared by the full-screen overlay and the `disclaimer.php` page. The overlay
skeleton is `includes/disclaimer-modal.php`.

Consent is stored per browser via `localStorage` (key `advchamber_consent`).
To force the disclaimer to appear again, clear site data for the domain.

## 10. How to configure SMTP later

The mailer is isolated in one function, `send_enquiry()` in
`includes/bootstrap.php`. To move to SMTP:

1. `composer require phpmailer/phpmailer` (or vendor privately).
2. Rewrite `send_enquiry()` to use `PHPMailer`, keeping the return contract
   `['ok' => bool, 'error' => ?string]`. Nothing in `contact.php` changes.
3. Add your SMTP credentials to `config.php` **only if that file is stored
   outside the web root**, or use environment variables loaded from a server
   config — never commit SMTP secrets to a public repository.

SMTP credentials must never be exposed in frontend code; nothing in this
project's markup or JavaScript contains transport secrets.

## 11. Security notes

The enquiry form is protected server-side:

- **CSRF** — session-bound token, compared with `hash_equals`.
- **Honeypot** — hidden `company_website` field; bots that fill it are silently
  "accepted" without further processing.
- **Validation** — required fields, strict email validation, max lengths,
  select-restricted area-of-law.
- **Sanitisation** — control characters stripped; CR/LF neutralised before any
  string can reach `mail()` headers (header-injection protection).
- **Rate limiting** — file-based, per-IP window (5 submissions/hour, tune in
  `config.php`); no database needed.
- **Output escaping** — every echoed value runs through `e()`.
- **Error handling** — PHP errors are never shown to visitors; failures produce
  a neutral message.
- **HTTP security headers** — CSP, X-Frame-Options (SAMEORIGIN),
  X-Content-Type-Options, Referrer-Policy, Permissions-Policy are emitted by
  `security_headers()`.
- Sessions use `HttpOnly`, `SameSite=Lax`, and `Secure` over HTTPS.

## 12. SEO notes

On-page SEO is already in place out of the box:

- Descriptive `<title>` and meta description.
- Canonical tags, Open Graph and Twitter/X cards (`includes/head.php`).
- One `H1` per page and a clean heading hierarchy (`h2`/`h3` under it).
- JSON-LD `Person` schema with **only verified information** (no ratings,
  reviews or LegalService claims are fabricated).
- Semantic HTML5 landmarks (`<header>`, `<nav>`, `<main>`, `<section>`,
  `<footer>`).

### Practice-area pages (keyword pages)

Each practice area has its own page targeting the phrase people search for
(e.g. `criminal-lawyer-pune.php` → "criminal lawyer in Pune"). All wording lives
in `includes/practice-data.php`; the layout is `includes/practice-page.php`;
each public file is a 4-line stub that sets `$practiceSlug`. To add a page:
add an entry to `$practicePages`, create the stub file, and add the URL to
`sitemap.xml`. Footer and home-page links update automatically.

Every page emits JSON-LD (`WebSite`, `Person`, plus `BreadcrumbList`, `Service`
and `FAQPage` on practice pages). Keep the wording factual — Bar Council rules
forbid "best / top / No. 1", results, fees and testimonials.

Official social profiles go in `SOCIAL_PROFILES` in `config.php` (schema `sameAs`).

To finish production SEO:

1. Replace the social share placeholder (`assets/images/og-cover.svg`) with a
   real 1200×630 PNG/JPG and update the `og:image` / `twitter:image` URLs in
   `includes/head.php`.
2. Make sure `SITE_URL` in `config.php` matches the live domain exactly and
   serves over HTTPS.
3. Do not add fake statistics, testimonials, reviews, awards or years of
   practice anywhere — the site is designed to earn trust without them.

## 13. Accessibility & performance

- Semantic markup, labelled form fields, keyboard-focusable controls, `aria`
  attributes on the dialog and menus, visible `:focus-visible` states, skip
  link.
- `prefers-reduced-motion` respected (reveal animations disabled, smooth scroll
  flattened).
- Below-the-fold images lazy-load with explicit `width`/`height`; fonts load via
  `display=swap`; one small deferred JavaScript file; no external icon library.
- The single hero image is preloaded with `fetchpriority="high"`.

## 14. Content accuracy checklist

Before publishing, verify and refresh:

- Address and office hours (`config.php`).
- The confirmed working languages (`LANGUAGES` — deliberately empty until
  confirmed).
- The portrait photograph.
- Any new administrative claims added later (courts, forums) against fact.# Javed-sayyed-new
