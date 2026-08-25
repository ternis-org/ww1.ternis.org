# ternis.org — Modern Open-Source Developer Ecosystem

<p align="center">
  <img src="public/favicon.svg" width="96" height="96" alt="ternis.org Logo" />
</p>

<p align="center">
  <strong>Empowering Developers with Open, Sovereign & Fast Digital Infrastructure.</strong><br>
  Maintained by <a href="https://ternis.dev">ternis.dev</a> &amp; backed by <a href="https://ternis-edv.de">ternis-edv.de</a>
</p>

<p align="center">
  <a href="https://github.com/ternis-org/ww1.ternis.org/blob/master/LICENSE"><img src="https://img.shields.io/badge/License-MIT-blue.svg?style=flat-square" alt="MIT License"></a>
  <a href="https://php.net"><img src="https://img.shields.io/badge/PHP-%E2%89%A5%208.1-777BB4.svg?style=flat-square&logo=php&logoColor=white" alt="PHP Version"></a>
  <a href="https://ternis.org/sitemap.xml"><img src="https://img.shields.io/badge/Sitemap-XML-06B6D4.svg?style=flat-square" alt="Sitemap"></a>
  <a href="https://ternis.org/api/ver"><img src="https://img.shields.io/badge/API-v1.0-10B981.svg?style=flat-square" alt="Version"></a>
  <a href="https://ternis.org"><img src="https://img.shields.io/badge/Privacy-0%25%20Trackers-purple.svg?style=flat-square" alt="Zero Trackers"></a>
</p>

---

## 🌐 Overview

