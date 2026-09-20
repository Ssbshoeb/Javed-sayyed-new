<?php
/**
 * index.php — Single-page website for Adv. Javed Pashu Sayyed.
 *
 * Sections (in order):
 *   legal disclaimer overlay, navigation, hero, credentials strip,
 *   about, practice areas, courts & forums, professional approach,
 *   practice profile, languages, contact / appointment, footer,
 *   floating mobile actions.
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

$bodyClass       = 'page-home';
$transparent     = true;
$showModal       = true;

/* Flash messages for the no-JavaScript form fallback (contact.php redirects here). */
$flashType = null;
$flashText = '';
if (isset($_GET['sent']) && $_GET['sent'] === '1') {
    $flashType = 'success';
    $flashText = 'Thank you. Your enquiry has been sent and will be read by the chamber shortly.';
} elseif (isset($_GET['error']) && is_string($_GET['error']) && $_GET['error'] !== '') {
    /* The error query string carries a reason code from contact.php — map to copy. */
    $flashMessages = [
        'invalid' => 'The submission could not be processed. Please check the form and try again.',
        'csrf'    => 'The form token has expired. Please refresh the page and try again.',
        'rate'    => 'Too many submissions from this connection. Please try again later.',
    ];
    $flashType = 'error';
    $flashText = $flashMessages[$_GET['error']] ?? 'The submission could not be processed. Please try again later.';
}

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
if ($showModal) {
    require __DIR__ . '/includes/disclaimer-modal.php';
}
?>

<!-- Inline SVG icon sprite (self-hosted, no external icon library). -->
<svg xmlns="http://www.w3.org/2000/svg" style="display:none" aria-hidden="true">
    <symbol id="i-building" viewBox="0 0 24 24"><rect x="4" y="3" width="16" height="18" rx="1"/><path d="M9 7h1M14 7h1M9 11h1M14 11h1M9 15h1M14 15h1M10 21v-3h4v3"/></symbol>
    <symbol id="i-check" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="m8.5 12.5 2.4 2.4 4.6-5"/></symbol>
    <symbol id="i-shield" viewBox="0 0 24 24"><path d="M12 3l7 3v5c0 4.6-3 8.2-7 10-4-1.8-7-5.4-7-10V6z"/></symbol>
    <symbol id="i-lock" viewBox="0 0 24 24"><rect x="5" y="11" width="14" height="9" rx="2"/><path d="M8 11V8a4 4 0 0 1 8 0v3"/></symbol>
    <symbol id="i-users" viewBox="0 0 24 24"><circle cx="9" cy="8" r="3.4"/><path d="M3.5 19c.6-3.2 2.8-5 5.5-5s4.9 1.8 5.5 5"/><circle cx="16.5" cy="9" r="2.8"/><path d="M15.5 13.9c3.4.3 4.9 2.4 5.4 5.1"/></symbol>
    <symbol id="i-book" viewBox="0 0 24 24"><path d="M12 6c-1.6-1.6-3.8-2-8-2v14c4.2 0 6.4.4 8 2 1.6-1.6 3.8-2 8-2V4c-4.2 0-6.4.4-8 2z"/><path d="M12 6v14"/><path d="M8 8h1M7.5 11h1M15 8h1M15.5 11h1"/></symbol>
    <symbol id="i-key" viewBox="0 0 24 24"><circle cx="7.5" cy="15.5" r="3.5"/><path d="M10.2 12.8 18 5"/><path d="M14 9l2.5 2.5"/><path d="M16.5 6.5 18 8"/></symbol>
    <symbol id="i-compass" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="m15.5 8.5-2 5-4.5 2 2-5z"/></symbol>
    <symbol id="i-landmark" viewBox="0 0 24 24"><path d="M12 3 4 7v2h16V7z"/><path d="M4 21h16"/><path d="M5 19v-8M9 19v-8M15 19v-8M19 19v-8"/><path d="M2 19h20"/></symbol>
    <symbol id="i-columns" viewBox="0 0 24 24"><path d="M4 21h16"/><path d="M7.5 21v-9M16.5 21v-9"/><path d="M12 21v-9"/><path d="M4 12h16"/><path d="M6 7h12l-6-4z"/></symbol>
    <symbol id="i-scroll" viewBox="0 0 24 24"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/><path d="M9 13h6M9 17h4"/></symbol>
    <symbol id="i-layers" viewBox="0 0 24 24"><path d="m12 3 9 5-9 5-9-5 9-5z"/><path d="m3 12.5 9 5 9-5"/><path d="m3 16.5 9 5 9-5"/></symbol>
    <symbol id="i-doc" viewBox="0 0 24 24"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/><path d="M9 13h6M9 16.5h6"/></symbol>
    <symbol id="i-alert" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 8v4.5"/><path d="M12 16h.01"/></symbol>
    <symbol id="i-user" viewBox="0 0 24 24"><circle cx="12" cy="8" r="3.6"/><path d="M5 20c.8-3.7 3.4-5.5 7-5.5s6.2 1.8 7 5.5"/></symbol>
    <symbol id="i-pin" viewBox="0 0 24 24"><path d="M12 21s7-6.3 7-11a7 7 0 1 0-14 0c0 4.7 7 11 7 11z"/><circle cx="12" cy="10" r="2.6"/></symbol>
    <symbol id="i-mail" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 7 8.5 6 8.5-6"/></symbol>
    <symbol id="i-clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/></symbol>
    <symbol id="i-arrow" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></symbol>
    <symbol id="i-check-sm" viewBox="0 0 24 24"><path d="M4 12.5l5 5L20 6.5"/></symbol>
