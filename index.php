<?php
/**
 * index.php — Single-page website for Adv. Javed Pashu Sayyed.
 *
 * Sections (in order):
 *   legal disclaimer overlay, navigation, hero, about, practice areas,
 *   courts, approach, contact, footer.
 */

declare(strict_types=1);

require __DIR__ . '/config.php';
require __DIR__ . '/includes/bootstrap.php';

security_headers();

/* Start the session before any output so CSRF fields can be rendered safely. */
ensure_session();

$currentPageFile = 'index.php';

require __DIR__ . '/includes/nav.php';
require __DIR__ . '/includes/disclaimer-text.php';
require __DIR__ . '/includes/practice-data.php';

/* Practice-area name => its own page, for the links in the practice list. */
$practiceLinks = array_column(array_map(
    static fn(string $slug, array $p): array => [$p['name'], $slug . '.php'],
    array_keys($practicePages),
    $practicePages
), 1, 0);

$bodyClass       = 'page-home';
$transparent     = true;
$showModal       = true;

/* Flash messages for the no-JavaScript form fallback (contact.php redirects here). */
$flashType = null;
$flashText = '';
if (isset($_GET['sent']) && $_GET['sent'] === '1') {
    $flashType = 'success';
    $flashText = 'Thank you. Your enquiry has been sent, and you will receive a reply by email.';
} elseif (isset($_GET['error']) && is_string($_GET['error']) && $_GET['error'] !== '') {
    /* The error query string carries a reason code from contact.php — map to copy. */
    $flashMessages = [
        'invalid' => 'Some details were missing. Please check the form and try again.',
        'csrf'    => 'The form expired. Please refresh the page and try again.',
        'rate'    => 'Too many enquiries have been sent from this connection. Please try again later.',
    ];
    $flashType = 'error';
    $flashText = $flashMessages[$_GET['error']] ?? 'The enquiry could not be sent. Please try again later.';
}

/* Practice areas: title => one-line description of the work covered. */
$practiceAreas = [
    'Criminal Law'                       => 'Bail and anticipatory bail, trials, quashing petitions and criminal appeals.',
    'Family Law'                         => 'Divorce, maintenance, custody and domestic violence proceedings.',
    'Corporate Law'                      => 'Contracts, commercial disputes and day-to-day legal advice for businesses.',
    'Arbitration & Dispute Resolution'   =>'Arbitration proceedings, mediation and the enforcement or challenge of awards.',
    'Cyber Crime Law'                    => 'Online fraud, data theft, cyber complaints and related criminal proceedings.',
    'Property Law'                       => 'Title disputes, sale and lease documentation, and possession suits.',
    'Consumer Law'                       => 'Complaints before consumer commissions for defective goods and deficient services.',
    'Human Rights Law'                   => 'Writ petitions and representations where fundamental rights are at stake.',
    'Immigration Law'                    => 'Passport, visa and OCI-related matters, and connected proceedings.',
    'Intellectual Property Law'          => 'Trademark and copyright protection, and infringement disputes.',
];

/* Home-page FAQs — shown in the FAQ section and sent to Google as FAQPage data. */
$homeFaqs = [
    'Where is the office of Adv. Javed Pashu Sayyed?' =>
        'The chamber is at Chamber No. 52/B, District & Sessions Court Pune, Chhatrapati Shivaji Maharaj Road, Shivajinagar, Pune, Maharashtra 411005.',
    'In which courts does Adv. Javed Pashu Sayyed practise?' =>
        'Matters are argued before the Supreme Court of India, the Bombay High Court, the Sessions Courts in Pune and Mumbai, Judicial Magistrate (First Class) courts, and other courts and tribunals where a case calls for it.',
    'What kinds of cases does the chamber handle?' =>
        'Criminal law (bail, anticipatory bail, trials, quashing and appeals), family and divorce matters, property disputes, corporate and commercial work, arbitration, cyber crime, consumer complaints, writ petitions, passport and OCI matters, and trademark and copyright.',
    'How can I book a consultation with an advocate in Pune?' =>
        'Send an enquiry through the form on this website or email adv.syedhc@gmail.com with a short outline of the matter. Consultations are by appointment, Monday to Friday 10:00 am to 7:00 pm and Saturday 10:00 am to 2:00 pm.',
    'Does sending an enquiry make you my lawyer?' =>
        'No. Contacting the chamber does not create a lawyer–client relationship. An engagement begins only once it has been confirmed in writing.',
];

