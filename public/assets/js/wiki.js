/**
 * ternis.org Wiki — fully separated script (wiki.js).
 * Loaded ONLY on /{lang}/wiki* pages. No dependency on app.js.
 * Features: instant client-side search + code copy buttons. Zero trackers.
 */
(function () {
  'use strict';

  var LANG = (document.documentElement.getAttribute('lang') || 'en').toLowerCase();
  if (LANG !== 'en' && LANG !== 'de') LANG = 'en';

  /* ---------- code copy buttons ---------- */
  document.addEventListener('click', function (ev) {
    var btn = ev.target.closest ? ev.target.closest('.wiki-copy-btn') : null;
    if (!btn) return;
    var text = btn.getAttribute('data-copy') || '';
    if (!text) return;
    var done = function () {
      var orig = btn.textContent;
      btn.textContent = LANG === 'de' ? 'Kopiert!' : 'Copied!';
      setTimeout(function () { btn.textContent = orig; }, 1400);
    };
    if (navigator.clipboard && navigator.clipboard.writeText) {
      navigator.clipboard.writeText(text).then(done, done);
    } else {
      var ta = document.createElement('textarea');
      ta.value = text;
      ta.setAttribute('readonly', '');
      ta.style.position = 'absolute';
      ta.style.left = '-9999px';
      document.body.appendChild(ta);
      ta.select();
      try { document.execCommand('copy'); } catch (e) {}
      document.body.removeChild(ta);
      done();
    }
  });

  /* ---------- instant search ---------- */
  var input = document.querySelector('[data-wiki-search-input]');
  var box = document.querySelector('[data-wiki-search-results]');
  if (!input || !box) return;

  var index = null;
  var indexLoaded = false;

  function esc(s) {
    return String(s).replace(/[&<>"']/g, function (c) {
      return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
    });
  }

  function render(results, q) {
    if (!q) { box.hidden = true; box.innerHTML = ''; return; }
    if (!results.length) {
      box.hidden = false;
      box.innerHTML = '<span class="wiki-muted">' + esc(LANG === 'de' ? 'Keine Treffer.' : 'No matches.') + '</span>';
      return;
    }
    box.hidden = false;
    box.innerHTML = results.map(function (r) {
      return '<a href="' + esc(r.url) + '"><strong>' + esc(r.title) + '</strong>'
        + '<small>' + esc(r.category) + ' — ' + esc(r.description || '') + '</small></a>';
    }).join('');
  }

  function search(q) {
    q = q.trim().toLowerCase();
    if (!q || !index) { render([], q); return; }
    var out = [];
    for (var i = 0; i < index.length && out.length < 8; i++) {
      var e = index[i];
      var hay = ((e.title || '') + ' ' + (e.description || '') + ' ' + (e.category || '') + ' ' + ((e.tags || []).join(' '))).toLowerCase();
      if (hay.indexOf(q) !== -1) out.push(e);
    }
    render(out, q);
  }

  var t = null;
  input.addEventListener('input', function () {
    clearTimeout(t);
    t = setTimeout(function () { search(input.value); }, 150);
    if (!indexLoaded) {
      indexLoaded = true;
      fetch('/' + LANG + '/wiki/index.json', { headers: { Accept: 'application/json' } })
        .then(function (r) { return r.ok ? r.json() : []; })
        .then(function (j) { index = Array.isArray(j) ? j : (j.articles || []); search(input.value); })
        .catch(function () { index = []; });
    }
  });
})();
