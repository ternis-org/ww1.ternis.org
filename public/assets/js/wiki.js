/**
 * ternis.org Wiki — Dedicated Interactive Script (wiki.js)
 * Pure vanilla JavaScript. Zero external dependencies. Zero trackers.
 * Features:
 *  - Command Palette Search Modal (Ctrl+K / Cmd+K / /)
 *  - In-Page Instant Search & Category Article Filtering
 *  - Code Block Copy with Animated SVG Feedback
 *  - Article URL Sharing / Copy Link Feedback
 *  - Table of Contents Scrollspy & Active Section Highlighting
 *  - Top Reading Progress Bar
 *  - Back to Top Smooth Scroll
 *  - Mobile Navigation Drawer
 *  - Dark / Light Theme Toggle synchronized with localStorage
 */
(function () {
  'use strict';

  var LANG = (document.documentElement.getAttribute('lang') || 'en').toLowerCase();
  if (LANG !== 'en' && LANG !== 'de') LANG = 'en';

  /* ---------- Helpers ---------- */
  function esc(s) {
    return String(s || '').replace(/[&<>"']/g, function (c) {
      return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
    });
  }

  function copyText(text, onSuccess) {
    if (!text) return;
    if (navigator.clipboard && navigator.clipboard.writeText) {
      navigator.clipboard.writeText(text).then(onSuccess, onSuccess);
    } else {
      var ta = document.createElement('textarea');
      ta.value = text;
      ta.setAttribute('readonly', '');
      ta.style.position = 'fixed';
      ta.style.left = '-9999px';
      document.body.appendChild(ta);
      ta.select();
      try { document.execCommand('copy'); } catch (e) {}
      document.body.removeChild(ta);
      if (onSuccess) onSuccess();
    }
  }

  /* ---------- Search Index Loader ---------- */
  var searchIndex = null;
  var isIndexLoading = false;

  function loadSearchIndex(callback) {
    if (searchIndex !== null) {
      if (callback) callback(searchIndex);
      return;
    }
    if (isIndexLoading) return;
    isIndexLoading = true;
    fetch('/' + LANG + '/wiki/index.json', { headers: { Accept: 'application/json' } })
      .then(function (r) { return r.ok ? r.json() : []; })
      .then(function (data) {
        searchIndex = Array.isArray(data) ? data : (data.articles || []);
        isIndexLoading = false;
        if (callback) callback(searchIndex);
      })
      .catch(function () {
        searchIndex = [];
        isIndexLoading = false;
        if (callback) callback(searchIndex);
      });
  }

  function queryIndex(q, limit) {
    q = q.trim().toLowerCase();
    limit = limit || 10;
    if (!q || !searchIndex) return [];
    var hits = [];
    for (var i = 0; i < searchIndex.length; i++) {
      var item = searchIndex[i];
      var title = (item.title || '').toLowerCase();
      var desc = (item.description || '').toLowerCase();
      var cat = (item.category || '').toLowerCase();
      var tags = (item.tags || []).join(' ').toLowerCase();

      // Match scoring
      if (title.indexOf(q) !== -1 || cat.indexOf(q) !== -1 || tags.indexOf(q) !== -1 || desc.indexOf(q) !== -1) {
        hits.push(item);
      }
      if (hits.length >= limit) break;
    }
    return hits;
  }

  /* ---------- Command Palette / Modal Search ---------- */
  var searchModal = document.getElementById('wiki-search-modal');
  var modalInput = searchModal ? searchModal.querySelector('[data-wiki-modal-input]') : null;
  var modalResults = searchModal ? searchModal.querySelector('[data-wiki-modal-results]') : null;
  var selectedModalIndex = -1;

  function openSearchModal() {
    if (!searchModal) return;
    searchModal.hidden = false;
    document.body.style.overflow = 'hidden';
    loadSearchIndex(function () {
      if (modalInput) {
        modalInput.focus();
        if (modalInput.value) performModalSearch(modalInput.value);
      }
    });
  }

  function closeSearchModal() {
    if (!searchModal) return;
    searchModal.hidden = true;
    document.body.style.overflow = '';
    selectedModalIndex = -1;
  }

  function renderModalResults(results, q) {
    if (!modalResults) return;
    selectedModalIndex = -1;
    if (!q) {
      modalResults.innerHTML = '<div class="wiki-modal-empty"><p class="wiki-modal-hint">'
        + esc(LANG === 'de' ? 'Oben tippen, um Artikel nach Titel, Thema oder Tag zu durchsuchen.' : 'Type above to search articles by title, topic, or tag.')
        + '</p></div>';
      return;
    }
    if (!results.length) {
      modalResults.innerHTML = '<div class="wiki-modal-empty"><p class="wiki-modal-hint">'
        + esc(LANG === 'de' ? 'Keine passenden Artikel gefunden.' : 'No matching articles found.')
        + '</p></div>';
      return;
    }

    modalResults.innerHTML = results.map(function (r, idx) {
      return '<a href="' + esc(r.url) + '" class="wiki-modal-item" data-modal-idx="' + idx + '">'
        + '<div class="wiki-modal-item-ico"><svg class="wiki-ico wiki-ico-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8.5"/><path d="M3.5 12h17M12 3.5c3.2 3.6 3.2 13.4 0 17M12 3.5c-3.2 3.6-3.2 13.4 0 17"/></svg></div>'
        + '<div class="wiki-modal-item-info">'
        + '<span class="wiki-modal-item-title">' + esc(r.title) + '</span>'
        + '<span class="wiki-modal-item-meta">' + esc(r.category) + '<span class="wiki-sep-dot"><svg class="wiki-ico wiki-ico-xs" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><circle cx="12" cy="12" r="3"/></svg></span>' + esc(r.description || '') + '</span>'
        + '</div>'
        + '<svg class="wiki-ico wiki-ico-xs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>'
        + '</a>';
    }).join('');
  }

  function performModalSearch(val) {
    var hits = queryIndex(val, 8);
    renderModalResults(hits, val.trim());
  }

  if (modalInput) {
    var modalDebounce = null;
    modalInput.addEventListener('input', function () {
      clearTimeout(modalDebounce);
      modalDebounce = setTimeout(function () {
        performModalSearch(modalInput.value);
      }, 100);
    });

    modalInput.addEventListener('keydown', function (e) {
      var items = modalResults ? modalResults.querySelectorAll('.wiki-modal-item') : [];
      if (!items.length) return;

      if (e.key === 'ArrowDown') {
        e.preventDefault();
        selectedModalIndex = (selectedModalIndex + 1) % items.length;
        updateModalSelection(items);
      } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        selectedModalIndex = (selectedModalIndex - 1 + items.length) % items.length;
        updateModalSelection(items);
      } else if (e.key === 'Enter') {
        if (selectedModalIndex >= 0 && items[selectedModalIndex]) {
          e.preventDefault();
          window.location.href = items[selectedModalIndex].getAttribute('href');
        }
      }
    });
  }

  function updateModalSelection(items) {
    for (var i = 0; i < items.length; i++) {
      if (i === selectedModalIndex) {
        items[i].classList.add('is-selected');
        items[i].scrollIntoView({ block: 'nearest' });
      } else {
        items[i].classList.remove('is-selected');
      }
    }
  }

  // Open / Close Triggers
  document.addEventListener('click', function (e) {
    if (e.target.closest('[data-wiki-search-trigger]')) {
      e.preventDefault();
      openSearchModal();
      return;
    }
    if (e.target.closest('[data-wiki-modal-close]')) {
      e.preventDefault();
      closeSearchModal();
      return;
    }
  });

  // Global Keyboard Shortcuts (Ctrl+K, Cmd+K, /)
  document.addEventListener('keydown', function (e) {
    if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
      e.preventDefault();
      if (searchModal && !searchModal.hidden) {
        closeSearchModal();
      } else {
        openSearchModal();
      }
      return;
    }
    if (e.key === '/' && searchModal && searchModal.hidden) {
      var activeTag = document.activeElement ? document.activeElement.tagName.toLowerCase() : '';
      if (activeTag !== 'input' && activeTag !== 'textarea') {
        e.preventDefault();
        openSearchModal();
        return;
      }
    }
    if (e.key === 'Escape' && searchModal && !searchModal.hidden) {
      e.preventDefault();
      closeSearchModal();
    }
  });

  /* ---------- Homepage Inline Search Dropdown ---------- */
  var homeInput = document.querySelector('[data-wiki-search-input]:not([data-wiki-modal-input])');
  var homeResults = document.querySelector('[data-wiki-search-results]:not([data-wiki-modal-results])');

  if (homeInput && homeResults) {
    var homeDebounce = null;
    homeInput.addEventListener('focus', function () {
      loadSearchIndex(function () {
        if (homeInput.value.trim()) renderHomeResults(queryIndex(homeInput.value, 6), homeInput.value.trim());
      });
    });

    homeInput.addEventListener('input', function () {
      clearTimeout(homeDebounce);
      homeDebounce = setTimeout(function () {
        loadSearchIndex(function () {
          renderHomeResults(queryIndex(homeInput.value, 6), homeInput.value.trim());
        });
      }, 120);
    });

    document.addEventListener('click', function (e) {
      if (!homeInput.contains(e.target) && !homeResults.contains(e.target)) {
        homeResults.hidden = true;
      }
    });
  }

  function renderHomeResults(results, q) {
    if (!homeResults) return;
    if (!q) {
      homeResults.hidden = true;
      homeResults.innerHTML = '';
      return;
    }
    homeResults.hidden = false;
    if (!results.length) {
      homeResults.innerHTML = '<div style="padding: 0.75rem; text-align: center; color: var(--wiki-text-muted); font-size: 0.9rem;">'
        + esc(LANG === 'de' ? 'Keine Treffer.' : 'No matches found.') + '</div>';
      return;
    }
    homeResults.innerHTML = results.map(function (r) {
      return '<a href="' + esc(r.url) + '">'
        + '<strong>' + esc(r.title) + '</strong>'
        + '<small>' + esc(r.category) + '<span class="wiki-sep-dot"><svg class="wiki-ico wiki-ico-xs" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><circle cx="12" cy="12" r="3"/></svg></span>' + esc(r.description || '') + '</small>'
        + '</a>';
    }).join('');
  }

  /* ---------- Category Articles Live Filter ---------- */
  var categoryFilterInput = document.querySelector('[data-wiki-category-filter]');
  var articleListContainer = document.querySelector('[data-wiki-article-list]');

  if (categoryFilterInput && articleListContainer) {
    categoryFilterInput.addEventListener('input', function () {
      var val = categoryFilterInput.value.trim().toLowerCase();
      var items = articleListContainer.querySelectorAll('[data-article-item]');
      for (var i = 0; i < items.length; i++) {
        var text = (items[i].textContent || '').toLowerCase();
        if (!val || text.indexOf(val) !== -1) {
          items[i].style.display = '';
        } else {
          items[i].style.display = 'none';
        }
      }
    });
  }

  /* ---------- Code Block Copy Buttons ---------- */
  document.addEventListener('click', function (ev) {
    var btn = ev.target.closest ? ev.target.closest('.wiki-copy-btn') : null;
    if (!btn) return;
    var text = btn.getAttribute('data-copy') || '';
    if (!text) return;
    copyText(text, function () {
      btn.classList.add('is-copied');
      var label = btn.querySelector('.wiki-copy-label');
      var origText = label ? label.textContent : '';
      if (label) label.textContent = LANG === 'de' ? 'Kopiert!' : 'Copied!';
      setTimeout(function () {
        btn.classList.remove('is-copied');
        if (label) label.textContent = origText;
      }, 1600);
    });
  });

  /* ---------- Copy Article Link Button ---------- */
  document.addEventListener('click', function (ev) {
    var btn = ev.target.closest ? ev.target.closest('[data-wiki-copy-link]') : null;
    if (!btn) return;
    var url = btn.getAttribute('data-url') || window.location.href;
    copyText(url, function () {
      btn.classList.add('is-copied');
      var label = btn.querySelector('.wiki-copy-link-label');
      var orig = label ? label.textContent : '';
      if (label) label.textContent = LANG === 'de' ? 'Kopiert!' : 'Copied!';
      setTimeout(function () {
        btn.classList.remove('is-copied');
        if (label) label.textContent = orig;
      }, 1600);
    });
  });

  /* ---------- Reading Progress Bar & Back to Top ---------- */
  var progressBar = document.querySelector('.wiki-progress-fill');
  var backToTopBtn = document.getElementById('wiki-back-to-top');

  function onScroll() {
    var scrollTop = window.pageYOffset || document.documentElement.scrollTop || 0;
    var docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    
    // Progress
    if (progressBar && docHeight > 0) {
      var pct = Math.min(100, Math.max(0, (scrollTop / docHeight) * 100));
      progressBar.style.width = pct + '%';
    }

    // Back to top button visibility
    if (backToTopBtn) {
      if (scrollTop > 320) {
        backToTopBtn.classList.add('is-visible');
      } else {
        backToTopBtn.classList.remove('is-visible');
      }
    }
  }

  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  if (backToTopBtn) {
    backToTopBtn.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  document.addEventListener('click', function (e) {
    if (e.target.closest('[data-wiki-scroll-top]')) {
      e.preventDefault();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
  });

  /* ---------- Table of Contents Scrollspy ---------- */
  var tocNav = document.querySelector('[data-wiki-toc-nav]');
  if (tocNav) {
    var tocLinks = tocNav.querySelectorAll('.wiki-toc-link');
    var headings = [];
    for (var i = 0; i < tocLinks.length; i++) {
      var targetId = tocLinks[i].getAttribute('data-toc-target');
      var targetEl = document.getElementById(targetId);
      if (targetEl) {
        headings.push({ el: targetEl, link: tocLinks[i] });
      }
    }

    if (headings.length > 0) {
      var spyDebounce = null;
      window.addEventListener('scroll', function () {
        clearTimeout(spyDebounce);
        spyDebounce = setTimeout(function () {
          var scrollPos = (window.pageYOffset || document.documentElement.scrollTop || 0) + 100;
          var current = headings[0];
          for (var j = 0; j < headings.length; j++) {
            if (headings[j].el.offsetTop <= scrollPos) {
              current = headings[j];
            }
          }
          for (var k = 0; k < headings.length; k++) {
            if (headings[k] === current) {
              headings[k].link.classList.add('is-active');
            } else {
              headings[k].link.classList.remove('is-active');
            }
          }
        }, 30);
      }, { passive: true });
    }
  }

  /* ---------- Mobile Navigation Drawer ---------- */
  var drawer = document.getElementById('wiki-mobile-drawer');
  var drawerBackdrop = document.getElementById('wiki-mobile-drawer-backdrop');

  function openDrawer() {
    if (!drawer) return;
    drawer.hidden = false;
    if (drawerBackdrop) drawerBackdrop.hidden = false;
    setTimeout(function () {
      drawer.classList.add('is-open');
    }, 10);
    document.body.style.overflow = 'hidden';
  }

  function closeDrawer() {
    if (!drawer) return;
    drawer.classList.remove('is-open');
    setTimeout(function () {
      drawer.hidden = true;
      if (drawerBackdrop) drawerBackdrop.hidden = true;
      document.body.style.overflow = '';
    }, 250);
  }

  document.addEventListener('click', function (e) {
    if (e.target.closest('[data-wiki-drawer-toggle]')) {
      e.preventDefault();
      openDrawer();
      return;
    }
    if (e.target.closest('[data-wiki-drawer-close]')) {
      e.preventDefault();
      closeDrawer();
      return;
    }
  });

  /* ---------- Theme Toggle ---------- */
  document.addEventListener('click', function (e) {
    var btn = e.target.closest ? e.target.closest('[data-wiki-theme-toggle]') : null;
    if (!btn) return;
    e.preventDefault();
    var current = document.documentElement.getAttribute('data-theme') || 'light';
    var next = current === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', next);
    try {
      localStorage.setItem('ternis_theme', next);
    } catch (err) {}
  });

})();
