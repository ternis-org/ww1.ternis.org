---
title: DNS A and AAAA Records — Point a Domain at an IP
description: What A and AAAA records do, TTL tuning, apex vs www, and verification with dig on example-dns.
category: dns
order: 10
tags: [dns, a-record, aaaa-record, dig, ttl, example-dns]
updated: 2026-10-06
related: [dns/dns-records-overview, domains/nameserver-glue-delegation]
---

## What an A record does

An **A record** maps a hostname to an **IPv4** address. Its sibling, the
**AAAA record**, maps to an **IPv6** address. When you type a domain into a
browser, the resolver asks your authoritative nameserver — for example
`one.ns.ternis.net` — for these records.

```text
example.com.        300  IN  A      203.0.113.10
example.com.        300  IN  AAAA   2001:db8::10
www.example.com.    300  IN  A      203.0.113.10
```

## Apex vs www

| Name | Meaning |
|------|---------|
| `@` / apex (`example.com`) | The bare domain. Use A/AAAA here, never CNAME. |
| `www` | A normal hostname. A record or CNAME both work. |

:::tip
Serve the apex and redirect `www` → apex (or the reverse) so you have exactly
one canonical URL. Duplicates split your SEO ranking.
:::

## TTL tuning

TTL (time to live) tells resolvers how long to cache the answer.

- **Stable infrastructure:** `3600` (1 hour) or higher — fewer queries.
- **Before a migration:** lower to `300` (5 minutes) 24–48h in advance.
- **During an incident:** low TTL lets you fail over fast.

## Verifying with dig

```bash
dig @one.ns.ternis.net example.com +noall +answer
dig example.com AAAA +short
host -t A example.com
```

## Common mistakes

1. Forgetting the AAAA record — IPv6-only clients then fail.
2. TTL of 86400 set right before a server move — you will wait a full day.
3. CNAME at the apex — violates the DNS standard and breaks MX records.
