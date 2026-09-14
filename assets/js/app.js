/**
 * ternis.org — Client-Side Application Script
 * Handles Theme Management, Navigation, Scroll Animations & Interactivity
 * Zero external JS dependencies. Pure Vanilla ES6+.
 */

(function () {
    'use strict';

    // ── Theme Switcher ─────────────────────────────────────────────────────────
    const THEME_KEY = 'ternis_theme';
    const htmlEl = document.documentElement;

    function initTheme() {
        const storedTheme = localStorage.getItem(THEME_KEY);
        if (storedTheme) {
            htmlEl.setAttribute('data-theme', storedTheme);
            updateThemeIcons(storedTheme);
        } else {
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const defaultTheme = prefersDark ? 'dark' : 'light';
            htmlEl.setAttribute('data-theme', defaultTheme);
            updateThemeIcons(defaultTheme);
        }
    }

    function toggleTheme() {
        const currentTheme = htmlEl.getAttribute('data-theme') || 'dark';
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        htmlEl.setAttribute('data-theme', newTheme);
        localStorage.setItem(THEME_KEY, newTheme);
        updateThemeIcons(newTheme);
    }

    function updateThemeIcons(theme) {
        const themeBtns = document.querySelectorAll('.btn-theme-toggle');
        themeBtns.forEach(btn => {
            if (theme === 'dark') {
                btn.innerHTML = `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>`;
                btn.setAttribute('aria-label', 'Switch to light mode');
            } else {
                btn.innerHTML = `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>`;
                btn.setAttribute('aria-label', 'Switch to dark mode');
            }
        });
    }

    // ── Mobile Navigation Drawer ───────────────────────────────────────────────
    function initMobileNav() {
        const toggleBtn = document.querySelector('.mobile-toggle');
        const drawer = document.querySelector('.mobile-drawer');
        const backdrop = document.querySelector('#mobile-drawer-backdrop');
        if (!toggleBtn || !drawer) return;

        function openDrawer() {
            drawer.classList.add('open');
            if (backdrop) backdrop.classList.add('open');
            document.body.classList.add('drawer-open');
            toggleBtn.setAttribute('aria-expanded', 'true');
            toggleBtn.innerHTML = `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>`;
        }

        function closeDrawer() {
            drawer.classList.remove('open');
            if (backdrop) backdrop.classList.remove('open');
            document.body.classList.remove('drawer-open');
            toggleBtn.setAttribute('aria-expanded', 'false');
            toggleBtn.innerHTML = `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>`;
        }

        toggleBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            if (drawer.classList.contains('open')) {
                closeDrawer();
            } else {
                openDrawer();
            }
        });

        if (backdrop) {
            backdrop.addEventListener('click', closeDrawer);
        }

        // Close on clicking link inside drawer
        drawer.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', closeDrawer);
        });

        // Close on Escape key press
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && drawer.classList.contains('open')) {
                closeDrawer();
            }
        });

        // Close when resizing above mobile breakpoint
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768 && drawer.classList.contains('open')) {
                closeDrawer();
            }
        }, { passive: true });
    }

    // ── FAQ Accordion ──────────────────────────────────────────────────────────
    function initFAQ() {
        const faqItems = document.querySelectorAll('.faq-item');
        faqItems.forEach(item => {
            const questionBtn = item.querySelector('.faq-question');
            if (!questionBtn) return;

            questionBtn.addEventListener('click', () => {
                const isActive = item.classList.contains('active');
                faqItems.forEach(i => {
                    i.classList.remove('active');
                    const btn = i.querySelector('.faq-question');
                    if (btn) btn.setAttribute('aria-expanded', 'false');
                });

                if (!isActive) {
                    item.classList.add('active');
                    questionBtn.setAttribute('aria-expanded', 'true');
                }
            });
        });
    }

    // ── Smooth Scroll & Active Nav Spy ─────────────────────────────────────────
    function initScrollSpy() {
        const targets = document.querySelectorAll('section[id], footer[id]');
        const navLinks = document.querySelectorAll('.nav-links a, .mobile-drawer a');

        if (!targets.length || !navLinks.length) return;

        function updateActiveNav() {
            let current = '';
            const scrollPos = (window.pageYOffset || document.documentElement.scrollTop) + 160;

            targets.forEach(target => {
                const top = target.offsetTop;
                const height = target.offsetHeight;
                if (scrollPos >= top && scrollPos < top + height) {
                    current = target.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                const href = link.getAttribute('href') || '';
                const hashIndex = href.indexOf('#');
                if (hashIndex !== -1) {
                    const targetId = href.substring(hashIndex + 1);
                    if (targetId && targetId === current) {
                        link.classList.add('active');
                    } else {
                        link.classList.remove('active');
                    }
                }
            });
        }

        window.addEventListener('scroll', updateActiveNav, { passive: true });
        window.addEventListener('resize', updateActiveNav, { passive: true });
        updateActiveNav();
    }

    // ── Scroll To Top with Dynamic Circular Border Progress ───────────────────
    function initScrollToTop() {
        const btn = document.getElementById('scroll-to-top');
        const progressCircle = document.querySelector('.progress-ring-circle');
        if (!btn || !progressCircle) return;

        const radius = progressCircle.r.baseVal.value || 20;
        const circumference = 2 * Math.PI * radius; // approx 125.66
        progressCircle.style.strokeDasharray = `${circumference} ${circumference}`;
        progressCircle.style.strokeDashoffset = `${circumference}`;

        function updateProgress() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrollPercent = docHeight > 0 ? Math.min(1, Math.max(0, scrollTop / docHeight)) : 0;

            const offset = circumference - (scrollPercent * circumference);
            progressCircle.style.strokeDashoffset = `${offset}`;

            if (scrollTop > 180) {
                btn.classList.add('visible');
            } else {
                btn.classList.remove('visible');
            }
        }

        window.addEventListener('scroll', updateProgress, { passive: true });
        window.addEventListener('resize', updateProgress, { passive: true });
        updateProgress();

        btn.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // ── Service Worker Registration ────────────────────────────────────────────
    function initServiceWorker() {
        if ('serviceWorker' in navigator && window.location.protocol === 'https:') {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').catch(err => {
                    console.debug('ServiceWorker registration error:', err);
                });
            });
        }
    }

    // ── Scroll Motion & Animations Engine ──────────────────────────────────────
    function initScrollAnimations() {
        // Mark document as animation-ready
        document.documentElement.classList.add('has-scroll-anim');

        const progressBar = document.getElementById('scroll-progress');
        const progressFill = progressBar ? (progressBar.querySelector('.scroll-progress-fill') || progressBar) : null;
        const progressHead = progressBar ? progressBar.querySelector('.scroll-progress-head') : null;
        const navContainer = document.querySelector('.nav-container-fixed');
        const heroContainer = document.querySelector('#hero .container');

        // High-performance scroll tracking via requestAnimationFrame
        let ticking = false;
        function onScrollTick() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const progress = docHeight > 0 ? Math.min(1, Math.max(0, scrollTop / docHeight)) : 0;

            if (progressBar) {
                if (scrollTop > 12) {
                    progressBar.classList.add('is-active');
                } else {
                    progressBar.classList.remove('is-active');
                }

                if (progressFill) {
                    progressFill.style.transform = `scaleX(${progress})`;
                }
                if (progressHead) {
                    progressHead.style.left = `${(progress * 100).toFixed(2)}%`;
                }
            }

            if (navContainer) {
                if (scrollTop > 40) {
                    navContainer.classList.add('is-scrolled');
                } else {
                    navContainer.classList.remove('is-scrolled');
                }
            }

            // Subtle Hero Parallax & Depth on Desktop
            if (heroContainer && scrollTop < 600 && window.innerWidth > 768) {
                const yOffset = scrollTop * 0.16;
                const opacity = Math.max(0.1, 1 - (scrollTop / 500));
                heroContainer.style.transform = `translate3d(0, ${yOffset}px, 0)`;
                heroContainer.style.opacity = opacity.toFixed(2);
            } else if (heroContainer && scrollTop === 0) {
                heroContainer.style.transform = 'translate3d(0, 0, 0)';
                heroContainer.style.opacity = '1';
            }

            ticking = false;
        }

        window.addEventListener('scroll', () => {
            if (!ticking) {
                window.requestAnimationFrame(onScrollTick);
                ticking = true;
            }
        }, { passive: true });

        // Run once on load
        onScrollTick();

        // Reversible Scroll-Driven Reveal Observer
        if ('IntersectionObserver' in window) {
            const observerOptions = {
                root: null,
                rootMargin: '0px 0px -35px 0px',
                threshold: 0.1
            };

            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    const target = entry.target;
                    if (entry.isIntersecting) {
                        target.classList.add('is-revealed');

                        // Stagger children if present
                        if (target.classList.contains('stagger-children')) {
                            const children = Array.from(target.children);
                            children.forEach((child, idx) => {
                                child.style.transitionDelay = `${(idx + 1) * 0.08}s`;
                                child.classList.add('is-revealed');
                                // Once entrance completes, clear inline delay so hover is immediate
                                setTimeout(() => {
                                    child.style.transitionDelay = '';
                                    child.classList.add('is-settled');
                                }, 900);
                            });
                        } else {
                            setTimeout(() => {
                                target.classList.add('is-settled');
                            }, 900);
                        }
                    } else {
                        // Reverse transformation when scrolling up (element is below viewport)
                        if (entry.boundingClientRect.top > 0) {
                            target.classList.remove('is-revealed', 'is-settled');

                            if (target.classList.contains('stagger-children')) {
                                const children = Array.from(target.children);
                                children.forEach(child => {
                                    child.style.transitionDelay = '';
                                    child.classList.remove('is-revealed', 'is-settled');
                                });
                            }
                        }
                    }
                });
            }, observerOptions);

            const animTargets = document.querySelectorAll(
                '.scroll-reveal, .stagger-children, .project-card, .pillar-card, .ns-card'
            );
            animTargets.forEach(el => revealObserver.observe(el));
        } else {
            // Fallback for older browsers
            document.querySelectorAll(
                '.scroll-reveal, .stagger-children, .project-card, .pillar-card, .ns-card'
            ).forEach(el => {
                el.classList.add('is-revealed');
            });
        }
    }

    // ── Toast Notification System ─────────────────────────────────────────────
    let toastTimer = null;
    function showToast(message) {
        let toast = document.querySelector('.ui-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.className = 'ui-toast';
            toast.setAttribute('role', 'status');
            toast.setAttribute('aria-live', 'polite');
            toast.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg><span class="ui-toast-msg"></span>`;
            document.body.appendChild(toast);
        }

        const msgEl = toast.querySelector('.ui-toast-msg');
        if (msgEl) msgEl.textContent = message;
        toast.classList.add('visible');

        if (toastTimer) clearTimeout(toastTimer);
        toastTimer = setTimeout(() => {
            toast.classList.remove('visible');
        }, 2400);
    }

    // ── Copy to Clipboard with Visual & Toast Feedback ────────────────────────
    function initCopyButtons() {
        const copyBtns = document.querySelectorAll('[data-copy]');
        copyBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                e.preventDefault();

                const textToCopy = btn.getAttribute('data-copy');
                if (!textToCopy) return;

                const isDe = document.documentElement.lang === 'de';
                const toastMsg = btn.getAttribute('data-toast') || (isDe ? 'In die Zwischenablage kopiert!' : 'Copied to clipboard!');

                function onCopySuccess() {
                    btn.classList.add('copied');
                    const copyText = btn.querySelector('.copy-text');
                    const originalText = copyText ? copyText.textContent : null;

                    if (copyText) {
                        copyText.textContent = isDe ? 'Kopiert!' : 'Copied!';
                    }

                    showToast(toastMsg);

                    setTimeout(() => {
                        btn.classList.remove('copied');
                        if (copyText && originalText !== null) {
                            copyText.textContent = originalText;
                        }
                    }, 2000);
                }

                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(textToCopy).then(onCopySuccess).catch(() => {
                        fallbackCopy(textToCopy, onCopySuccess);
                    });
                } else {
                    fallbackCopy(textToCopy, onCopySuccess);
                }
            });
        });

        function fallbackCopy(text, callback) {
            try {
                const tempInput = document.createElement('textarea');
                tempInput.value = text;
                tempInput.style.position = 'fixed';
                tempInput.style.opacity = '0';
                document.body.appendChild(tempInput);
                tempInput.focus();
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);
                if (callback) callback();
            } catch (err) {
                console.debug('Copy fallback error:', err);
            }
        }
    }

    // ── Full-Card Click for Project Cards ─────────────────────────────────────
    function initProjectCards() {
        const cards = document.querySelectorAll('.project-card[data-href]');
        cards.forEach(card => {
            card.addEventListener('click', (e) => {
                // If clicked directly on a link or button, let it handle its own navigation
                if (e.target.closest('a, button')) return;

                const href = card.getAttribute('data-href');
                if (href) {
                    window.open(href, '_blank', 'noopener,noreferrer');
                }
            });
        });
    }

    // ── Bootstrap on DOM Ready ─────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', () => {
        initTheme();
        initMobileNav();
        initFAQ();
        initScrollSpy();
        initScrollToTop();
        initScrollAnimations();
        initCopyButtons();
        initProjectCards();
        initServiceWorker();

        // Bind theme toggle buttons
        document.querySelectorAll('.btn-theme-toggle').forEach(btn => {
            btn.addEventListener('click', toggleTheme);
        });
    });
})();
