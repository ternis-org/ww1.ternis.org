/**
 * ternis.org Wiki — Dedicated Interactive Script (wiki.js)
 * Pure vanilla JavaScript. Zero external dependencies. Zero trackers.
 * Modern, accessible, lightweight documentation frontend suite.
 *
 * Features:
 *  - Accessible Toast Notification System (WikiToast)
 *  - Code Block Copy with Language/Line Breakdown & Success Toast
 *  - Code Block Word Wrap Toggle
 *  - Heading Anchor Permalink Copy with Instant Toast Feedback
 *  - Article URL Sharing with Copy Feedback
 *  - Command Palette Search Modal (Ctrl+K / Cmd+K / /) with Focus Trap & Term Highlighting
 *  - Smart Multi-Term Search Index Querying & Ranking
 *  - Table of Contents Scrollspy (IntersectionObserver)
 *  - Mobile TOC Auto-Close on Section Selection
 *  - Mobile Drawer with Focus Management & Escape Dismissal
 *  - Top Reading Progress Bar & Smooth Back to Top
 *  - Dark / Light Theme Synchronization
 */
(function () {
  'use strict';

  var LANG = (document.documentElement.getAttribute('lang') || 'en').toLowerCase();
  if (LANG !== 'en' && LANG !== 'de') LANG = 'en';

  /* ---------- Bilingual Dictionary ---------- */
  var I18N = {
    en: {
      codeCopied: 'Code copied to clipboard',
      linkCopied: 'Article link copied to clipboard',
      anchorCopied: 'Section link copied to clipboard',
      copyFailed: 'Failed to copy to clipboard',
      copied: 'Copied!',
      copy: 'Copy',
      wrapEnabled: 'Line wrap enabled',
      wrapDisabled: 'Line wrap disabled',
      lines: 'lines',
      line: 'line',
      snippetCopied: 'snippet copied',
      dismiss: 'Dismiss notification',
      searchHint: 'Type above to search articles by title, topic, or tag.',
      noMatches: 'No matching articles found.'
    },
    de: {
      codeCopied: 'Code in die Zwischenablage kopiert',
      linkCopied: 'Artikellink in die Zwischenablage kopiert',
      anchorCopied: 'Abschnittslink in die Zwischenablage kopiert',
      copyFailed: 'Kopieren in Zwischenablage fehlgeschlagen',
      copied: 'Kopiert!',
      copy: 'Kopieren',
      wrapEnabled: 'Zeilenumbruch aktiviert',
      wrapDisabled: 'Zeilenumbruch deaktiviert',
      lines: 'Zeilen',
      line: 'Zeile',
      snippetCopied: 'Snippet kopiert',
      dismiss: 'Benachrichtigung schließen',
      searchHint: 'Oben tippen, um Artikel nach Titel, Thema oder Tag zu durchsuchen.',
      noMatches: 'Keine passenden Artikel gefunden.'
    }
  };
  var t = I18N[LANG] || I18N.en;

  /* ---------- Utility Helpers ---------- */
  function esc(s) {
    return String(s || '').replace(/[&<>"']/g, function (c) {
      return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
    });
  }

  function highlightMatch(text, query) {
    if (!text) return '';
    if (!query) return esc(text);
    var terms = query.trim().split(/\s+/).filter(Boolean);
    if (!terms.length) return esc(text);

    var pattern = terms.map(function (w) {
      return w.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }).join('|');

    var escaped = esc(text);
    try {
      var regex = new RegExp('(' + pattern + ')', 'gi');
      return escaped.replace(regex, '<mark class="wiki-search-match">$1</mark>');
    } catch (e) {
      return escaped;
    }
  }

  function copyText(text, onSuccess, onError) {
    if (!text) return;
    if (navigator.clipboard && navigator.clipboard.writeText) {
      navigator.clipboard.writeText(text)
        .then(function () { if (onSuccess) onSuccess(); })
        .catch(function () { fallbackCopy(text, onSuccess, onError); });
    } else {
      fallbackCopy(text, onSuccess, onError);
    }
  }

  function fallbackCopy(text, onSuccess, onError) {
    var ta = document.createElement('textarea');
    ta.value = text;
    ta.setAttribute('readonly', '');
    ta.style.position = 'fixed';
    ta.style.top = '0';
    ta.style.left = '-9999px';
    ta.style.opacity = '0';
    document.body.appendChild(ta);
    ta.focus();
    ta.select();
    var success = false;
    try {
      success = document.execCommand('copy');
    } catch (err) {
      success = false;
    }
    document.body.removeChild(ta);
    if (success) {
      if (onSuccess) onSuccess();
    } else {
      if (onError) onError();
    }
  }

  /* ---------- Toast Notification System (WikiToast) ---------- */
  var TOAST_ICONS = {
    success: '<svg class="wiki-ico wiki-ico-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>',
    info: '<svg class="wiki-ico wiki-ico-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><line x1="12" y1="16" x2="12" y2="12"/><circle cx="12" cy="8" r="1" fill="currentColor"/></svg>',
    warning: '<svg class="wiki-ico wiki-ico-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><circle cx="12" cy="17" r="1" fill="currentColor"/></svg>',
    error: '<svg class="wiki-ico wiki-ico-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',
    close: '<svg class="wiki-ico wiki-ico-xs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>'
  };

  var WikiToast = (function () {
    var container = null;
    var MAX_VISIBLE_TOASTS = 4;

    function getContainer() {
      if (!container || !document.body.contains(container)) {
        container = document.getElementById('wiki-toast-container');
        if (!container) {
          container = document.createElement('div');
          container.id = 'wiki-toast-container';
          container.className = 'wiki-toast-container';
          container.setAttribute('role', 'region');
          container.setAttribute('aria-label', 'Notifications');
          container.setAttribute('aria-live', 'polite');
          container.setAttribute('aria-atomic', 'true');
          document.body.appendChild(container);
        }
      }
      return container;
    }

    function dismiss(toastEl) {
      if (!toastEl || toastEl._isDismissing) return;
      toastEl._isDismissing = true;
      if (toastEl._timer) clearTimeout(toastEl._timer);

      toastEl.classList.remove('is-visible');
      toastEl.classList.add('is-leaving');

      setTimeout(function () {
        if (toastEl.parentNode) {
          toastEl.parentNode.removeChild(toastEl);
        }
      }, 260);
    }

    function show(options) {
      options = options || {};
      var title = options.title || '';
      var message = options.message || '';
      var type = options.type || 'info'; // 'success' | 'info' | 'warning' | 'error'
      var duration = typeof options.duration === 'number' ? options.duration : 3200;

      var parent = getContainer();

      // Enforce max toasts limit
      var existing = parent.querySelectorAll('.wiki-toast:not(.is-leaving)');
      if (existing.length >= MAX_VISIBLE_TOASTS) {
        dismiss(existing[0]);
      }

      var toast = document.createElement('div');
      toast.className = 'wiki-toast wiki-toast-' + type;
      toast.setAttribute('role', type === 'error' ? 'alert' : 'status');

      var iconHtml = TOAST_ICONS[type] || TOAST_ICONS.info;
      var closeHtml = TOAST_ICONS.close;

      toast.innerHTML =
        '<div class="wiki-toast-icon" aria-hidden="true">' + iconHtml + '</div>' +
        '<div class="wiki-toast-body">' +
          (title ? '<div class="wiki-toast-title">' + esc(title) + '</div>' : '') +
          (message ? '<div class="wiki-toast-message">' + esc(message) + '</div>' : '') +
        '</div>' +
        '<button type="button" class="wiki-toast-close" aria-label="' + esc(t.dismiss) + '">' +
          closeHtml +
        '</button>' +
        '<div class="wiki-toast-progress"><div class="wiki-toast-progress-bar"></div></div>';

      var closeBtn = toast.querySelector('.wiki-toast-close');
      if (closeBtn) {
        closeBtn.addEventListener('click', function (e) {
          e.stopPropagation();
          dismiss(toast);
        });
      }

      toast.addEventListener('click', function () {
        dismiss(toast);
      });

      // Progress bar animation & pause on hover/focus
      var progressBar = toast.querySelector('.wiki-toast-progress-bar');
      var startTime = Date.now();
      var remaining = duration;
      var isPaused = false;

      function startTimer() {
        if (duration <= 0) return;
        startTime = Date.now();
        if (progressBar) {
          progressBar.style.transition = 'transform ' + remaining + 'ms linear';
          progressBar.style.transform = 'scaleX(0)';
        }
        toast._timer = setTimeout(function () {
          dismiss(toast);
        }, remaining);
      }

      function pauseTimer() {
        if (duration <= 0 || isPaused) return;
        isPaused = true;
        clearTimeout(toast._timer);
        var elapsed = Date.now() - startTime;
        remaining = Math.max(0, remaining - elapsed);
        if (progressBar) {
          var currentScale = remaining / duration;
          progressBar.style.transition = 'none';
          progressBar.style.transform = 'scaleX(' + currentScale + ')';
        }
      }

      function resumeTimer() {
        if (duration <= 0 || !isPaused || remaining <= 0) return;
        isPaused = false;
        startTimer();
      }

      toast.addEventListener('mouseenter', pauseTimer);
      toast.addEventListener('mouseleave', resumeTimer);
      toast.addEventListener('focusin', pauseTimer);
      toast.addEventListener('focusout', resumeTimer);

      parent.appendChild(toast);

      // Trigger entrance transition
      requestAnimationFrame(function () {
        requestAnimationFrame(function () {
          toast.classList.add('is-visible');
          startTimer();
        });
      });

      return toast;
    }

    return {
      show: show,
      success: function (message, title, opts) {
        return show(Object.assign({ type: 'success', message: message, title: title }, opts || {}));
      },
      info: function (message, title, opts) {
        return show(Object.assign({ type: 'info', message: message, title: title }, opts || {}));
      },
      error: function (message, title, opts) {
        return show(Object.assign({ type: 'error', message: message, title: title || t.copyFailed, duration: 4200 }, opts || {}));
      },
      dismiss: dismiss
    };
  })();

  // Expose to window for external or inline handlers
  window.WikiToast = WikiToast;

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
    var terms = q.split(/\s+/).filter(Boolean);
    if (!terms.length) return [];

    var scored = [];
    for (var i = 0; i < searchIndex.length; i++) {
      var item = searchIndex[i];
      var title = (item.title || '').toLowerCase();
      var desc = (item.description || '').toLowerCase();
      var cat = (item.category || '').toLowerCase();
      var tags = (item.tags || []).join(' ').toLowerCase();
      var blob = title + ' ' + cat + ' ' + tags + ' ' + desc;

      // Multi-term matching: every search term must be present
      var allFound = true;
      for (var tIdx = 0; tIdx < terms.length; tIdx++) {
        if (blob.indexOf(terms[tIdx]) === -1) {
          allFound = false;
          break;
        }
      }
      if (!allFound) continue;

      // Relevance score calculation
      var score = 0;
      if (title === q) score += 100;
      else if (title.indexOf(q) === 0) score += 60;
      else if (title.indexOf(q) !== -1) score += 40;

      for (var sIdx = 0; sIdx < terms.length; sIdx++) {
        var term = terms[sIdx];
        if (title.indexOf(term) !== -1) score += 20;
        if (cat.indexOf(term) !== -1) score += 15;
        if (tags.indexOf(term) !== -1) score += 10;
        if (desc.indexOf(term) !== -1) score += 5;
      }

      scored.push({ item: item, score: score });
    }

    scored.sort(function (a, b) { return b.score - a.score; });
    return scored.slice(0, limit).map(function (entry) { return entry.item; });
  }

  /* ---------- Command Palette / Modal Search ---------- */
  var searchModal = document.getElementById('wiki-search-modal');
  var modalInput = searchModal ? searchModal.querySelector('[data-wiki-modal-input]') : null;
  var modalResults = searchModal ? searchModal.querySelector('[data-wiki-modal-results]') : null;
  var selectedModalIndex = -1;
  var lastFocusedTrigger = null;

  function openSearchModal(triggerEl) {
    if (!searchModal) return;
    lastFocusedTrigger = triggerEl || document.activeElement;
    searchModal.hidden = false;
    document.body.style.overflow = 'hidden';

    loadSearchIndex(function () {
      if (modalInput) {
        modalInput.focus();
        if (modalInput.value) {
          performModalSearch(modalInput.value);
        } else {
          renderModalResults([], '');
        }
      }
    });
  }

  function closeSearchModal() {
    if (!searchModal) return;
    searchModal.hidden = true;
    document.body.style.overflow = '';
    selectedModalIndex = -1;

    // Restore focus back to previous element
    if (lastFocusedTrigger && typeof lastFocusedTrigger.focus === 'function') {
      try {
        lastFocusedTrigger.focus();
      } catch (e) {}
    }
  }

  function renderModalResults(results, q) {
    if (!modalResults) return;
    selectedModalIndex = -1;
    if (modalInput) modalInput.removeAttribute('aria-activedescendant');

    if (!q) {
      modalResults.innerHTML = '<div class="wiki-modal-empty"><p class="wiki-modal-hint">' + esc(t.searchHint) + '</p></div>';
      return;
    }

    if (!results.length) {
      modalResults.innerHTML = '<div class="wiki-modal-empty"><p class="wiki-modal-hint">' + esc(t.noMatches) + '</p></div>';
      return;
    }

    modalResults.innerHTML = results.map(function (r, idx) {
      var optId = 'wiki-modal-opt-' + idx;
      var highlightedTitle = highlightMatch(r.title, q);
      var highlightedDesc = highlightMatch(r.description || '', q);
      var highlightedCat = highlightMatch(r.category || '', q);

      return '<a href="' + esc(r.url) + '" class="wiki-modal-item" id="' + optId + '" role="option" aria-selected="false" data-modal-idx="' + idx + '">'
        + '<div class="wiki-modal-item-ico" aria-hidden="true"><svg class="wiki-ico wiki-ico-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="8.5"/><path d="M3.5 12h17M12 3.5c3.2 3.6 3.2 13.4 0 17M12 3.5c-3.2 3.6-3.2 13.4 0 17"/></svg></div>'
        + '<div class="wiki-modal-item-info">'
        + '<span class="wiki-modal-item-title">' + highlightedTitle + '</span>'
        + '<span class="wiki-modal-item-meta">' + highlightedCat + '<span class="wiki-sep-dot"><svg class="wiki-ico wiki-ico-xs" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><circle cx="12" cy="12" r="3"/></svg></span>' + highlightedDesc + '</span>'
        + '</div>'
        + '<svg class="wiki-ico wiki-ico-xs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>'
        + '</a>';
    }).join('');
  }

  function performModalSearch(val) {
    var hits = queryIndex(val, 8);
    renderModalResults(hits, val.trim());
  }

  function updateModalSelection(items) {
    for (var i = 0; i < items.length; i++) {
      if (i === selectedModalIndex) {
        items[i].classList.add('is-selected');
        items[i].setAttribute('aria-selected', 'true');
        items[i].scrollIntoView({ block: 'nearest' });
        if (modalInput) modalInput.setAttribute('aria-activedescendant', items[i].id);
      } else {
        items[i].classList.remove('is-selected');
        items[i].setAttribute('aria-selected', 'false');
      }
    }
  }

  if (modalInput) {
    var modalDebounce = null;
    modalInput.addEventListener('input', function () {
      clearTimeout(modalDebounce);
      modalDebounce = setTimeout(function () {
        performModalSearch(modalInput.value);
      }, 90);
    });

    modalInput.addEventListener('keydown', function (e) {
      var items = modalResults ? modalResults.querySelectorAll('.wiki-modal-item') : [];

      if (e.key === 'ArrowDown') {
        if (!items.length) return;
        e.preventDefault();
        selectedModalIndex = (selectedModalIndex + 1) % items.length;
        updateModalSelection(items);
      } else if (e.key === 'ArrowUp') {
        if (!items.length) return;
        e.preventDefault();
        selectedModalIndex = (selectedModalIndex - 1 + items.length) % items.length;
        updateModalSelection(items);
      } else if (e.key === 'Enter') {
        if (items.length > 0) {
          e.preventDefault();
          var targetIndex = selectedModalIndex >= 0 ? selectedModalIndex : 0;
          if (items[targetIndex]) {
            window.location.href = items[targetIndex].getAttribute('href');
          }
        }
      }
    });
  }

  // Focus trap inside search modal
  if (searchModal) {
    searchModal.addEventListener('keydown', function (e) {
      if (e.key === 'Tab') {
        var focusables = searchModal.querySelectorAll('input, button, [href], [tabindex]:not([tabindex="-1"])');
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
    });
  }

  // Modal Open / Close Click Handlers
  document.addEventListener('click', function (e) {
    var trigger = e.target.closest('[data-wiki-search-trigger]');
    if (trigger) {
      e.preventDefault();
      openSearchModal(trigger);
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
      var activeEl = document.activeElement;
      var tag = activeEl ? activeEl.tagName.toLowerCase() : '';
      var isInput = tag === 'input' || tag === 'textarea' || (activeEl && activeEl.isContentEditable);
      if (!isInput) {
        e.preventDefault();
        openSearchModal();
        return;
      }
    }
    if (e.key === 'Escape') {
      if (searchModal && !searchModal.hidden) {
        e.preventDefault();
        closeSearchModal();
      } else if (drawer && !drawer.hidden) {
        e.preventDefault();
        closeDrawer();
      }
    }
  });

  /* ---------- Homepage Inline Search Dropdown ---------- */
  var homeInput = document.querySelector('[data-wiki-search-input]:not([data-wiki-modal-input])');
  var homeResults = document.querySelector('[data-wiki-search-results]:not([data-wiki-modal-results])');

  if (homeInput && homeResults) {
    var homeDebounce = null;
    homeInput.addEventListener('focus', function () {
      loadSearchIndex(function () {
        if (homeInput.value.trim()) {
          renderHomeResults(queryIndex(homeInput.value, 6), homeInput.value.trim());
        }
      });
    });

    homeInput.addEventListener('input', function () {
      clearTimeout(homeDebounce);
      homeDebounce = setTimeout(function () {
        loadSearchIndex(function () {
          renderHomeResults(queryIndex(homeInput.value, 6), homeInput.value.trim());
        });
      }, 100);
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
      homeResults.innerHTML = '<div style="padding: 0.85rem; text-align: center; color: var(--wiki-text-muted); font-size: 0.9rem;">'
        + esc(t.noMatches) + '</div>';
      return;
    }
    homeResults.innerHTML = results.map(function (r) {
      return '<a href="' + esc(r.url) + '">'
        + '<strong>' + highlightMatch(r.title, q) + '</strong>'
        + '<small>' + esc(r.category) + '<span class="wiki-sep-dot"><svg class="wiki-ico wiki-ico-xs" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><circle cx="12" cy="12" r="3"/></svg></span>' + highlightMatch(r.description || '', q) + '</small>'
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

  /* ---------- Enhanced Code Block Copy with Toasts ---------- */
  document.addEventListener('click', function (ev) {
    var btn = ev.target.closest ? ev.target.closest('.wiki-copy-btn') : null;
    if (!btn) return;

    var text = btn.getAttribute('data-copy') || '';
    if (!text) {
      var codeBlock = btn.closest('.wiki-codeblock');
      var codeEl = codeBlock ? codeBlock.querySelector('pre > code') : null;
      if (codeEl) text = codeEl.innerText || codeEl.textContent || '';
    }
    if (!text) return;

    var lang = (btn.getAttribute('data-lang') || 'code').toUpperCase();
    var lines = parseInt(btn.getAttribute('data-lines') || '0', 10);
    var labelEl = btn.querySelector('.wiki-copy-label');
    var origText = labelEl ? labelEl.textContent : '';

    copyText(
      text,
      function () {
        // Success
        btn.classList.add('is-copied');
        if (labelEl) labelEl.textContent = t.copied;

        setTimeout(function () {
          btn.classList.remove('is-copied');
          if (labelEl) labelEl.textContent = origText;
        }, 1800);

        var details = lang + ' ' + t.snippetCopied;
        if (lines > 0) {
          details += ' (' + lines + ' ' + (lines === 1 ? t.line : t.lines) + ')';
        }
        WikiToast.success(details, t.codeCopied);
      },
      function () {
        // Error
        WikiToast.error(t.copyFailed, t.copyFailed);
      }
    );
  });

  /* ---------- Code Block Word Wrap Toggle ---------- */
  document.addEventListener('click', function (ev) {
    var wrapBtn = ev.target.closest ? ev.target.closest('[data-wiki-toggle-wrap]') : null;
    if (!wrapBtn) return;

    var block = wrapBtn.closest('.wiki-codeblock');
    if (!block) return;

    var isWrapped = block.classList.toggle('is-wrapped');
    wrapBtn.classList.toggle('is-active', isWrapped);
    wrapBtn.setAttribute('aria-pressed', isWrapped ? 'true' : 'false');

    WikiToast.info(isWrapped ? t.wrapEnabled : t.wrapDisabled);
  });

  /* ---------- Copy Article Link Button with Toast ---------- */
  document.addEventListener('click', function (ev) {
    var btn = ev.target.closest ? ev.target.closest('[data-wiki-copy-link]') : null;
    if (!btn) return;

    var url = btn.getAttribute('data-url') || window.location.href;
    var label = btn.querySelector('.wiki-copy-link-label');
    var orig = label ? label.textContent : '';

    copyText(
      url,
      function () {
        btn.classList.add('is-copied');
        if (label) label.textContent = t.copied;
        setTimeout(function () {
          btn.classList.remove('is-copied');
          if (label) label.textContent = orig;
        }, 1800);
        WikiToast.success(url, t.linkCopied);
      },
      function () {
        WikiToast.error(t.copyFailed, t.copyFailed);
      }
    );
  });

  /* ---------- Heading Anchor Permalink Copy with Toast ---------- */
  document.addEventListener('click', function (ev) {
    var anchor = ev.target.closest ? ev.target.closest('.wiki-anchor') : null;
    if (!anchor) return;

    var href = anchor.getAttribute('href');
    if (!href || href.charAt(0) !== '#') return;

    var permalink = window.location.origin + window.location.pathname + href;
    copyText(
      permalink,
      function () {
        WikiToast.success(href, t.anchorCopied);
      },
      function () {
        // Fallback navigation
      }
    );
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

  /* ---------- Mobile TOC Auto-Close on Item Click ---------- */
  document.addEventListener('click', function (e) {
    var tocLink = e.target.closest ? e.target.closest('.wiki-mobile-toc-list a') : null;
    if (tocLink) {
      var details = tocLink.closest('details.wiki-mobile-toc');
      if (details) {
        details.open = false;
      }
    }
  });

  /* ---------- Table of Contents Scrollspy (IntersectionObserver) ---------- */
  var tocNav = document.querySelector('[data-wiki-toc-nav]');
  if (tocNav) {
    var tocLinks = Array.prototype.slice.call(tocNav.querySelectorAll('.wiki-toc-link'));
    var headingMap = [];

    for (var hIdx = 0; hIdx < tocLinks.length; hIdx++) {
      var targetId = tocLinks[hIdx].getAttribute('data-toc-target');
      var targetEl = document.getElementById(targetId);
      if (targetEl) {
        headingMap.push({ id: targetId, el: targetEl, link: tocLinks[hIdx] });
      }
    }

    if (headingMap.length > 0) {
      if ('IntersectionObserver' in window) {
        var activeId = headingMap[0].id;
        var observer = new IntersectionObserver(function (entries) {
          entries.forEach(function (entry) {
            if (entry.isIntersecting) {
              activeId = entry.target.id;
            }
          });

          headingMap.forEach(function (item) {
            if (item.id === activeId) {
              item.link.classList.add('is-active');
              item.link.setAttribute('aria-current', 'location');
              if (item.link.scrollIntoViewIfNeeded) {
                item.link.scrollIntoViewIfNeeded(false);
              }
            } else {
              item.link.classList.remove('is-active');
              item.link.removeAttribute('aria-current');
            }
          });
        }, {
          rootMargin: '-80px 0px -70% 0px',
          threshold: 0
        });

        headingMap.forEach(function (item) {
          observer.observe(item.el);
        });
      } else {
        // Fallback for older browsers
        window.addEventListener('scroll', function () {
          var scrollPos = (window.pageYOffset || document.documentElement.scrollTop || 0) + 100;
          var current = headingMap[0];
          for (var j = 0; j < headingMap.length; j++) {
            if (headingMap[j].el.offsetTop <= scrollPos) {
              current = headingMap[j];
            }
          }
          headingMap.forEach(function (k) {
            if (k === current) {
              k.link.classList.add('is-active');
            } else {
              k.link.classList.remove('is-active');
            }
          });
        }, { passive: true });
      }
    }
  }

  /* ---------- Mobile Navigation Drawer with Focus Trap ---------- */
  var drawer = document.getElementById('wiki-mobile-drawer');
  var drawerBackdrop = document.getElementById('wiki-mobile-drawer-backdrop');
  var drawerToggle = document.querySelector('[data-wiki-drawer-toggle]');
  var lastFocusedDrawerTrigger = null;

  function openDrawer() {
    if (!drawer) return;
    lastFocusedDrawerTrigger = document.activeElement;
    drawer.hidden = false;
    if (drawerBackdrop) drawerBackdrop.hidden = false;
    if (drawerToggle) drawerToggle.setAttribute('aria-expanded', 'true');

    setTimeout(function () {
      drawer.classList.add('is-open');
    }, 10);
    document.body.style.overflow = 'hidden';

    var firstFocusable = drawer.querySelector('button, [href], input');
    if (firstFocusable) firstFocusable.focus();
  }

  function closeDrawer() {
    if (!drawer) return;
    drawer.classList.remove('is-open');
    if (drawerToggle) drawerToggle.setAttribute('aria-expanded', 'false');

    setTimeout(function () {
      drawer.hidden = true;
      if (drawerBackdrop) drawerBackdrop.hidden = true;
      document.body.style.overflow = '';
      if (lastFocusedDrawerTrigger && typeof lastFocusedDrawerTrigger.focus === 'function') {
        try { lastFocusedDrawerTrigger.focus(); } catch (e) {}
      }
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

  if (drawer) {
    drawer.addEventListener('keydown', function (e) {
      if (e.key === 'Tab') {
        var focusables = drawer.querySelectorAll('button, [href], input, [tabindex]:not([tabindex="-1"])');
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
    });
  }

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