$extraSchema = [[
    '@type'      => 'FAQPage',
    'mainEntity' => array_map(
        static fn(string $q, string $a): array => [
            '@type'          => 'Question',
            'name'           => $q,
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $a],
        ],
        array_keys($homeFaqs),
        array_values($homeFaqs)
    ),
]];

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
if ($showModal) {
    require __DIR__ . '/includes/disclaimer-modal.php';
}
?>

<!-- Inline SVG icon sprite (self-hosted, no external icon library). -->
<svg xmlns="http://www.w3.org/2000/svg" style="display:none" aria-hidden="true">
    <symbol id="i-pin" viewBox="0 0 24 24"><path d="M12 21s7-6.3 7-11a7 7 0 1 0-14 0c0 4.7 7 11 7 11z"/><circle cx="12" cy="10" r="2.6"/></symbol>
    <symbol id="i-mail" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 7 8.5 6 8.5-6"/></symbol>
    <symbol id="i-clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/></symbol>
    <symbol id="i-arrow" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></symbol>
</svg>

<main id="main">

    <!-- ============================================================
         HERO
         ============================================================ -->
    <section class="hero" id="home">
        <div class="container hero-inner">

            <div class="hero-copy">
                <p class="eyebrow reveal" style="--d:0s">Advocate in Pune &middot; Bombay High Court</p>

                <h1 class="hero-title reveal" style="--d:.1s">
                    <span class="line"><span>Adv. Javed</span></span>
                    <span class="line"><span>Pashu Sayyed</span></span>
                </h1>

                <p class="hero-text reveal" style="--d:.45s">
                    Litigation and legal advice in criminal, family, property and commercial
                    matters &mdash; before the Supreme Court of India, the Bombay High Court and
                    courts across Maharashtra.
                </p>

                <div class="hero-actions reveal" style="--d:.58s">
                    <a class="btn btn-primary" href="#contact">Request an appointment</a>
                    <a class="btn btn-outline" href="#practice">
                        Practice areas
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-arrow"/></svg>
                    </a>
                </div>
            </div>

            <!-- PORTRAIT — real photograph (assets/images/javed-pashu-sayyed.jpg, 4:5).
                 To swap: replace the file and update PORTRAIT_SRC / PORTRAIT_ALT in config.php. -->
            <figure class="hero-figure reveal" style="--d:.2s">
                <div class="portrait-frame">
                    <img src="<?= e(PORTRAIT_SRC) ?>" alt="<?= e(PORTRAIT_ALT) ?>"
                         width="<?= (int)PORTRAIT_W ?>" height="<?= (int)PORTRAIT_H ?>"
                         fetchpriority="high">
                </div>
            </figure>

        </div>

        <!-- Forums strip -->
        <div class="container">
            <ul class="credentials" aria-label="Courts of practice">
                <li class="credential reveal">Supreme Court of India</li>
                <li class="credential reveal">Bombay High Court</li>
                <li class="credential reveal">Sessions Courts</li>
                <li class="credential reveal">JMFC Courts</li>
            </ul>
        </div>
    </section>

    <!-- ============================================================
         ABOUT
         ============================================================ -->
    <section class="section section-about" id="about">
        <div class="container">
            <div class="about-grid">
                <div class="about-figure reveal">
                    <div class="portrait-frame">
                        <!-- Portrait: assets/images/javed-pashu-sayyed-about.jpg (4:5).
                             Swap by replacing the file and editing PORTRAIT_ABOUT_SRC in config.php. -->
                        <img src="<?= e(PORTRAIT_ABOUT_SRC) ?>" alt="<?= e(PORTRAIT_ABOUT_ALT) ?>"
                             width="<?= (int)PORTRAIT_W ?>" height="<?= (int)PORTRAIT_H ?>" loading="lazy">
                    </div>
                </div>

                <div class="about-body">
                    <div class="section-head reveal">
                        <p class="label">About</p>
                        <h2>Adv. Javed Pashu Sayyed &mdash; a litigation and advisory practice based in Pune</h2>
                    </div>

                    <div class="about-copy reveal">
                        <p>
                            Adv. Javed Pashu Sayyed works from Chamber No.&nbsp;52/B at the District
                            &amp; Sessions Court, Pune, handling both court work and advice given
                            before a dispute reaches court.
                        </p>
                        <p>
                            Matters are argued before the Supreme Court of India, the Bombay High Court,
                            the Sessions Court in Mumbai, the courts in Pune and Judicial Magistrate
                            (First Class) courts, and before other courts and tribunals where a case
                            calls for it.
                        </p>
                        <p>
                            Clients include individuals facing criminal or family proceedings, property
                            owners, and businesses that need contracts reviewed or disputes resolved.
                        </p>
                        <p>
                            People looking for an advocate in Pune &mdash; for a bail application, a divorce,
                            a property dispute or a writ petition in the Bombay High Court &mdash; can reach the
                            chamber in Shivajinagar by appointment. Each <a class="text-link" href="#practice">practice area</a>
                            has its own page explaining the law and the procedure involved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
         PRACTICE AREAS
         ============================================================ -->
    <section class="section section-practice" id="practice">
        <div class="container">
            <div class="section-head reveal">
                <p class="label">Practice</p>
                <h2>Areas of practice</h2>
                <p class="section-sub">The kinds of matters the chamber takes on, for advice or for representation in court.</p>
            </div>

            <ul class="practice-list">
                <?php foreach ($practiceAreas as $title => $text): ?>
                    <li class="practice-item reveal">
                        <h3 class="practice-title">
                            <?php if (isset($practiceLinks[$title])): ?>
                                <a href="<?= e($practiceLinks[$title]) ?>"><?= e($title) ?></a>
                            <?php else: ?>
                                <?= e($title) ?>
                            <?php endif; ?>
                        </h3>
                        <p class="practice-text"><?= e($text) ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <!-- ============================================================
         COURTS
         ============================================================ -->
    <section class="section section-courts" id="courts">
        <div class="container">
            <div class="section-head reveal">
                <p class="label">Courts</p>
                <h2>Where matters are heard</h2>
            </div>

            <ul class="courts-list">
                <li class="court-row reveal">
                    <h3 class="court-name">Supreme Court of India</h3>
                    <p class="court-text">Special leave petitions, appeals and other proceedings before the country&rsquo;s highest court.</p>
                </li>
                <li class="court-row reveal">
                    <h3 class="court-name">Bombay High Court</h3>
                    <p class="court-text">Writ petitions, appeals, bail and quashing applications before the High Court of Judicature at Bombay.</p>
                </li>
                <li class="court-row reveal">
                    <h3 class="court-name">Sessions Courts</h3>
                    <p class="court-text">Sessions trials, bail applications and criminal appeals in Mumbai, Pune and elsewhere in Maharashtra.</p>
                </li>
                <li class="court-row reveal">
                    <h3 class="court-name">JMFC Courts</h3>
                    <p class="court-text">Complaints, bail and trials before the courts of Judicial Magistrates (First Class).</p>
                </li>
                <li class="court-row reveal">
                    <h3 class="court-name">Tribunals &amp; other forums</h3>
                    <p class="court-text">Consumer commissions, arbitral tribunals and other authorities, as a matter requires.</p>
                </li>
            </ul>
        </div>
    </section>

    <!-- ============================================================
         APPROACH
         ============================================================ -->
    <section class="section section-approach" id="approach">
        <div class="container">
            <div class="section-head reveal">
                <p class="label">Approach</p>
                <h2>How a matter is handled</h2>
            </div>

            <div class="approach-grid">
                <article class="approach-item reveal">
                    <h3 class="approach-title">Documents before opinions</h3>
                    <p class="approach-text">No view is given on a case until the papers have been read. A quick answer over the phone, without the record, is rarely worth much.</p>
                </article>

                <article class="approach-item reveal">
                    <h3 class="approach-title">Weak points raised early</h3>
                    <p class="approach-text">If a case has a problem &mdash; limitation, an unhelpful document, a gap in the evidence &mdash; you hear about it at the first meeting, not on the day of the hearing.</p>
                </article>

                <article class="approach-item reveal">
                    <h3 class="approach-title">Handled personally</h3>
                    <p class="approach-text">The advocate you meet is the advocate who appears for you. Your matter is not passed on to someone else once you engage the chamber.</p>
                </article>

                <article class="approach-item reveal">
                    <h3 class="approach-title">Kept confidential</h3>
                    <p class="approach-text">What you discuss at a consultation stays confidential, whether or not you go on to engage the chamber.</p>
                </article>
            </div>
        </div>
    </section>

    <!-- ============================================================
         FAQ
         ============================================================ -->
    <section class="section section-faq" id="faq">
        <div class="container">
            <div class="section-head reveal">
                <p class="label">Questions</p>
                <h2>Frequently asked questions</h2>
            </div>

            <div class="faq-list reveal">
                <?php foreach ($homeFaqs as $q => $a): ?>
                    <details class="faq-item">
                        <summary><?= e($q) ?></summary>
                        <p><?= e($a) ?></p>
                    </details>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ============================================================
         CONTACT / APPOINTMENT
         ============================================================ -->
    <section class="section section-contact" id="contact">
        <div class="container">
            <div class="section-head reveal">
                <p class="label">Contact</p>
                <h2>Request an appointment</h2>
                <p class="section-sub">
                    Consultations are by appointment. Describe the matter briefly and you will get a
                    reply at the email address you give. If it is urgent &mdash; an arrest, a hearing
                    date, a deadline &mdash; say so in the subject line.
                </p>
            </div>

            <div class="contact-grid">

                <div class="contact-info reveal">
                    <p class="contact-name"><?= e(ADVOCATE_NAME) ?></p>

                    <ul class="contact-list">
                        <li>
                            <span class="contact-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><use href="#i-pin"/></svg>
                            </span>
                            <span class="contact-value">
                                <?php foreach (OFFICE_ADDRESS_LINES as $line): ?>
                                    <span><?= e($line) ?></span>
                                <?php endforeach; ?>
                            </span>
                        </li>
                        <li>
                            <span class="contact-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><use href="#i-mail"/></svg>
                            </span>
                            <a class="contact-link" href="mailto:<?= e(EMAIL_MAILTO) ?>"><?= e(EMAIL_DISPLAY) ?></a>
                        </li>
                        <li>
                            <span class="contact-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><use href="#i-clock"/></svg>
                            </span>
                            <span class="contact-value">
                                <span>Monday to Friday, 10:00 am &ndash; 7:00 pm</span>
                                <span>Saturday, 10:00 am &ndash; 2:00 pm</span>
                            </span>
                        </li>
                    </ul>

                    <p class="contact-note">
                        Contacting the chamber, including through this website, does not by itself create a
                        lawyer&ndash;client relationship. Please do not send confidential documents until
                        an engagement has been confirmed in writing.
                    </p>
                </div>

                <div class="contact-form-wrap reveal">

                    <?php if ($flashType === 'success'): ?>
                        <div class="form-flash form-flash--success" role="status"><?= e($flashText) ?></div>
                    <?php elseif ($flashType === 'error'): ?>
                        <div class="form-flash form-flash--error" role="alert"><?= e($flashText) ?></div>
                    <?php endif; ?>

                    <form id="enquiryForm" class="enquiry-form" action="contact.php" method="post" novalidate>
                        <?= csrf_field() ?>
                        <?= honeypot_field() ?>

                        <div class="form-row">
                            <div class="field">
                                <label for="f_name">Full name <span class="req" aria-hidden="true">*</span></label>
                                <input type="text" id="f_name" name="name" autocomplete="name" maxlength="120" required>
                            </div>
                            <div class="field">
                                <label for="f_email">Email <span class="req" aria-hidden="true">*</span></label>
                                <input type="email" id="f_email" name="email" autocomplete="email" maxlength="254" required>
                            </div>
                            <div class="field">
                                <label for="f_telephone">Phone <span class="opt">(optional)</span></label>
                                <input type="tel" id="f_telephone" name="telephone" autocomplete="tel" maxlength="30">
                            </div>
                            <div class="field">
                                <label for="f_area">Area of law</label>
                                <select id="f_area" name="area">
                                    <option value="">Not sure / other</option>
                                    <?php foreach (AREAS_OF_LAW as $area): ?>
                                        <option value="<?= e($area) ?>"><?= e($area) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="field">
                            <label for="f_subject">Subject <span class="req" aria-hidden="true">*</span></label>
                            <input type="text" id="f_subject" name="subject" maxlength="200" required>
                        </div>

                        <div class="field">
                            <label for="f_message">Message <span class="req" aria-hidden="true">*</span></label>
                            <p class="field-hint" id="f_message-hint">A short outline is enough. Please leave out confidential details for now.</p>
                            <textarea id="f_message" name="message" rows="6" maxlength="4000" aria-describedby="f_message-hint" required></textarea>
                        </div>

                        <div class="field field--check">
                            <label class="check-label" for="f_consent">
                                <input type="checkbox" id="f_consent" name="consent" required>
                                <span class="check-box" aria-hidden="true"></span>
                                <span class="check-text">
                                    I have read the <a href="disclaimer.php">disclaimer</a> and
                                    <a href="privacy.php">privacy policy</a>, and I understand that sending
                                    this message does not create a lawyer&ndash;client relationship.
                                </span>
                            </label>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary btn-submit" id="enquirySubmit">Send enquiry</button>
                            <p class="form-status" id="formStatus" role="status" aria-live="polite"></p>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>

</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
