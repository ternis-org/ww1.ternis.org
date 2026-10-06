---
title: Lynx — Text-Based Web Browser for Terminal & SEO Inspection
description: Browse the web directly in your Linux terminal with Lynx to inspect pure HTML semantics, check robots.txt, and verify accessibility.
category: linux-packages
order: 80
tags: [lynx, browser, terminal, seo, linux, accessibility]
updated: 2026-10-06
related: [linux-packages/curl, dns/debugging-dig-host-nslookup]
---

## What is Lynx?

Lynx is the oldest continuously maintained web browser in existence. It runs completely inside text terminals without rendering graphics, CSS styling, or client-side JavaScript. This makes it an ideal developer tool for testing how search engine crawlers (like Googlebot) read your page content, headings, and semantic HTML links.

## Installation

```bash
# Ubuntu / Debian
sudo apt update
sudo apt install -y lynx

# Fedora
sudo dnf install -y lynx

# Arch Linux
sudo pacman -S lynx
```

## Everyday Usage

Open any URL directly:

```bash
lynx https://ternis.org
```

### Essential Keyboard Shortcuts

| Key | Action |
| --- | --- |
| `Up` / `Down` | Move to previous / next link |
| `Right` or `Enter` | Follow the highlighted link |
| `Left` | Go back to previous page in history |
| `g` | Go to a new URL |
| `\` | View raw HTML source code of the current page |
| `q` | Quit Lynx (press `y` to confirm) |

## Dump Webpage as Plain Text for SEO Analysis

You can dump rendered webpage text directly to stdout without entering interactive mode:

```bash
lynx -dump https://ternis.org/en/wiki
```

This lets you instantly verify whether your title, headings, and internal links are accessible to text-only readers and web crawlers.
