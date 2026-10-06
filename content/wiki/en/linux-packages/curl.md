---
title: curl — Command Line HTTP Client & API Debugger
description: Complete beginner guide to curl, testing REST APIs, inspecting HTTP response headers, verifying SSL/TLS certificates, and debugging response timing with command flag breakdowns.
category: linux-packages
order: 60
tags: [curl, http, api, debugging, networking, cli, sysadmin]
updated: 2026-10-06
related: [dns/debugging-dig-host-nslookup, javascript/fetch-basics, security/tls-letsencrypt]
---

## What is curl?

**`curl` (Client URL)** is the industry-standard command-line tool for transferring data over network protocols (HTTP, HTTPS, FTP, SFTP, and dozens more).

It is installed by default on almost every operating system and is an indispensable tool for sysadmins and developers to test web endpoints, inspect HTTP headers, debug TLS certificates, and automate API workflows.

---

## 1. Inspecting HTTP Response Headers Only (`-I` / `--head`)

When diagnosing whether a website is up, checking caching headers, or verifying redirects, downloading the entire HTML body is wasteful.

Fetch only the HTTP status code and response headers:

```bash
curl -I https://ternis.org
```

### Flag breakdown

- `-I` (or `--head`): Issues an `HTTP HEAD` request instead of `GET`. The web server returns only HTTP response headers (e.g. `HTTP/2 200`, `Content-Type`, `Cache-Control`, `Set-Cookie`) and immediately closes the stream without sending the HTML body.

---

## 2. Following HTTP Redirects Automatically (`-L` / `--location`)

Websites frequently redirect visitors (e.g. from `http://` to `https://`, or `/wiki` to `/wiki/`):

```bash
curl -IL https://ternis.org/wiki
```

### Flag breakdown

- `-L` (or `--location`): Instructs curl to follow HTTP `301 Moved Permanently` or `302 Found` redirects. By default, curl stops at the first response and outputs the redirect message. Combining `-I` and `-L` (`-IL`) prints the complete redirect chain until it reaches the final `HTTP 200 OK` page.

---

## 3. Sending JSON POST Requests to REST APIs

To submit data to an API endpoint:

```bash
curl -X POST https://api.example.com/v1/items \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d '{"name": "production-node", "active": true}'
```

### Flag breakdown

- `-X POST` (or `--request POST`): Specifies the HTTP method to use (defaults to `GET`).
- `-H "<header>"` (or `--header`): Appends a custom HTTP request header. Here, `Content-Type: application/json` tells the server the payload format, and `Authorization` passes credentials.
- `-d '<data>'` (or `--data`): Sends the specified string as the HTTP request body payload. (Note: using `-d` automatically implies `POST` in curl even if `-X POST` is omitted).

---

## 4. Verbose Mode: Inspecting TLS Handshakes (`-v` / `--verbose`)

When an SSL certificate fails, an API handshake drops, or headers look incorrect:

```bash
curl -vI https://ternis.org
```

### Flag breakdown

- `-v` (or `--verbose`): Displays the entire underlying connection process:
  - DNS resolution and connected IP address.
  - Complete TLS cryptographic handshake (negotiated TLS version, cipher suite, certificate issuer).
  - Outgoing request headers (prefixed with `>`).
  - Incoming response headers (prefixed with `<`).

---

## 5. Bypassing DNS: Testing Servers before Public DNS Updates (`--resolve`)

When moving a website to a new server, you need to test the new server's configuration and TLS certificates **before** switching public DNS records:

```bash
curl -I --resolve example.com:443:203.0.113.10 https://example.com
```

### Flag breakdown

- `--resolve <host:port:address>`: Forces curl to connect directly to IP `203.0.113.10` on port `443` while still sending `Host: example.com` and SNI for `example.com`. This lets you verify the new server without modifying your local `/etc/hosts` file!

---

## 6. Measuring Latency and Performance Breakdown (`-w`)

To diagnose slow website loading times and measure latency bottlenecks:

```bash
curl -w "DNS: %{time_namelookup}s | Connect: %{time_connect}s | TLS: %{time_appconnect}s | TTFB: %{time_starttransfer}s | Total: %{time_total}s\n" \
  -o /dev/null -s https://ternis.org
```

### Flag breakdown

- `-w "<format>"` (or `--write-out`): Prints formatted connection metrics to stdout.
  - `time_namelookup`: Time spent resolving DNS.
  - `time_connect`: Time spent establishing the TCP connection.
  - `time_appconnect`: Time spent completing the TLS/SSL handshake.
  - `time_starttransfer`: Time To First Byte (TTFB).
  - `time_total`: Total roundtrip time in seconds.
- `-o /dev/null` (or `--output`): Discards the downloaded HTML body so it doesn't flood your screen.
- `-s` (or `--silent`): Hides the progress meter.

---

## Quick Reference Summary Table

| Flag | Long Flag | Purpose |
|------|-----------|---------|
| `-I` | `--head` | Fetch HTTP response headers only |
| `-L` | `--location` | Follow HTTP 301/302 redirects |
| `-v` | `--verbose` | Print detailed connection, TLS handshake, and header logs |
| `-s` | `--silent` | Mute progress bar and informational messages |
| `-S` | `--show-error` | Show errors even when `-s` is active |
| `-o <file>`| `--output` | Save response to a file instead of stdout |
| `-O` | `--remote-name` | Save file using the remote server's filename |
| `-d <data>`| `--data` | Send POST payload data |
| `-H <hdr>` | `--header` | Add custom HTTP request header |
| `-k` | `--insecure` | Allow self-signed or invalid SSL certificates (testing only!) |
