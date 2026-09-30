<?php
/**
 * config.php — Central configuration.
 *
 * Edit values in this single file to change site-wide settings.
 * No credentials should ever be committed here or anywhere in the frontend.
 */

declare(strict_types=1);

/* ------------------------------------------------------------------
 * Site identity
 * ---------------------------------------------------------------- */
const SITE_NAME    = 'Adv. Javed Pashu Sayyed';
const SITE_TAGLINE = 'Advocate · Litigator · Legal Advisor';

/* Base URL used for canonical / Open Graph / Twitter tags.
 * Keep the trailing slash off. Update when the domain changes. */
const SITE_URL = 'https://pune.javedpashusayyed.com';

/* The exact name leads the title so a search for "Javed Pashu Sayyed" matches it first. */
const SITE_TITLE_BASE = 'Javed Pashu Sayyed | Advocate in Pune, Bombay High Court & Supreme Court';

const SITE_DESC = 'Adv. Javed Pashu Sayyed is an advocate in Pune practising before the Supreme Court of India, the Bombay High Court and courts across Maharashtra. Chamber No. 52/B, District & Sessions Court, Shivajinagar, Pune.';

/* Other spellings people search for. Used as schema.org alternateName. */
const SITE_ALT_NAMES = [
    'Adv. Javed Sayyed',
    'Javed Sayyed',
    'Javed Pashu Syed',
    'Advocate Javed Pashu Sayyed',
];

/* Official profiles of the advocate (LinkedIn, Facebook, Instagram, Google Business
 * Profile, Bar association listing…). Add full URLs here — each one tells Google
 * that these profiles and this website are the same person. Leave empty if none. */
const SOCIAL_PROFILES = [
    // 'https://www.linkedin.com/in/...',
    // 'https://www.facebook.com/...',
    // 'https://www.instagram.com/...',
];

/* ------------------------------------------------------------------
 * Portraits
 * ---------------------------------------------------------------
 * 4:5 photographs in assets/images/. To swap, replace the files (or point
 * these constants at new ones) and keep PORTRAIT_W / PORTRAIT_H in step.
 * ---------------------------------------------------------------- */
const PORTRAIT_SRC = 'assets/images/javed-pashu-sayyed.jpg';
const PORTRAIT_ALT = 'Adv. Javed Pashu Sayyed — portrait';
const PORTRAIT_W   = 640;   /* rendered width in px (also used to prevent layout shift) */
const PORTRAIT_H   = 800;   /* rendered height in px */

const PORTRAIT_ABOUT_SRC = 'assets/images/javed-pashu-sayyed-about.jpg';
const PORTRAIT_ABOUT_ALT = 'Adv. Javed Pashu Sayyed — portrait, about section';

/* ------------------------------------------------------------------
 * Contact / appointment
 * ---------------------------------------------------------------- */
const ADVOCATE_NAME = 'Adv. Javed Pashu Sayyed';

const OFFICE_ADDRESS_LINES = [
    'Chamber No. 52/B, District & Sessions Court Pune',
    'Chhatrapati Shivaji Maharaj Rd, Shivajinagar, Pune, Maharashtra 411005',
];

const EMAIL_DISPLAY = 'adv.syedhc@gmail.com';
const EMAIL_MAILTO  = 'adv.syedhc@gmail.com';

/* Office hours as published by the chamber. */
const OFFICE_HOURS = 'Monday to Friday 10:00 am – 7:00 pm · Saturday 10:00 am – 2:00 pm';

/* ------------------------------------------------------------------
 * Contact form
 * ----------------------------------------------------------------
 * Destination mailbox for all enquiries. Change here only —
 * do not change it in the frontend files.
 * ---------------------------------------------------------------- */
const MAIL_TO           = 'adv.syedhc@gmail.com';
const MAIL_FROM_ADDRESS = 'adv.syedhc@gmail.com';
const MAIL_FROM_NAME    = 'Adv. Javed Pashu Sayyed Website';

/* Selectable practice areas for the form. Keep in step with $practiceAreas in index.php. */
const AREAS_OF_LAW = [
    'Criminal Law',
    'Family Law',
    'Corporate Law',
    'Arbitration & Dispute Resolution',
    'Cyber Crime Law',
    'Property Law',
    'Consumer Law',
    'Human Rights Law',
    'Immigration Law',
    'Intellectual Property Law',
];

/* ------------------------------------------------------------------
 * Rate limiting (anti-spam)
 * ---------------------------------------------------------------- */
const RATE_LIMIT_WINDOW_SECONDS = 3600;
const RATE_LIMIT_MAX_PER_WINDOW = 5;