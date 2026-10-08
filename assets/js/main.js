/**
 * main.js — Adv. Javed Pashu Sayyed
 *
 * Capabilities:
 *   1. Adds .js to <html> (reveal animations only run with JS)
 *   2. Legal disclaimer overlay (localStorage consent, focus management)
 *   3. Sticky header state
 *   4. Mobile navigation
 *   5. Scroll-spy for section links
 *   6. Scroll-reveal via IntersectionObserver
 *   7. Contact form AJAX submit (no-JS fallback enforced on the server)
 *
 * No external dependencies. Respects prefers-reduced-motion.
 * The disclaimer overlay is visible by default (marked up in HTML) so it is
 * present even if JavaScript fails to load; when a valid stored consent is
 * found it is dismissed immediately.
 */

(function () {
  'use strict';

  var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var consentKey = 'advchamber_consent';
  var consentValue = 'accepted';

  document.documentElement.classList.add('js');

  /* ================================================================
     1. Legal disclaimer
     ================================================================ */
  function initDisclaimer() {
    var overlay = document.getElementById('disclaimerModal');
    if (!overlay) return;

    var acceptBtn = document.getElementById('disclaimerAccept');
    var declineBtn = document.getElementById('disclaimerDecline');
    var message = document.getElementById('disclaimerMessage');
    var html = document.documentElement;

    /* A previously stored consent in this browser lets the visitor straight in. */
    var alreadyConsented = false;
    try {
      alreadyConsented = localStorage.getItem(consentKey) === consentValue;
    } catch (e) {
      alreadyConsented = false;
    }
    if (!alreadyConsented) {
      try {
        alreadyConsented = sessionStorage.getItem(consentKey) === consentValue;
      } catch (e) {}
    }

    if (alreadyConsented) {
      overlay.classList.add('is-hidden');
      return;
    }

    /* Modal is live: lock the page behind it and manage focus. */
    html.classList.add('disclaimer-open');

    function dismiss() {
      overlay.classList.add('is-hidden');
      html.classList.remove('disclaimer-open');
      window.removeEventListener('keydown', trapFocus, true);
    }

    /* Move focus into the dialog once the entrance animation has played. */
    window.setTimeout(function () {
      if (acceptBtn && !overlay.classList.contains('is-hidden')) {
        acceptBtn.focus({ preventScroll: true });
      }
    }, 400);

    function trapFocus(e) {
      if (overlay.classList.contains('is-hidden')) return;
      if (e.key === 'Escape') {
        /* Escape never accepts the disclaimer. It simply draws focus back
           to the decision so keyboard users know the modal is open. */
        e.preventDefault();
        if (acceptBtn && acceptBtn.focus) acceptBtn.focus({ preventScroll: true });
        return;
      }
      if (e.key !== 'Tab') return;
      var focusables = overlay.querySelectorAll('button:not([disabled])');
      if (!focusables.length) return;
      var first = focusables[0];
      var last = focusables[focusables.length - 1];
      if (e.shiftKey && document.activeElement === first) {
        e.preventDefault();
        last.focus();
      } else if (!e.shiftKey && document.activeElement === last) {
        e.preventDefault();
        first.focus();
      }
    }

    acceptBtn.addEventListener('click', function () {
      try {
        localStorage.setItem(consentKey, consentValue);
        sessionStorage.setItem(consentKey, consentValue);
      } catch (e) {}
      dismiss();
    });

    declineBtn.addEventListener('click', function () {
      if (!message) return;
      message.hidden = false;
      if (message.focus) message.focus({ preventScroll: true });
      if (message.scrollIntoView) {
        window.setTimeout(function () {
          message.scrollIntoView({ block: 'center', behavior: prefersReducedMotion ? 'auto' : 'smooth' });
        }, 120);
      }
    });

    window.addEventListener('keydown', trapFocus, true);
  }

  /* ================================================================
     2. Sticky header state
     ================================================================ */
  function initHeaderState() {
    var header = document.getElementById('siteHeader');
    if (!header) return;

    var isTop = header.classList.contains('site-header--top');
    var lastY = window.scrollY;
    var ticking = false;

    /* Solid background once scrolled; slides out of the way when reading
       down the page and comes back as soon as the visitor scrolls up. */
    var update = function () {
      var y = window.scrollY;
      if (isTop) header.classList.toggle('is-scrolled', y > 24);

      var menuOpen = header.classList.contains('menu-open');
      if (!menuOpen && Math.abs(y - lastY) > 6) {
        header.classList.toggle('is-tucked', y > lastY && y > 480);
        lastY = y;
      }
      if (y <= 480) header.classList.remove('is-tucked');
      ticking = false;
    };
    update();
    window.addEventListener('scroll', function () {
      if (!ticking) { ticking = true; window.requestAnimationFrame(update); }
    }, { passive: true });

    /* Keyboard users tabbing into a tucked header must be able to see it. */
    header.addEventListener('focusin', function () { header.classList.remove('is-tucked'); });
  }

  /* ================================================================
     3. Mobile navigation
     ================================================================ */
  function initMobileNav() {
    var toggle = document.getElementById('navToggle');
    var nav = document.getElementById('siteNav');
    var header = document.getElementById('siteHeader');
    if (!toggle || !nav) return;

    function closeMenu() {
      nav.classList.remove('is-open');
      if (header) header.classList.remove('menu-open');
      toggle.setAttribute('aria-expanded', 'false');
      toggle.setAttribute('aria-label', 'Open menu');
      document.body.style.overflow = '';
    }
    function openMenu() {
      nav.classList.add('is-open');
      if (header) header.classList.add('menu-open');
      toggle.setAttribute('aria-expanded', 'true');
      toggle.setAttribute('aria-label', 'Close menu');
      document.body.style.overflow = 'hidden';
    }

    toggle.addEventListener('click', function () {
      if (nav.classList.contains('is-open')) closeMenu();
      else openMenu();
    });

    nav.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', closeMenu);
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && nav.classList.contains('is-open')) closeMenu();
    });
  }

  /* ================================================================
     4. Scroll-spy
     ================================================================ */
  function initScrollSpy() {
    var links = document.querySelectorAll('[data-navlink]');
    if (!links.length) return;

    var sections = [];
    links.forEach(function (link) {
      var href = link.getAttribute('href') || '';
      if (href.charAt(0) === '#') {
        var el = document.querySelector(href);
        if (el) sections.push({ id: href.slice(1), el: el, link: link });
      }
    });
    if (!sections.length) return;

    var header = document.getElementById('siteHeader');
    var offset = (header ? header.offsetHeight : 90) + 40;

    var onScroll = function () {
      var pos = window.scrollY + offset;
      var current = sections[0];
      for (var i = 0; i < sections.length; i++) {
        if (sections[i].el.offsetTop <= pos) current = sections[i];
      }
      sections.forEach(function (s) {
        var isActive = current && s.id === current.id && window.scrollY >= 60;
        s.link.classList.toggle('is-active', isActive);
        if (isActive) s.link.setAttribute('aria-current', 'true');
        else s.link.removeAttribute('aria-current');
      });
    };

    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  /* ================================================================
     5. Scroll-reveal
     ================================================================ */
  function initReveal() {
    var targets = document.querySelectorAll('.reveal');
    if (!targets.length) return;

    if (prefersReducedMotion || !('IntersectionObserver' in window)) {
      targets.forEach(function (el) { el.classList.add('is-in'); });
      return;
    }

    /* Elements that enter the viewport together are staggered, so a row of
       cards arrives one after another instead of all at once. Elements with
       an explicit --d (the hero) keep their own timing. */
    var io = new IntersectionObserver(function (entries) {
      var batch = 0;
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        var el = entry.target;
        if (!el.style.getPropertyValue('--d')) {
          el.style.setProperty('--d', Math.min(batch * 0.08, 0.48) + 's');
        }
        batch++;
        el.classList.add('is-in');
        io.unobserve(el);

        /* Once the entrance has played, drop the delay so hover effects
           respond instantly rather than inheriting the stagger. */
        window.setTimeout(function () {
          el.style.removeProperty('--d');
          el.classList.add('is-done');
        }, 1600);
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

    targets.forEach(function (el) { io.observe(el); });
  }

  /* ================================================================
     6. Contact form
     ================================================================ */
  function initContactForm() {
    var form = document.getElementById('enquiryForm');
    if (!form) return;

    var button = document.getElementById('enquirySubmit');
    var status = document.getElementById('formStatus');
    var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

    function clearFieldError(f) {
      f.classList.remove('is-invalid');
      f.removeAttribute('aria-invalid');
      var err = document.getElementById(f.id + '-error');
      if (err) err.remove();
      var described = f.getAttribute('aria-describedby') || '';
      if (described.indexOf('-error') !== -1) {
        f.removeAttribute('aria-describedby');
      }
    }

    function setFieldError(f, message) {
      f.classList.add('is-invalid');
      f.setAttribute('aria-invalid', 'true');
      var err = document.getElementById(f.id + '-error');
      if (!err) {
        err = document.createElement('p');
        err.className = 'field-error';
        err.id = f.id + '-error';
        f.parentElement.appendChild(err);
      }
      err.textContent = message;
      var described = [f.id + '-error'];
      var existing = f.getAttribute('aria-describedby');
      if (existing) described.push(existing);
      f.setAttribute('aria-describedby', described.join(' '));
    }

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      if (status) { status.textContent = ''; status.classList.remove('is-error'); }

      var data = new FormData(form);
      var fields = form.querySelectorAll('.field input, .field select, .field textarea');
      fields.forEach(function (f) { clearFieldError(f); });

      /* Client-side hints only; the server remains authoritative. */
      var firstInvalid = null;
      var messages = {};

      fields.forEach(function (f) {
        var val = String(f.value).trim();
        if (f.required && !val) {
          messages[f.id] = 'This field is required.';
        } else if (f.type === 'email' && val && !emailRe.test(val)) {
          messages[f.id] = 'Please enter a valid email address.';
        }
      });

      Object.keys(messages).forEach(function (id) {
        var f = document.getElementById(id);
        if (f) {
          setFieldError(f, messages[id]);
          if (!firstInvalid) firstInvalid = f;
        }
      });

      if (firstInvalid) {
        if (status) {
          status.textContent = 'Please complete the highlighted fields.';
          status.classList.add('is-error');
        }
        if (firstInvalid.focus) firstInvalid.focus({ preventScroll: true });
        return;
      }

      if (button) { button.disabled = true; button.textContent = 'Sending…'; }

      fetch(form.action, {
        method: 'POST',
        body: data,
        credentials: 'same-origin',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
        .then(function (res) { return res.json(); })
        .then(function (json) {
          if (status) {
            status.textContent = json.ok
              ? 'Thank you. Your enquiry has been sent, and you will receive a reply by email.'
              : (json.error || 'The enquiry could not be sent. Please try again.');
            status.classList.toggle('is-error', !json.ok);
          }
          if (json.ok) form.reset();
        })
        .catch(function () {
          if (status) {
            status.textContent = 'The enquiry could not be sent. Please email the chamber directly.';
            status.classList.add('is-error');
          }
        })
        .finally(function () {
          if (button) { button.disabled = false; button.textContent = 'Send enquiry'; }
        });
    });
  }

  /* ================================================================
     7. Back to top
     ================================================================ */
  function initBackToTop() {
    var btn = document.getElementById('backToTop');
    if (!btn) return;

    var update = function () {
      btn.classList.toggle('is-visible', window.scrollY > 700);
    };
    update();
    window.addEventListener('scroll', update, { passive: true });

    btn.addEventListener('click', function () {
      if (prefersReducedMotion) {
        window.scrollTo(0, 0);
      } else {
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }
    });
  }

  /* ================================================================
     Boot
     ================================================================ */
  function boot() {
    initDisclaimer();
    initHeaderState();
    initMobileNav();
    initScrollSpy();
    initReveal();
    initContactForm();
    initBackToTop();

    /* Catch any reveal element already in view that the observer delayed. */
    window.addEventListener('load', function () {
      document.querySelectorAll('.reveal:not(.is-in)').forEach(function (el) {
        if (el.getBoundingClientRect().top < window.innerHeight) el.classList.add('is-in');
      });
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
})();
/* --- Scroll Observer Animations --- */
document.addEventListener('DOMContentLoaded', () => {
    const observerOptions = { root: null, rootMargin: '0px 0px -10% 0px', threshold: 0.1 };
    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('in-view');
                obs.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const elementsToReveal = document.querySelectorAll('section h2, .practice-list > li, .court-list > li, .lead, .legal-lead, .mrow, .mhead__stats li');
    elementsToReveal.forEach(el => {
        el.classList.add('reveal-up');
        observer.observe(el);
    });
});

