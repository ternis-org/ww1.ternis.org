---
title: DNS A and AAAA Records — Pointing Domains at IP Addresses
description: Complete beginner guide to IPv4 A records and IPv6 AAAA records, dual-stack configurations, TTL tuning strategies, and CLI verification with dig.
category: dns
order: 10
tags: [dns, a-record, aaaa-record, ipv4, ipv6, dig, ttl, sysadmin]
updated: 2026-10-06
related: [dns/dns-records-overview, dns/cname-aliases, domains/nameserver-glue-delegation]
---

## What are A and AAAA Records?

When you type a website domain into your web browser, your computer needs to find the server's numeric IP address.

- **`A` Record (Address)**: Maps a hostname to a 32-bit **IPv4** address (e.g. `203.0.113.10`).
- **`AAAA` Record (Quad-A)**: Maps a hostname to a 128-bit **IPv6** address (e.g. `2001:db8::10`). It is called "Quad-A" because an IPv6 address is four times longer (128 bits) than an IPv4 address (32 bits).

```text
example.com.        300  IN  A      203.0.113.10
example.com.        300  IN  AAAA   2001:db8::10
www.example.com.    300  IN  A      203.0.113.10
www.example.com.    300  IN  AAAA   2001:db8::10
```

---

## Why Dual-Stack (Both A and AAAA) is essential

Modern internet clients (especially mobile devices on cellular LTE/5G networks and modern home fiber) operate on IPv6-only networks using translation mechanisms (like DNS64/NAT64).

When both `A` and `AAAA` records are present, modern operating systems use an algorithm called **Happy Eyeballs (RFC 8305)**:
- The browser queries both records simultaneously.
- It attempts connections over IPv6 first, falling back instantly to IPv4 if IPv6 has high latency.
- If you forget to configure an `AAAA` record, you force IPv6 clients through expensive ISP NAT translation gateways or leave IPv6-only users unable to connect.

---

## The Apex Domain (`@`) vs. Subdomains (`www`)

- **Apex Domain (Root domain, Naked domain)**: The base domain without any subdomain prefix, represented in DNS zone files as `@` (e.g., `example.com`).
- **Subdomain**: A prefix under the domain (e.g., `www.example.com`, `api.example.com`).

| Location | Recommended Records | Can you use CNAME? |
|----------|---------------------|:------------------:|
| **Apex (`@`)** | `A` + `AAAA` | **NO.** Violates DNS RFC standard. |
| **Subdomain (`www`)** | `A` + `AAAA` or `CNAME` | **YES.** Both are valid. |

:::tip
Always pick one canonical version (either apex `example.com` or `www.example.com`) and configure your web server (Nginx/Caddy) to send a 301 permanent redirect from the secondary version. This consolidates SEO ranking authority into a single URL.
:::

---

## TTL (Time to Live) tuning strategies

The **TTL** value (measured in seconds) instructs caching resolvers how long they may cache the record before asking your nameservers again:

| Scenario | Recommended TTL | Explanation |
|----------|:---------------:|-------------|
| **Normal Production** | `3600` (1 hour) or `86400` (24h) | Maximizes DNS cache hit rate, speeds up page load times, and minimizes load on your authoritative nameservers. |
| **Planned Migration** | `300` (5 minutes) | Lower the TTL 24 to 48 hours before you change server IP addresses. Once changed, global propagation completes in just 5 minutes. |
| **Emergency / Incident** | `60` to `300` | Allows rapid failover between servers during maintenance. |

---

## Verifying records with `dig` in the terminal

To test and verify that your A and AAAA records are resolving correctly:

```bash
# 1. Query the authoritative nameserver directly
dig @one.ns.ternis.net example.com A +noall +answer

# 2. Check the IPv6 AAAA record
dig example.com AAAA +short

# 3. Simple quick lookup using host
host -t A example.com
```

### Command & flag breakdown

- `dig @one.ns.ternis.net`: Queries our specific authoritative nameserver directly, bypassing local ISP caches to see the real-time record state.
- `+noall +answer`: Filters out verbose header and statistics comments, printing strictly the answer section.
- `+short`: Strips all formatting, returning only the IP address value (ideal for shell scripts).
- `host -t <type>`: Command-line DNS query utility that outputs human-friendly one-line summaries.

---

## Common beginner mistakes

1. **Forgetting IPv6 (`AAAA`)**: Always configure both IPv4 and IPv6 on modern cloud servers.
2. **Setting CNAME at the Apex**: Placing a CNAME on `@` removes all other records (including MX and SOA), breaking incoming email.
3. **Migrating with High TTL**: Forgetting to lower a 24-hour TTL before changing IP addresses will cause half your visitors to connect to the old server for an entire day.
