/**
 * ternis.org — Modern Interactive Frontend Engine
 * Handles Theme Management, API Playground, Navigation & Interactivity
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
        if (!toggleBtn || !drawer) return;

        toggleBtn.addEventListener('click', () => {
            const isOpen = drawer.classList.toggle('open');
            toggleBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            if (isOpen) {
                toggleBtn.innerHTML = `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>`;
            } else {
                toggleBtn.innerHTML = `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>`;
            }
        });

        // Close on clicking link
        drawer.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                drawer.classList.remove('open');
                toggleBtn.setAttribute('aria-expanded', 'false');
                toggleBtn.innerHTML = `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>`;
            });
        });
    }

    // ── Interactive API Playground for getmy.name ──────────────────────────────
    const CODE_SNIPPETS = {
        curl: `curl -X GET "https://api.getmy.name/v1/profile/demo" \\
  -H "Accept: application/json" \\
  -H "User-Agent: ternis-org-app/1.0"`,

        js: `// Fetch profile from getmy.name API
const res = await fetch("https://api.getmy.name/v1/profile/demo", {
  headers: { "Accept": "application/json" }
});
const profile = await res.json();
console.log("Developer Profile:", profile.data);`,

        py: `import requests

# Query developer profile via getmy.name API
response = requests.get(
    "https://api.getmy.name/v1/profile/demo",
    headers={"Accept": "application/json"}
)
profile_data = response.json()
print("Developer:", profile_data["data"]["name"])`,

        php: `<?php
// Query getmy.name API in PHP
$json = file_get_contents('https://api.getmy.name/v1/profile/demo');
$profile = json_decode($json, true);

echo "Developer Name: " . htmlspecialchars($profile['data']['name']);
`
    };

    const SAMPLE_RESPONSES = {
        demo: {
            "status": "success",
            "meta": {
                "api": "getmy.name",
                "version": "v1.4.0",
                "cluster": "eu-central-nbg",
                "execution_time_ms": 28.4
            },
            "data": {
                "username": "fabianternis",
                "name": "Fabian Ternis",
                "headline": "Lead Systems Architect & Full-Stack Engineer",
                "location": "Germany, European Union",
                "bio": "Building sovereign, privacy-centric developer tools and open-source infrastructure under ternis.org & MTEX.dev.",
                "organization": "ternis-edv.de / ternis.dev",
                "skills": [
                    "PHP 8.3 / Laravel",
                    "TypeScript / React / Vue",
                    "Go & Cloud Infrastructure",
                    "REST & Headless APIs",
                    "Docker & Bare-Metal Linux"
                ],
                "projects": [
                    { "name": "getmy.name", "type": "Headless Portfolio API", "status": "active" },
                    { "name": "MTEX.dev", "type": "Developer Tools Suite", "status": "active" },
                    { "name": "mail-free.eu", "type": "Sovereign EU Mail Relay", "status": "in_dev" },
                    { "name": "static.re", "type": "Edge Static Delivery", "status": "in_dev" }
                ],
                "contact": {
                    "website": "https://ternis.dev",
                    "studio": "https://ternis-edv.de",
                    "github": "https://github.com/ternis-org",
                    "email": "contact@ternis.dev"
                }
            }
        }
    };

    function initPlayground() {
        const codeDisplay = document.getElementById('playground-code');
        const jsonDisplay = document.getElementById('playground-json');
        const runBtn = document.getElementById('btn-run-api');
        const copyBtn = document.getElementById('btn-copy-code');
        const latencyEl = document.getElementById('api-latency-val');
        const tabBtns = document.querySelectorAll('.tab-btn');

        if (!codeDisplay || !jsonDisplay) return;

        let activeTab = 'curl';

        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                tabBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                activeTab = btn.getAttribute('data-lang') || 'curl';
                codeDisplay.textContent = CODE_SNIPPETS[activeTab] || CODE_SNIPPETS.curl;
            });
        });

        // Set initial code snippet
        codeDisplay.textContent = CODE_SNIPPETS.curl;

        // Copy Code Button
        if (copyBtn) {
            copyBtn.addEventListener('click', async () => {
                const textToCopy = CODE_SNIPPETS[activeTab] || CODE_SNIPPETS.curl;
                try {
                    await navigator.clipboard.writeText(textToCopy);
                    const originalText = copyBtn.innerHTML;
                    copyBtn.innerHTML = `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> <span>Copied!</span>`;
                    copyBtn.classList.add('btn-copied');
                    setTimeout(() => {
                        copyBtn.innerHTML = originalText;
                        copyBtn.classList.remove('btn-copied');
                    }, 2200);
                } catch (e) {
                    console.error('Clipboard copy failed:', e);
                }
            });
        }

        // Run API Request Button
        if (runBtn) {
            runBtn.addEventListener('click', async () => {
                runBtn.disabled = true;
                const originalHtml = runBtn.innerHTML;
                runBtn.innerHTML = `<svg class="animate-spin" fill="none" viewBox="0 0 24 24" style="width:16px;height:16px;animation:spin 1s linear infinite;"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" style="opacity:0.25"></circle><path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" style="opacity:0.75"></path></svg> <span>Executing...</span>`;

                const startTime = performance.now();

                try {
                    // Try real live fetch with a short fallback timeout
                    const controller = new AbortController();
                    const timeoutId = setTimeout(() => controller.abort(), 1200);

                    const res = await fetch('https://api.getmy.name/v1/profile/demo', {
                        signal: controller.signal,
                        headers: { 'Accept': 'application/json' }
                    }).catch(() => null);

                    clearTimeout(timeoutId);

                    let data = null;
                    if (res && res.ok) {
                        data = await res.json();
                    }

                    if (!data) {
                        // Fallback to rich sample response
                        data = SAMPLE_RESPONSES.demo;
                    }

                    const elapsed = Math.round(performance.now() - startTime);
                    if (latencyEl) {
                        latencyEl.textContent = `${elapsed}ms`;
                    }

                    jsonDisplay.textContent = JSON.stringify(data, null, 2);
                    jsonDisplay.classList.add('highlight-pulse');
                    setTimeout(() => jsonDisplay.classList.remove('highlight-pulse'), 600);
                } catch (err) {
                    jsonDisplay.textContent = JSON.stringify(SAMPLE_RESPONSES.demo, null, 2);
                } finally {
                    runBtn.disabled = false;
                    runBtn.innerHTML = originalHtml;
                }
            });
        }
    }

    // ── FAQ Accordion ──────────────────────────────────────────────────────────
    function initFAQ() {
        const faqItems = document.querySelectorAll('.faq-item');
        faqItems.forEach(item => {
            const questionBtn = item.querySelector('.faq-question');
            if (!questionBtn) return;

            questionBtn.addEventListener('click', () => {
                const isActive = item.classList.contains('active');
                faqItems.forEach(i => i.classList.remove('active'));
                if (!isActive) {
                    item.classList.add('active');
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

    // ── Bootstrap on DOM Ready ─────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', () => {
        initTheme();
        initMobileNav();
        initPlayground();
        initFAQ();
        initScrollSpy();
        initScrollToTop();
        initServiceWorker();

        // Bind theme toggle buttons
        document.querySelectorAll('.btn-theme-toggle').forEach(btn => {
            btn.addEventListener('click', toggleTheme);
        });
    });
})();
