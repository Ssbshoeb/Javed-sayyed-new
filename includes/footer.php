<?php
/**
 * includes/footer.php — Site footer, floating mobile actions and scripts.
 */

if (!defined('SITE_NAME')) {
    http_response_code(403);
    exit('Forbidden');
}
?>
<footer class="site-footer" id="footer">
    <span class="footer-watermark" data-parallax="0.5" aria-hidden="true">J</span>
    <div class="container">

        <div class="footer-grid">

            <div class="footer-brand">
                <p class="footer-brand-name"><?= e(SITE_NAME) ?></p>
                <p class="footer-brand-tag"><?= e(SITE_TAGLINE) ?></p>
                <p class="footer-blurb">
                    Advocate practising before the High Court of Judicature at Bombay and the
                    Supreme Court of India, combining over two decades of senior corporate legal
                    leadership with a litigation and dispute-resolution practice.
                </p>
            </div>

            <nav class="footer-col" aria-label="Navigate">
                <p class="footer-col-title">Navigate</p>
                <ul class="footer-links">
                    <?php foreach ($primaryNav as $item): ?>
                        <li><a href="<?= e($item['href']) ?>"><?= e($item['label']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </nav>

            <div class="footer-col">
                <p class="footer-col-title">The Chamber</p>
                <ul class="footer-contact">
                    <li>
                        <?php foreach (OFFICE_ADDRESS_LINES as $line): ?>
                            <span><?= e($line) ?></span>
                        <?php endforeach; ?>
                    </li>
                    <li><a href="mailto:<?= e(EMAIL_MAILTO) ?>"><?= e(EMAIL_DISPLAY) ?></a></li>
                    <li><span><?= e(OFFICE_HOURS) ?></span></li>
                </ul>
            </div>

        </div>

        <div class="footer-legal">
            <p class="footer-legal-note">
                The rules of the Bar Council of India prohibit advocates from soliciting work or advertising
                in any manner. This website is an informational resource made available at the visitor&#8217;s
                own request. Nothing on it constitutes legal advice, and no lawyer–client relationship is
                created by using it or by contacting the chamber through it.
            </p>
            <div class="footer-legal-bar">
                <p>&copy; <?= date('Y') ?> <?= e(SITE_NAME) ?>. All rights reserved.</p>
                <ul class="footer-legal-links">
                    <li><a href="disclaimer.php">Disclaimer</a></li>
                    <li><a href="privacy.php">Privacy Policy</a></li>
                    <li><a href="terms.php">Terms of Use</a></li>
                </ul>
            </div>
        </div>

    </div>
</footer>

<div class="float-actions" aria-hidden="true">
    <a class="float-action" href="mailto:<?= e(EMAIL_MAILTO) ?>" aria-label="Email the chamber">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="m22 7-10 6L2 7"></path></svg>
    </a>
    <a class="float-action float-action--gold" href="#contact" aria-label="Request an appointment">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"></rect><path d="M16 2v4M8 2v4M3 10h18"></path></svg>
    </a>
</div>

<!-- Reading progress (desktop) -->
<div class="scroll-progress" id="scrollProgress" aria-hidden="true"></div>

<!-- Back to top -->
<button type="button" class="back-to-top" id="backToTop" aria-label="Back to top">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 19V5"/><path d="m5 12 7-7 7 7"/></svg>
</button>

<!-- Cursor glow (pointer-capable desktops only) -->
<div class="cursor-glow" id="cursorGlow" aria-hidden="true"></div>

<script src="assets/js/main.js" defer></script>
</body>
</html>