**ternis.org** is the official open-source organization and digital sovereignty hub operated by **[ternis.dev](https://ternis.dev)** (the engineering portal of Fabian Ternis) and supported by **[ternis-edv.de](https://ternis-edv.de)** (a German web engineering and digital solutions studio).

ternis.org is dedicated to stewarding and scaling open-source developer tooling by **[MTEX.dev](https://mtex.dev)**, sovereign European communications platforms, and edge-first web infrastructure.

### Core Values
- 🛡️ **100% Free & Open Source (FOSS):** Everything we build is open for inspection, contribution, and self-hosting under permissive licenses.
- 🇪🇺 **European Digital Sovereignty:** Strictly zero non-consensual telemetry, zero advertising trackers, and 100% GDPR-compliant infrastructure hosted on European soil.
- ⚡ **Developer Ergonomics:** Sub-50ms response times, predictable REST APIs, minimal runtime dependencies, and instant copy-paste developer tooling.

---

## 📦 Maintained Projects & Initiatives

```
                      ┌────────────────────────────────────────┐
                      │             FABIAN TERNIS              │
                      │         (Founder & Lead Eng)           │
                      └───────────────────┬────────────────────┘
                                          │
        ┌─────────────────────────────────┼─────────────────────────────────┐
        │                                 │                                 │
        ▼                                 ▼                                 ▼
┌──────────────────┐            ┌──────────────────┐            ┌──────────────────┐
│  ternis-edv.de   │            │    ternis.dev    │            │    ternis.org    │
│ (Commercial &    │            │ (Personal Hub &  │            │  (Open-Source &  │
│  Agency Studio)  │            │  Tech Portfolio) │            │  Community Fdn)  │
└──────────────────┘            └──────────────────┘            └─────────┬────────┘
                                                                          │
                        ┌─────────────────────────────────────────────────┴────────────────────────┐
                        │                                                                          │
                        ▼                                                                          ▼
            ┌───────────────────────┐                                                  ┌───────────────────────┐
            │   MTEX.dev Project    │                                                  │ Sovereign Infra & Web │
            │  (Developer Tooling)  │                                                  │     (Cloud & Mail)    │
            ├───────────────────────┤                                                  ├───────────────────────┤
            │ • getmy.name (API)    │                                                  │ • mail-free.eu / .uk  │
            │ • API Sandbox Tools   │                                                  │ • static.re Pipeline  │
            │ • Tailwind Components │                                                  │ • EU Privacy Services │
            └───────────────────────┘                                                  └───────────────────────┘
```

### 1. [getmy.name](https://getmy.name) — Free Headless Portfolio API
- **Status:** `Live & Production`
- **License:** MIT
- **Summary:** Eliminates the need to maintain static JSON files or complicated backends for personal websites. Exposes a clean, headless REST API delivering your bio, skills, project catalogue, and contact details with sub-40ms response times.
- **Repository:** [`ternis-org/getmy-name`](https://github.com/ternis-org/getmy-name)

### 2. [MTEX.dev](https://mtex.dev) — Developer-First Tooling Suite
- **Status:** `Live & Production`
- **License:** MIT
- **Summary:** Lightweight UI components, Tailwind CSS design patterns, HTTP sandboxes, and developer utility microservices.
- **Repository:** [`ternis-org/mtex-dev`](https://github.com/ternis-org/mtex-dev)

### 3. [mail-free.eu](https://mail-free.eu) / [mail-free.uk](https://mail-free.uk) — Privacy-First Sovereign Email
- **Status:** `In Active Development`
- **License:** AGPL-3.0
- **Summary:** Privacy-focused European email relay, disposable developer test inboxes, and secure mailbox services free from big-tech scanning and advertising profiling.
- **Repository:** [`ternis-org/mail-free`](https://github.com/ternis-org/mail-free)

### 4. [static.re](https://static.re) — Edge Static Delivery & Micro-CDN
- **Status:** `In Development / Beta`
- **License:** MIT
- **Summary:** Incremental static regeneration (ISR) and ultra-low latency static asset CDN with developer shortlinks and global caching.
- **Repository:** [`ternis-org/static-re`](https://github.com/ternis-org/static-re)

---

## 🛠️ Architecture & Features

This website is designed for maximum speed, security, and developer ergonomics:

- 🚀 **Zero Heavy Frameworks:** Ultra-fast custom PHP micro-router with sub-millisecond execution overhead.
- 🌍 **Full Bilingual i18n:** Built-in English (`/en`) and German (`/de`) language matrices with automatic browser `Accept-Language` detection.
- 🎨 **Luminous Modern Design System:**
  - Dark Theme (Obsidian & Electric Cyan/Emerald accents) + Light Theme toggle.
  - Frosted glassmorphic cards (`backdrop-filter: blur(16px)`).
  - Fluid typography and responsive layout across mobile, tablet, and desktop.
- ⚡ **Interactive API Playground:** Real-time test console for `getmy.name` with code generation for cURL, JavaScript (Fetch), Python (Requests), and PHP.
- 🔒 **Security & Privacy by Default:**
  - Strict Content Security Headers (`X-Content-Type-Options`, `X-Frame-Options`, `Referrer-Policy`).
  - Traversal-protected static file delivery engine.
  - Zero cookies, zero tracking scripts, zero third-party analytics.
- 📲 **Progressive Web App (PWA):** Service Worker (`/sw.js`) with stale-while-revalidate caching.
- 🤖 **Developer & Crawler Endpoints:**
  - `/api/ver` — JSON & Plaintext version hash endpoint.
  - `/sitemap.xml` — Dynamic XML sitemap with multi-language hreflang alternates.
  - `/robots.txt` — Search engine directive.

---

## 📁 Repository Structure

```
ww1.ternis.org/
├── assets/                  # Symlinked / Static assets (CSS, JS)
│   ├── css/
│   │   └── app.css          # Design system & theme engine
│   └── js/
│       └── app.js           # Interactive engine & playground
├── bootstrap.php            # Core application bootstrap & route definitions
├── index.html               # Standalone client-side static edition
├── index.php                # Root front-controller delegate
├── lang/                    # Localization dictionaries
│   ├── de.php               # German translations
│   └── en.php               # English translations
├── public/                  # Document root
│   ├── .htaccess            # Apache/LiteSpeed rewrite rules
│   ├── favicon.ico          # Favicon
│   ├── favicon.svg          # Vector icon
│   ├── index.php            # Primary HTTP entry point
│   ├── manifest.json        # Web app manifest
│   └── sw.js                # Service Worker
├── src/                     # Core PHP backend
│   ├── helpers.php          # Global helpers (e, t, render, asset_url)
│   ├── router.php           # Lightweight URL router
│   └── views/               # View templates
│       ├── error.php        # 404 / 500 error page
│       ├── index.php        # Main homepage view
│       ├── legal.php        # Impressum, Privacy & License view
│       └── sitemap.php      # Dynamic XML sitemap
├── static/
│   └── robots.txt           # Robots exclusion standard
└── README.md                # Project documentation
```

---

## 🚀 Quick Start & Local Development

### Prerequisites
- **PHP 8.1+** (PHP 8.2 or 8.3 recommended)
- **Git**

### Running the Development Server

1. **Clone the repository:**
   ```bash
   git clone https://github.com/ternis-org/ww1.ternis.org.git
   cd ww1.ternis.org
   ```

2. **Start the PHP built-in web server:**
   ```bash
   php -S 127.0.0.1:8000 public/index.php
   ```

3. **Open in your browser:**
   ```
   http://127.0.0.1:8000
   ```
   The application will automatically detect your browser's preferred language and redirect to `/en` or `/de`.

---

## 🐳 Docker Deployment

You can run the application with Docker and Docker Compose:

```yaml
version: '3.8'
services:
  ternis-web:
    image: php:8.3-apache
    container_name: ternis_org
    restart: unless-stopped
    ports:
      - "8080:80"
    volumes:
      - .:/var/www/html
    environment:
      - APACHE_DOCUMENT_ROOT=/var/www/html/public
```

---

## 🤝 Contributing

Contributions to `ternis.org` and any of our maintained ecosystem projects are warmly welcome!

1. Fork the repository on GitHub.
2. Create your feature branch (`git checkout -b feature/amazing-feature`).
3. Commit your changes (`git commit -m 'feat: add amazing feature'`).
4. Push to the branch (`git push origin feature/amazing-feature`).
5. Open a Pull Request.

---

## ⚖️ License & Credits

- **Software License:** Distributed under the permissive **[MIT License](LICENSE)**.
- **Maintained By:** **[Fabian Ternis](https://ternis.dev)** ([ternis-edv.de](https://ternis-edv.de))
- **Ecosystem:** [ternis.org](https://ternis.org) • [mtex.dev](https://mtex.dev) • [getmy.name](https://getmy.name) • [mail-free.eu](https://mail-free.eu) • [static.re](https://static.re)
