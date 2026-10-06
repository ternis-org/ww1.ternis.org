---
title: Debugging DNS with dig, host and nslookup
description: Tracing resolution with +trace, reading negative answers, and the five commands that solve 90% of DNS issues.
category: dns
order: 35
tags: [dns, dig, host, debugging]
updated: 2026-10-06
related: [dns/a-aaaa-records, dns/txt-spf-dkim-dmarc]
---

## Ask a specific server

Skip cached resolvers and interrogate the authority directly:

```bash
dig @one.ns.ternis.net example.com +noall +answer
host -t NS example.com one.ns.ternis.net
```

## Trace the full chain

```bash
dig example.com +trace
```

This walks root → TLD → authoritative servers. The hop where the trail dies
is where your problem lives (usually a missing glue record or wrong NS set).

## Read negative answers

```bash
dig nonexistent.example.com
```

- `NXDOMAIN` — name does not exist. Check spelling and zone content.
- `NOERROR` with zero answers — name exists but has no records of that type
  (e.g. asking AAAA where only A exists).
- `SERVFAIL` — often DNSSEC validation failure or a lame delegation.

## TTL and caching checks

```bash
dig example.com +noall +answer   # note the TTL counting down = cached
dig +short example.com
```

:::tip
When "it works for me but not for them", compare `dig @8.8.8.8` vs
`dig @1.1.1.1` vs your authoritative server. Different cached TTLs almost
always explain the discrepancy.
:::
