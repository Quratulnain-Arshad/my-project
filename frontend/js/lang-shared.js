/**
 * lang-shared.js
 * Shared language persistence (localStorage) + header/footer updater.
 * Call setLang(lang) to save; getLang() to read. 'lang' is 'en' or 'ur'.
 */

// ── Persistence helpers ────────────────────────────────────────────────────
function getLang() {
  return localStorage.getItem('farmease_lang') || 'en';
}
function setLang(lang) {
  localStorage.setItem('farmease_lang', lang);
}

// ── Nav / Footer translations ──────────────────────────────────────────────
const NAV_FOOTER_TRANSLATIONS = {
  en: {
    nav: {
      home:      'Home',
      cropInfo:  'Crop Info',
      agriCost:  'AgriCost',
      contact:   'Contact',
    },
    footer: {
      tagline:   'Empowering farmers with smart, accessible knowledge.',
      home:      'Home',
      cropInfo:  'Crop Info',
      agriCost:  'AgriCost',
      contact:   'Contact',
      copy:      '\u00a9 ' + new Date().getFullYear() + ' FarmEase. All rights reserved.',
    },
  },
  ur: {
    nav: {
      home:      'ہوم',
      cropInfo:  'فصل کی معلومات',
      agriCost:  'زرعی لاگت',
      contact:   'رابطہ',
    },
    footer: {
      tagline:   'کسانوں کو ذہین اور قابلِ رسائی علم سے بااختیار بنانا۔',
      home:      'ہوم',
      cropInfo:  'فصل کی معلومات',
      agriCost:  'زرعی لاگت',
      contact:   'رابطہ',
      copy:      '\u00a9 ' + new Date().getFullYear() + ' فارم ایز۔ جملہ حقوق محفوظ ہیں۔',
    },
  },
};

/**
 * Updates all header nav + footer text.
 * @param {boolean} isUrdu
 */
function updateNavFooter(isUrdu) {
  const lang = isUrdu ? 'ur' : 'en';
  const t = NAV_FOOTER_TRANSLATIONS[lang];

  const setText = (id, text) => {
    const el = document.getElementById(id);
    if (el) el.textContent = text;
  };

  // Header nav
  setText('nav-home',      t.nav.home);
  setText('nav-crop-info', t.nav.cropInfo);
  setText('nav-agri-cost', t.nav.agriCost);
  setText('nav-contact',   t.nav.contact);

  // Footer
  setText('footer-tagline',       t.footer.tagline);
  setText('footer-nav-home',      t.footer.home);
  setText('footer-nav-crop-info', t.footer.cropInfo);
  setText('footer-nav-agri-cost', t.footer.agriCost);
  setText('footer-nav-contact',   t.footer.contact);
  setText('footer-copy',          t.footer.copy);
}
