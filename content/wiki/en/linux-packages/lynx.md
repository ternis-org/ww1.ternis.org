---
title: Lynx — Text-Based Web Browser for Terminal & SEO Inspection
description: Complete beginner guide to Lynx, browsing the web in pure text, inspecting HTML semantics, SEO crawler audits, and dump CLI flag breakdowns.
category: linux-packages
order: 80
tags: [lynx, browser, terminal, seo, linux, accessibility, sysadmin]
updated: 2026-10-06
related: [linux-packages/curl, dns/debugging-dig-host-nslookup, css/layout-grid-flexbox]
---

## What is Lynx?

**Lynx** is the oldest web browser still in active development, originally created at the University of Kansas in 1992.

It runs completely inside a terminal without rendering CSS stylesheets, images, or client-side JavaScript. While this might seem primitive, it makes Lynx an invaluable secret weapon for developers, sysadmins, and SEO engineers:
1. **The "Search Engine Crawler" View**: Search engine spiders (like Googlebot) read the semantic structure of your HTML. Lynx shows you exactly what a crawler sees—unobscured by fancy CSS or JavaScript hydration.
2. **Accessibility Audits**: Simulates how blind or visually impaired users experience your site using screen readers.
3. **Headless Server Browsing**: Read documentation, download files, or verify local web applications directly from a remote VPS terminal without a desktop environment.

---

## Installation

```bash
# Ubuntu / Debian
sudo apt update
sudo apt install -y lynx

# Fedora / RHEL
sudo dnf install -y lynx

# Arch Linux
sudo pacman -S lynx
```

---

## 1. Interactive Browsing: Essential Keyboard Shortcuts

Launch Lynx by passing a URL:

```bash
lynx https://ternis.org
```

### Navigation Shortcuts

| Key | Action |
|:---:|--------|
| **`Up` / `Down` Arrow** | Jump to previous / next hyperlink on the page |
| **`Right Arrow`** or **`Enter`** | Follow and open the highlighted link |
| **`Left Arrow`** | Navigate back to previous page in history |
| **`Space`** / **`b`** | Scroll down / up one full page screen |
| **`g`** (Go) | Enter a new URL address to navigate to |
| **`\`** (Backslash) | Toggle view of the raw HTML source code |
| **`h`** | Open help manual |
| **`q`** | Quit Lynx (press `y` to confirm) |

---

## 2. Non-Interactive CLI Modes: Dumping for SEO Audits

You do not have to open the interactive browser interface to use Lynx. Its command-line dump flags make it an incredible automated analysis tool:

```bash
# 1. Render web page text cleanly to terminal stdout
lynx -dump https://ternis.org/en/wiki

# 2. Extract and list all hyperlinks found on the page
lynx -dump -listonly https://ternis.org/en/wiki

# 3. Inspect raw HTTP response headers
lynx -head https://ternis.org
```

### CLI Flag breakdown

- `-dump`: Fetches the URL, renders formatting, headings, and links into plain text, and prints the result straight to standard output (`stdout`) without launching the interactive UI.
- `-listonly`: When combined with `-dump`, prints only the numbered reference list of all hyperlinked URLs found on the page. Ideal for detecting broken outbound links and sitemap auditing!
- `-head`: Sends an `HTTP HEAD` request and displays the server's raw response headers.
- `-mime_header`: Outputs the full HTTP headers followed immediately by the rendered text body.

---

## Testing SEO & Semantic Headings

Run:

```bash
lynx -dump https://yourdomain.com | head -n 30
```

If your primary page title (`H1`), navigation links, and key introductory content are immediately visible and readable at the top of the dump, search engine crawlers will index your content effortlessly. If the dump shows blank space or *"Loading..."*, your site relies excessively on client-side JavaScript, hindering SEO discovery.
