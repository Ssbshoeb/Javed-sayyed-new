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
    if (!header || !header.classList.contains('site-header--top')) return;

    var update = function () {
      header.classList.toggle('is-scrolled', window.scrollY > 24);
    };
    update();
    window.addEventListener('scroll', update, { passive: true });
  }

  /* ================================================================
     3. Mobile navigation
     ================================================================ */
  function initMobileNav() {
    var toggle = document.getElementById('navToggle');
    var nav = document.getElementById('siteNav');
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

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-in');
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.08, rootMargin: '0px 0px -6% 0px' });

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
              ? 'Thank you. Your enquiry has been received. The chamber will read it and respond to you using the details provided.'
              : (json.error || 'The submission could not be processed. Please try again.');
            status.classList.toggle('is-error', !json.ok);
          }
          if (json.ok) form.reset();
        })
        .catch(function () {
          if (status) {
            status.textContent = 'The submission could not be sent. Please email the chamber directly.';
            status.classList.add('is-error');
          }
        })
        .finally(function () {
          if (button) { button.disabled = false; button.textContent = 'Send Enquiry'; }
        });
    });
  }

  /* ================================================================
     7. Reading progress bar
     ================================================================ */
  function initScrollProgress() {
    var bar = document.getElementById('scrollProgress');
    if (!bar) return;
    var ticking = false;
    function update() {
      var max = document.documentElement.scrollHeight - window.innerHeight;
      var p = max > 0 ? (window.scrollY / max) : 0;
      bar.style.transform = 'scaleX(' + p + ')';
      ticking = false;
    }
    window.addEventListener('scroll', function () {
      if (!ticking) { ticking = true; window.requestAnimationFrame(update); }
    }, { passive: true });
    update();
  }

  /* ================================================================
     8. Back to top
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
     9. Cursor glow + portrait tilt (desktop pointers only)
     ================================================================ */
  function initPointerEffects() {
    var finePointer = window.matchMedia('(pointer: fine)').matches;
    if (!finePointer || prefersReducedMotion) return;

    var glow = document.getElementById('cursorGlow');
    var frame = document.getElementById('portraitFrame');

    if (glow) {
      var tx = 0, ty = 0, cx = 0, cy = 0;
      var raf = null;

      document.addEventListener('mousemove', function (e) {
        cx = e.clientX;
        cy = e.clientY;
        if (!glow.classList.contains('is-active')) glow.classList.add('is-active');
        if (!raf) raf = window.requestAnimationFrame(step);
      }, { passive: true });

      function step() {
        tx += (cx - tx) * 0.12;
        ty += (cy - ty) * 0.12;
        glow.style.transform = 'translate(' + tx + 'px,' + ty + 'px)';
        raf = null;
      }

      document.documentElement.addEventListener('mouseleave', function () {
        glow.classList.remove('is-active');
      });
    }

    if (frame) {
      var rtx = 0, rty = 0, rcx = 0, rcy = 0, rraf = null, rotating = false;
      frame.addEventListener('mousemove', function (e) {
        var rect = frame.getBoundingClientRect();
        var px = (e.clientX - rect.left) / rect.width - 0.5;
        var py = (e.clientY - rect.top) / rect.height - 0.5;
        rcx = py * -7;
        rcy = px * 9;
        if (!rraf) rraf = window.requestAnimationFrame(stepRotate);
      });
      function stepRotate() {
        rtx += (rcx - rtx) * 0.08;
        rty += (rcy - rty) * 0.08;
        frame.style.transform = 'rotateX(' + rtx + 'deg) rotateY(' + rty + 'deg)';
        rraf = null;
      }
      frame.addEventListener('mouseleave', function () {
        rcx = 0; rcy = 0;
        if (!rraf) rraf = window.requestAnimationFrame(stepRotate);
      });
    }
  }

  /* ================================================================
     10. Smoother, eased anchor scrolling
     ----------------------------------------------------------------
     Replaces the browser's built-in jump/smooth with a buttery rAF-driven
     ease. Cancels cleanly if the user wheels/touches/keys in mid-flight.
     Respects prefers-reduced-motion (falls back to instant navigation).
     ================================================================ */
  var smoothAnimId = null;

  function cancelSmoothScroll() {
    if (smoothAnimId) {
      cancelAnimationFrame(smoothAnimId);
      smoothAnimId = null;
    }
  }

  function beginEasedScroll(targetTop, duration) {
    cancelSmoothScroll();
    var start = window.scrollY;
    var dist = targetTop - start;
    if (Math.abs(dist) < 2) return;

    var t0 = performance.now();

    function cancelOnUser() { cancelSmoothScroll(); }
    ['wheel', 'touchstart'].forEach(function (ev) {
      window.addEventListener(ev, cancelOnUser, { passive: true, once: true });
    });
    document.addEventListener('keydown', cancelOnUser, { once: true });

    function easeOutQuart(t) { return 1 - Math.pow(1 - t, 4); }

    function step(now) {
      var t = Math.min(1, (now - t0) / duration);
      var eased = easeOutQuart(t);
      window.scrollTo({ top: start + dist * eased, behavior: 'instant' });
      if (t < 1) {
        smoothAnimId = requestAnimationFrame(step);
      } else {
        smoothAnimId = null;
      }
    }
    smoothAnimId = requestAnimationFrame(step);
  }

  function initSmoothAnchors() {
    if (prefersReducedMotion) return;
    var header = document.getElementById('siteHeader');

    document.querySelectorAll('a[href^="#"]').forEach(function (a) {
      /* Skip the accessibility skip-link — it must move focus natively. */
      if (a.classList.contains('skip-link')) return;

      a.addEventListener('click', function (e) {
        var hash = a.getAttribute('href');
        if (!hash || hash === '#') return;
        var target = document.querySelector(hash);
        if (!target) return;

        e.preventDefault();
        var offset = header ? header.offsetHeight : 0;
        var top = target.getBoundingClientRect().top + window.scrollY - offset;
        if (top < 0) top = 0;

        beginEasedScroll(top, 1000);
        if (history.replaceState) history.replaceState(null, '', hash);
      });
    });
  }

  /* ================================================================
     11. Scroll parallax — decorative drifting (transform-only)
     ================================================================ */
  function initParallax() {
    if (prefersReducedMotion) return;
    var els = document.querySelectorAll('[data-parallax]');
    if (!els.length) return;

    var specs = [];
    els.forEach(function (el) {
      specs.push({ el: el, factor: parseFloat(el.getAttribute('data-parallax')) || 0.25 });
    });

    var ticking = false;
    function update() {
      var vh = window.innerHeight;
      specs.forEach(function (s) {
        var r = s.el.getBoundingClientRect();
        var dist = r.top + r.height / 2 - vh / 2;   /* 0 = centred */
        var dy = -dist * s.factor * 0.16;           /* gentle */
        s.el.style.transform = 'translate3d(0,' + dy.toFixed(1) + 'px,0)';
      });
      ticking = false;
    }
    window.addEventListener('scroll', function () {
      if (!ticking) { ticking = true; requestAnimationFrame(update); }
    }, { passive: true });
    window.addEventListener('resize', function () {
      if (!ticking) { ticking = true; requestAnimationFrame(update); }
    }, { passive: true });
    update();
  }

  /* ================================================================
     12. Hero departure — fade + gentle lift as you scroll away
     ================================================================ */
  function initHeroFade() {
    if (prefersReducedMotion) return;
    var hero = document.getElementById('home');
    if (!hero) return;

    var parts = hero.querySelectorAll('.hero-copy, .hero-figure, .hero-scrollhint');
    if (!parts.length) return;

    var ticking = false;
    function update() {
      var h = hero.offsetHeight || window.innerHeight;
      var p = Math.min(1, window.scrollY / (h * 0.72));
      if (p <= 0) {
        parts.forEach(function (el) {
          el.style.opacity = '';
          el.style.transform = '';
        });
        ticking = false;
        return;
      }

      var fade = 1 - p * 0.55;
      var lift = p * 52;

      parts.forEach(function (el) {
        if (!el.classList.contains('is-in')) return;   /* let reveals finish first */
        el.style.transition = 'none';                  /* don't let reveal's 1s transition lag the scroll */
        el.style.opacity = fade.toFixed(3);
        el.style.transform = 'translate3d(0,' + (el.classList.contains('hero-copy') ? lift : lift * 0.55).toFixed(1) + 'px,0)';
      });
      ticking = false;
    }
    window.addEventListener('scroll', function () {
      if (!ticking) { ticking = true; requestAnimationFrame(update); }
    }, { passive: true });
    update();
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
    initScrollProgress();
    initBackToTop();
    initPointerEffects();
    initSmoothAnchors();
    initParallax();
    initHeroFade();

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