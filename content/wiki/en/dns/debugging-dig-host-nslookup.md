---
title: Debugging DNS with dig, host, and nslookup — Complete Sysadmin Toolkit
description: Master DNS troubleshooting with dig, host, and nslookup, trace root-to-leaf resolution, understand RCODE errors (NXDOMAIN, SERVFAIL), and diagnose cache delays.
category: dns
order: 35
tags: [dns, dig, host, nslookup, troubleshooting, sysadmin, devops]
updated: 2026-10-06
related: [dns/a-aaaa-records, dns/txt-spf-dkim-dmarc, dns/dnssec-basics]
---

## Why mastering DNS debugging is essential

When a website is down, an email bounces, or an API call fails, the root cause is frequently DNS misconfiguration or stale caching.

The command-line tools **`dig` (Domain Information Groper)** and **`host`** provide direct, unadulterated insight into the global DNS query pipeline.

---

## The Essential `dig` Commands & Flag Breakdown

```bash
# 1. Ask a specific nameserver directly (bypassing local ISP caches)
dig @one.ns.ternis.net example.com A +noall +answer

# 2. Trace the entire resolution hierarchy from root to destination
dig example.com +trace

# 3. Clean, script-friendly output (only the IP address)
dig example.com +short

# 4. Inspect mail exchanger records
dig example.com MX +noall +answer

# 5. Inspect SPF, DKIM, or DMARC text records
dig example.com TXT +short
```

### Complete Flag Breakdown

- `@<nameserver>`: Directs `dig` to send the query to a specific nameserver IP or hostname (e.g. `@1.1.1.1` for Cloudflare, `@8.8.8.8` for Google, or `@one.ns.ternis.net` for authoritative answers).
- `+trace`: Simulates a full iterative resolver walk. It begins at the internet root servers (`.`), steps down to the Top-Level Domain registry (`.com`), and finishes at your authoritative nameservers. If resolution fails, `+trace` highlights the exact hop where communication halted.
- `+noall`: Clears all default display sections (flags, question, authority, statistics).
- `+answer`: Re-enables only the `ANSWER SECTION`, giving you clean, readable output without visual clutter.
- `+short`: Returns strictly the final resource record data (e.g., `203.0.113.10`), ideal for parsing inside bash scripts.
- `+dnssec`: Requests DNSSEC cryptographic signatures (`RRSIG`) along with the answer.

---

## Decoding DNS Response Codes (RCODEs)

When reading `dig` output, look at the `status:` field in the header:

| Status Code | Meaning | What is causing it |
|:-----------:|---------|--------------------|
| **`NOERROR`** | Success | The query succeeded. If the answer section is empty, the domain exists but has no records of the requested type (e.g. queried `AAAA` on an IPv4-only host). |
| **`NXDOMAIN`** | Non-Existent Domain | The domain or subdomain does not exist in the zone. Check for typos in your hostname or missing zone records. |
| **`SERVFAIL`** | Server Failure | The nameserver encountered an internal failure. Most common causes: **DNSSEC signature validation failure** or a **lame delegation**. |
| **`REFUSED`** | Query Refused | The nameserver refused to answer. Often occurs when querying a private recursive resolver from an unauthorized public IP. |

---

## Diagnosing the "It Works for Me, Broken for Them" Mystery

If a website update appears live on your machine but fails for a colleague or client:

Compare responses across multiple independent public resolvers:

```bash
# Check Cloudflare resolver
dig @1.1.1.1 example.com +noall +answer

# Check Google Public DNS
dig @8.8.8.8 example.com +noall +answer

# Check Authoritative Server directly
dig @one.ns.ternis.net example.com +noall +answer
```

### Reading TTL countdowns

In the answer section:

```text
example.com.    247    IN    A    203.0.113.10
```

The number `247` is the **remaining TTL seconds** in that resolver's cache. If you run the command again 10 seconds later, it will show `237`. The resolver will not query your authoritative nameserver for the new IP until that counter hits `0`.

---

## Quick Host & nslookup alternatives

```bash
# Quick lookup with host
host -t A example.com

# Reverse DNS lookup (IP to hostname)
host 203.0.113.10

# nslookup quick query
nslookup example.com 1.1.1.1
```