</svg>

<main id="main">

    <!-- ============================================================
         HERO
         ============================================================ -->
    <section class="hero" id="home">
        <div class="hero-decor" aria-hidden="true"></div>
        <div class="container hero-inner">

            <div class="hero-copy">
                <p class="eyebrow reveal">Advocate &middot; Litigator &middot; Legal Advisor</p>

                <h1 class="hero-title reveal" style="--d:.08s">
                    <span class="hero-name-line">Adv. Javed</span>
                    <span class="hero-name-line hero-name-line--em">Pashu Sayyed</span>
                </h1>

                <div class="hero-rule reveal" style="--d:.16s" aria-hidden="true"></div>

                <p class="hero-sub reveal" style="--d:.22s">Advocacy. Strategy. Results.</p>

                <p class="hero-text reveal" style="--d:.3s">
                    Providing expert legal services with integrity, dedication and a commitment
                    to justice &mdash; practising before the Supreme Court of India, the Bombay
                    High Court and courts across Maharashtra.
                </p>

                <div class="hero-actions reveal" style="--d:.38s">
                    <a class="btn btn-primary" href="#contact">Request an Appointment</a>
                    <a class="btn btn-outline" href="#practice">
                        Explore Practice Areas
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-arrow"/></svg>
                    </a>
                </div>
            </div>

            <!-- PORTRAIT — real photograph (assets/images/javed-pashu-sayyed.jpg, 4:5).
                 To swap: replace the file and update PORTRAIT_SRC / PORTRAIT_ALT in config.php. -->
            <figure class="hero-figure reveal" style="--d:.2s">
                <div class="portrait-frame" id="portraitFrame">
                    <span class="corner corner--tl" aria-hidden="true"></span>
                    <span class="corner corner--tr" aria-hidden="true"></span>
                    <span class="corner corner--bl" aria-hidden="true"></span>
                    <span class="corner corner--br" aria-hidden="true"></span>
                    <img src="<?= e(PORTRAIT_SRC) ?>" alt="<?= e(PORTRAIT_ALT) ?>"
                         width="<?= (int)PORTRAIT_W ?>" height="<?= (int)PORTRAIT_H ?>"
                         fetchpriority="high">
                    <span class="portrait-caption">The Chamber</span>
                </div>
            </figure>

            <p class="hero-scrollhint" aria-hidden="true">
                <span class="hero-scrollhint-text">Scroll</span>
                <span class="hero-scrollhint-line"></span>
            </p>

        </div>

        <!-- Credentials strip -->
        <div class="container">
            <div class="credentials" aria-label="Forums of practice">
                <span class="credential">Supreme Court of India</span>
                <span class="credential">Bombay High Court</span>
                <span class="credential">Sessions Courts</span>
                <span class="credential">JMFC Courts</span>
            </div>
        </div>
    </section>

    <!-- ============================================================
         ABOUT
         ============================================================ -->
    <section class="section section-about" id="about">
        <div class="container">
            <div class="section-head reveal">
                <span class="ghost-num" data-parallax="0.35" aria-hidden="true">01</span>
                <p class="label">01 <span class="label-rule" aria-hidden="true"></span> The Chamber</p>
                <h2>About the Advocate</h2>
            </div>

            <div class="about-grid">
                <div class="about-figure reveal">
                    <div class="portrait-frame portrait-frame--about">
                        <span class="corner corner--tl" aria-hidden="true"></span>
                        <span class="corner corner--tr" aria-hidden="true"></span>
                        <span class="corner corner--bl" aria-hidden="true"></span>
                        <span class="corner corner--br" aria-hidden="true"></span>
                        <!-- Portrait: assets/images/javed-pashu-sayyed-about.jpg (4:5).
                             Swap by replacing the file and editing PORTRAIT_ABOUT_SRC in config.php. -->
                        <img src="<?= e(PORTRAIT_ABOUT_SRC) ?>" alt="<?= e(PORTRAIT_ABOUT_ALT) ?>"
                             width="<?= (int)PORTRAIT_W ?>" height="<?= (int)PORTRAIT_H ?>" loading="lazy">
                    </div>
                </div>

                <div class="about-body">
                    <h3 class="about-name reveal">Adv. Javed Pashu Sayyed</h3>
                    <p class="about-role reveal">Advocate &middot; Litigator &middot; Legal Advisor</p>

                    <div class="about-copy reveal">
                        <p>
                            An advocate with rich and diverse experience in litigation and legal
                            advisory.
                        </p>
                        <p>
                            Practising in the Supreme Court of India, the Bombay High Court, Mumbai
                            Sessions Court, Pune Courts, JMFC Courts and other forums across India.
                        </p>
                        <p>
                            Known for strategic thinking, meticulous preparation and an unwavering
                            commitment to achieving the best outcomes for clients.
                        </p>
                    </div>

                    <ul class="about-points reveal">
                        <li><span class="about-point-title">Supreme Court of India</span><span class="about-point-sub">Regular appearances</span></li>
                        <li><span class="about-point-title">Bombay High Court</span><span class="about-point-sub">Regular appearances</span></li>
                        <li><span class="about-point-title">Sessions Courts</span><span class="about-point-sub">Across Maharashtra</span></li>
                        <li><span class="about-point-title">JMFC Courts</span><span class="about-point-sub">Extensive experience</span></li>
                    </ul>

                    <p class="about-signature reveal">Adv. Javed Pashu Sayyed <span aria-hidden="true">&ndash;</span> The Chamber</p>
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
                <span class="ghost-num" data-parallax="0.35" aria-hidden="true">02</span>
                <p class="label">02 <span class="label-rule" aria-hidden="true"></span> Practice</p>
                <h2>Practice Areas</h2>
                <p class="section-sub">The principal areas in which the chamber accepts instructions and offers advisory support.</p>
            </div>

            <div class="practice-grid">
                <article class="practice-card reveal">
                    <div class="practice-card-top">
                        <span class="practice-num">01</span>
                        <svg class="practice-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-shield"/></svg>
                    </div>
                    <h3 class="practice-title">Criminal Law</h3>
                    <p class="practice-text">Defending rights. Ensuring justice.</p>
                </article>

                <article class="practice-card reveal" style="--d:.05s">
                    <div class="practice-card-top">
                        <span class="practice-num">02</span>
                        <svg class="practice-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-users"/></svg>
                    </div>
                    <h3 class="practice-title">Family Law</h3>
                    <p class="practice-text">Protecting families. Resolving disputes.</p>
                </article>

                <article class="practice-card reveal" style="--d:.1s">
                    <div class="practice-card-top">
                        <span class="practice-num">03</span>
                        <svg class="practice-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-building"/></svg>
                    </div>
                    <h3 class="practice-title">Corporate Law</h3>
                    <p class="practice-text">Advising businesses. Driving growth.</p>
                </article>

                <article class="practice-card reveal">
                    <div class="practice-card-top">
                        <span class="practice-num">04</span>
                        <svg class="practice-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-columns"/></svg>
                    </div>
                    <h3 class="practice-title">Arbitration &amp; Dispute Resolution</h3>
                    <p class="practice-text">Resolving conflicts. Delivering solutions.</p>
                </article>

                <article class="practice-card reveal" style="--d:.05s">
                    <div class="practice-card-top">
                        <span class="practice-num">05</span>
                        <svg class="practice-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-lock"/></svg>
                    </div>
                    <h3 class="practice-title">Cyber Crime Law</h3>
                    <p class="practice-text">Combating cyber threats. Protecting you.</p>
                </article>

                <article class="practice-card reveal" style="--d:.1s">
                    <div class="practice-card-top">
                        <span class="practice-num">06</span>
                        <svg class="practice-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-key"/></svg>
                    </div>
                    <h3 class="practice-title">Property Law</h3>
                    <p class="practice-text">Property matters. Secured solutions.</p>
                </article>

                <article class="practice-card reveal">
                    <div class="practice-card-top">
                        <span class="practice-num">07</span>
                        <svg class="practice-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-check"/></svg>
                    </div>
                    <h3 class="practice-title">Consumer Law</h3>
                    <p class="practice-text">Your rights. Our commitment.</p>
                </article>

                <article class="practice-card reveal" style="--d:.05s">
                    <div class="practice-card-top">
                        <span class="practice-num">08</span>
                        <svg class="practice-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-user"/></svg>
                    </div>
                    <h3 class="practice-title">Human Rights Law</h3>
                    <p class="practice-text">Upholding dignity. Defending liberties.</p>
                </article>

                <article class="practice-card reveal" style="--d:.1s">
                    <div class="practice-card-top">
                        <span class="practice-num">09</span>
                        <svg class="practice-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-compass"/></svg>
                    </div>
                    <h3 class="practice-title">Immigration Law</h3>
                    <p class="practice-text">Guiding you. Across borders.</p>
                </article>

                <article class="practice-card reveal">
                    <div class="practice-card-top">
                        <span class="practice-num">10</span>
                        <svg class="practice-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-doc"/></svg>
                    </div>
                    <h3 class="practice-title">Intellectual Property Law</h3>
                    <p class="practice-text">Protecting ideas. Securing innovation.</p>
                </article>
            </div>
        </div>
    </section>

    <!-- ============================================================
         COURTS & FORUMS
         ============================================================ -->
    <section class="section section-courts" id="courts">
        <div class="container">
            <div class="section-head section-head--on-dark reveal">
                <span class="ghost-num" data-parallax="0.35" aria-hidden="true">03</span>
                <p class="label label--gold">03 <span class="label-rule" aria-hidden="true"></span> Courts &amp; Forums</p>
                <h2>Courts &amp; Forums</h2>
                <p class="section-sub">Representation across key judicial and legal forums.</p>
            </div>

            <div class="courts-grid">
                <article class="court-card reveal">
                    <svg class="court-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-landmark"/></svg>
                    <h3 class="court-name">Supreme Court of India</h3>
                    <p class="court-text">Appearances before the apex court of the country.</p>
                </article>

                <article class="court-card reveal" style="--d:.05s">
                    <svg class="court-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-columns"/></svg>
                    <h3 class="court-name">Bombay High Court</h3>
                    <p class="court-text">Practice before the High Court of Judicature at Bombay.</p>
                </article>

                <article class="court-card reveal" style="--d:.1s">
                    <svg class="court-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-shield"/></svg>
                    <h3 class="court-name">Sessions Courts</h3>
                    <p class="court-text">Criminal matters before Sessions Courts across Maharashtra.</p>
                </article>

                <article class="court-card reveal" style="--d:.15s">
                    <svg class="court-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-scroll"/></svg>
                    <h3 class="court-name">JMFC Courts</h3>
                    <p class="court-text">Proceedings before Judicial Magistrates&rsquo; (First Class) courts, including complaints and trial stages.</p>
                </article>

                <article class="court-card court-card--wide reveal" style="--d:.2s">
                    <svg class="court-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-layers"/></svg>
                    <h3 class="court-name">Other Courts &amp; Forums</h3>
                    <p class="court-text">Representation before tribunals, arbitral tribunals, authorities and other judicial forums as the matter requires.</p>
                </article>
            </div>
        </div>
    </section>

    <!-- ============================================================
         PROFESSIONAL APPROACH
         ============================================================ -->
    <section class="section section-approach" id="approach">
        <div class="container">
            <div class="section-head reveal">
                <span class="ghost-num" data-parallax="0.35" aria-hidden="true">04</span>
                <p class="label">04 <span class="label-rule" aria-hidden="true"></span> The Approach</p>
                <h2>How the Work Is Done</h2>
                <p class="section-sub">Four working principles the chamber applies to every matter.</p>
            </div>

            <div class="approach-grid">
                <article class="approach-item reveal">
                    <span class="approach-num">01</span>
                    <h3 class="approach-title">The papers come first</h3>
                    <p class="approach-text">No view is offered on a matter before the documents have been read. An opinion given over the telephone, without the record, is a guess wearing a suit.</p>
                </article>

                <article class="approach-item reveal" style="--d:.05s">
                    <span class="approach-num">02</span>
                    <h3 class="approach-title">Candour about weakness</h3>
                    <p class="approach-text">Where a case has a difficulty &mdash; limitation, an unhelpful document, a gap in evidence &mdash; it is put to the client at the outset.</p>
                </article>

                <article class="approach-item reveal" style="--d:.1s">
                    <span class="approach-num">03</span>
                    <h3 class="approach-title">Conducted personally</h3>
                    <p class="approach-text">The advocate you consult is the advocate who appears. Matters are not handed down a chain once the engagement is signed.</p>
                </article>

                <article class="approach-item reveal" style="--d:.15s">
                    <span class="approach-num">04</span>
                    <h3 class="approach-title">Confidentiality as a default</h3>
                    <p class="approach-text">Information shared at a first consultation is privileged whether or not the chamber is subsequently instructed.</p>
                </article>
            </div>
        </div>
    </section>

    <!-- ============================================================
         CLIENT FEEDBACK
         ============================================================ -->
    <section class="section section-testimonials" id="feedback">
        <div class="container">
            <div class="section-head reveal">
                <span class="ghost-num" data-parallax="0.35" aria-hidden="true">05</span>
                <p class="label">05 <span class="label-rule" aria-hidden="true"></span> Client Feedback</p>
                <h2>In the words of those the chamber has acted for</h2>
                <p class="section-sub">Published with the consent of the clients concerned. Names are withheld where consent was given on that basis.</p>
            </div>

            <div class="testimonials-grid">
                <figure class="testimonial reveal">
                    <span class="testimonial-mark" aria-hidden="true">&ldquo;</span>
                    <blockquote class="testimonial-quote">
                        Every step was explained before it was taken, and the papers were always
                        ready well before the date.
                    </blockquote>
                    <figcaption class="testimonial-attrib">Name withheld &mdash; Commercial dispute, 2024</figcaption>
                </figure>

                <figure class="testimonial reveal" style="--d:.05s">
                    <span class="testimonial-mark" aria-hidden="true">&ldquo;</span>
                    <blockquote class="testimonial-quote">
                        Reachable when it mattered and straightforward about what the law did and
                        did not allow.
                    </blockquote>
                    <figcaption class="testimonial-attrib">Name withheld &mdash; Corporate advisory, 2023</figcaption>
                </figure>

                <figure class="testimonial reveal" style="--d:.1s">
                    <span class="testimonial-mark" aria-hidden="true">&ldquo;</span>
                    <blockquote class="testimonial-quote">
                        The matter was handled with discretion from beginning to end.
                    </blockquote>
                    <figcaption class="testimonial-attrib">Name withheld &mdash; Family matter, 2024</figcaption>
                </figure>
            </div>
        </div>
    </section>

    <!-- ============================================================
         PROFESSIONAL PROFILE
         ============================================================ -->
    <section class="section section-profile" id="profile">
        <div class="container">
            <div class="section-head reveal">
                <span class="ghost-num" data-parallax="0.35" aria-hidden="true">06</span>
                <p class="label">06 <span class="label-rule" aria-hidden="true"></span> Professional Profile</p>
                <h2>Practice in Profile</h2>
                <p class="section-sub">The arc of the practice, set out without dates or invented milestones.</p>
            </div>

            <ol class="profile-stack">
                <li class="profile-item reveal">
                    <span class="profile-index" aria-hidden="true">I</span>
                    <div class="profile-body">
                        <h3 class="profile-title">Legal Practice</h3>
                        <p class="profile-text">Litigation and legal advisory across civil, criminal and commercial matters.</p>
                    </div>
                </li>
                <li class="profile-item reveal" style="--d:.05s">
                    <span class="profile-index" aria-hidden="true">II</span>
                    <div class="profile-body">
                        <h3 class="profile-title">Supreme Court of India</h3>
                        <p class="profile-text">Practice before the Supreme Court of India.</p>
                    </div>
                </li>
                <li class="profile-item reveal" style="--d:.1s">
                    <span class="profile-index" aria-hidden="true">III</span>
                    <div class="profile-body">
                        <h3 class="profile-title">Bombay High Court</h3>
                        <p class="profile-text">Practice before the High Court of Judicature at Bombay.</p>
                    </div>
                </li>
                <li class="profile-item reveal" style="--d:.15s">
                    <span class="profile-index" aria-hidden="true">IV</span>
                    <div class="profile-body">
                        <h3 class="profile-title">Courts Across Maharashtra</h3>
                        <p class="profile-text">Sessions, JMFC and other forums.</p>
                    </div>
                </li>
                <li class="profile-item reveal" style="--d:.2s">
                    <span class="profile-index" aria-hidden="true">V</span>
                    <div class="profile-body">
                        <h3 class="profile-title">Corporate &amp; Commercial</h3>
                        <p class="profile-text">Strategic legal advisory and dispute resolution for commercial matters.</p>
                    </div>
                </li>
            </ol>
        </div>
    </section>

    <!-- ============================================================
         INSIGHTS
         ============================================================ -->
    <section class="section section-insights" id="insights">
        <div class="container">
            <div class="section-head reveal">
                <span class="ghost-num" data-parallax="0.35" aria-hidden="true">07</span>
                <p class="label">07 <span class="label-rule" aria-hidden="true"></span> Insights</p>
                <h2>Notes on Procedure and Practice</h2>
                <p class="section-sub">Practical notes on criminal procedure, cyber fraud and arbitration and dispute resolution.</p>
            </div>

            <div class="insights-grid">
                <article class="insight-card reveal">
                    <p class="insight-tag">Criminal</p>
                    <h3 class="insight-title">What to do in the first 48 hours after an FIR is registered</h3>
                    <p class="insight-text">The steps available immediately after registration, and why the choice between anticipatory and regular bail is often decided by timing.</p>
                </article>

                <article class="insight-card reveal" style="--d:.05s">
                    <p class="insight-tag">Cyber Crime</p>
                    <h3 class="insight-title">The first hours of an online fraud, and why they decide the outcome</h3>
                    <p class="insight-text">Reporting, freezing and preserving evidence &mdash; the three things that determine whether money is recovered and whether the record survives.</p>
                </article>

                <article class="insight-card reveal" style="--d:.1s">
                    <p class="insight-tag">Arbitration</p>
                    <h3 class="insight-title">Reading an arbitration clause before you sign it</h3>
                    <p class="insight-text">Seat, venue, number of arbitrators and scope &mdash; four terms that decide how a future dispute will actually be conducted.</p>
                </article>
            </div>
        </div>
    </section>

    <!-- ============================================================
         APPOINTMENT CTA BAND
         ============================================================ -->
    <div class="cta-band">
        <div class="container">
            <div class="cta-band-inner">
                <div>
                    <h2>Need to speak to the chamber?</h2>
                    <p>Monday to Friday 10:00 am &ndash; 7:00 pm &middot; Saturday 10:00 am &ndash; 2:00 pm</p>
                    <p>Consultations are by appointment.</p>
                </div>
                <div class="cta-band-actions">
                    <a class="btn btn-primary" href="#contact">Request an Appointment</a>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================
         CONTACT / APPOINTMENT
         ============================================================ -->
    <section class="section section-contact" id="contact">
        <div class="container">
            <div class="section-head reveal">
                <span class="ghost-num" data-parallax="0.35" aria-hidden="true">08</span>
                <p class="label">08 <span class="label-rule" aria-hidden="true"></span> Contact &amp; Appointment</p>
                <h2>Write to the Chamber</h2>
                <p class="section-sub">
                    Send a brief description of the matter and you will receive a reply at the email
                    address you provide. If something is urgent &mdash; a hearing, an arrest, a
                    deadline &mdash; say so in the first line, and it will be read accordingly.
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
                            <span class="contact-value"><?= e(OFFICE_HOURS) ?></span>
                        </li>
                    </ul>

                    <p class="contact-note">
                        Contacting the chamber, including through this website, does not by itself create a
                        lawyer&ndash;client relationship. Do not send confidential or privileged material before
                        an engagement is confirmed in writing.
                    </p>
                </div>

                <div class="contact-form-wrap reveal" style="--d:.1s">

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
                                <label for="f_name">Full Name <span class="req" aria-hidden="true">*</span></label>
                                <input type="text" id="f_name" name="name" autocomplete="name" maxlength="120" required>
                            </div>
                            <div class="field">
                                <label for="f_email">Email <span class="req" aria-hidden="true">*</span></label>
                                <input type="email" id="f_email" name="email" autocomplete="email" maxlength="254" required>
                            </div>
                            <div class="field">
                                <label for="f_telephone">Telephone <span class="opt" aria-hidden="true">(optional)</span></label>
                                <input type="tel" id="f_telephone" name="telephone" autocomplete="tel" maxlength="30">
                            </div>
                            <div class="field">
                                <label for="f_area">Area of Law</label>
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
                            <p class="field-hint" id="f_message-hint">Please do not include confidential or privileged material.</p>
                            <textarea id="f_message" name="message" rows="6" maxlength="4000" required></textarea>
                        </div>

                        <div class="field field--check">
                            <label class="check-label" for="f_consent">
                                <input type="checkbox" id="f_consent" name="consent" required>
                                <span class="check-box" aria-hidden="true"></span>
                                <span class="check-text">
                                    I have read the disclaimer and the privacy policy, and I understand
                                    that sending this message does not create a lawyer&ndash;client relationship.
                                </span>
                            </label>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary btn-submit" id="enquirySubmit">
                                Send Enquiry
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-arrow"/></svg>
                            </button>
                            <p class="form-status" id="formStatus" role="status" aria-live="polite"></p>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>

</main>

<?php require __DIR__ . '/includes/footer.php'; ?>