---
title: curl — Command Line HTTP Client & API Debugger
description: Essential curl recipes for testing REST APIs, inspecting HTTP response headers, verifying SSL/TLS certificates, and debugging response timing.
category: linux-packages
order: 60
tags: [curl, http, api, debugging, networking, cli]
updated: 2026-10-06
related: [dns/debugging-dig-host-nslookup, javascript/fetch-basics, security/tls-letsencrypt]
---

## What is curl?

`curl` is the industry-standard command-line tool for transferring data with URLs using HTTP, HTTPS, FTP, and dozens of other protocols. It is essential for troubleshooting web servers, REST APIs, and DNS resolution.

## Essential Everyday Commands

### Inspect HTTP Response Headers Only (`-I`)

Fetches only response status and headers without downloading the body:

```bash
curl -I https://ternis.org
```

### Follow Redirects Automatically (`-L`)

Follow 301/302 redirects to the final destination:

```bash
curl -IL https://ternis.org/wiki
```

### Send JSON POST Requests

```bash
curl -X POST https://api.example.com/v1/items \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{"name": "production-node", "active": true}'
```

### Verbose Mode for SSL/TLS Handshake Inspection (`-v`)

See IP resolution, TLS handshake cipher suites, and raw request/response headers:

```bash
curl -vI https://ternis.org
```

### Resolve to a Specific IP (Bypass DNS)

Test a new server before updating public DNS records:

```bash
curl -I --resolve example.com:443:203.0.113.10 https://example.com
```

### Measure Performance and Latency

Print exact timing breakdown for DNS lookup, TCP connect, TLS handshake, and first-byte response:

```bash
curl -w "DNS: %{time_namelookup}s | Connect: %{time_connect}s | TLS: %{time_appconnect}s | TTFB: %{time_starttransfer}s | Total: %{time_total}s\n" \
  -o /dev/null -s https://ternis.org
```

:::tip
Combine `-s` (silent) and `-S` (show error) with `-o /dev/null` when writing automated uptime and health check scripts.
:::
