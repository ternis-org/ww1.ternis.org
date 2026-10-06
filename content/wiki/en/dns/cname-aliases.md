---
title: CNAME Aliases — When (Not) to Use Them
description: Aliasing hostnames with CNAME, the apex problem, and ANAME/ALIAS flattening.
category: dns
order: 15
tags: [dns, cname, alias, apex]
updated: 2026-10-06
related: [dns/a-aaaa-records, dns/dns-records-overview]
---

## What a CNAME does

A **CNAME** makes one hostname an alias of another. The resolver follows the
chain and returns the target's A/AAAA records.

```text
www   300  IN  CNAME  example.com.
```

One lookup becomes two — cheap, but not free. Long chains slow resolution.

## The apex problem

A CNAME **cannot** live at the apex (`example.com`), because the apex must
also hold SOA and NS records, and a CNAME forbids all siblings. Symptoms of
trying anyway: broken mail (MX) and intermittent resolution failures.

| Place | Use |
|-------|-----|
| Apex | A + AAAA records |
| `www`, `app`, `cdn` | CNAME or A — your choice |

## ANAME / ALIAS flattening

Some providers offer ANAME/ALIAS: you configure an alias at the apex, they
serve resolved A/AAAA records. Convenient for pointing the apex at a CDN, but
non-standard — behavior varies by provider. On ternis.org infrastructure the
rule is simple: **apex gets A/AAAA**, subdomains get CNAMEs.

## Checklist

1. No CNAME at the apex — ever.
2. Keep chains short (one hop).
3. Point CNAMEs at names you control, not third-party hostnames that may move.
