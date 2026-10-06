---
title: MX Records and Email Deliverability
description:Routing inbound mail with MX records and the SPF/DKIM/DMARC trio that keeps it out of spam.
category: dns
order: 20
tags: [dns, mx, email, deliverability]
updated: 2026-10-06
related: [dns/txt-spf-dkim-dmarc, dns/dns-records-overview]
---

## How MX routing works

**MX records** name the servers that accept mail for your domain, with a
priority number — **lower number = tried first**.

```text
example.com.   300  IN  MX  10  mail1.example.com.
example.com.   300  IN  MX  20  mail2.example.com.
```

The MX target must be a hostname with an A/AAAA record — never a bare IP and
never a CNAME.

## The deliverability trio

Receiving is only half the job. To land in inboxes instead of spam, publish:

| Record | Job |
|--------|-----|
| SPF (TXT) | Which servers may send for your domain |
| DKIM (TXT) | Cryptographic signature of legitimacy |
| DMARC (TXT) | Policy for failures + aggregate reports |

```text
example.com.  300  IN  TXT  "v=spf1 mx -all"
```

## Rollout order

1. Publish SPF first (lowest risk).
2. Add DKIM and watch DMARC reports with `p=none`.
3. Tighten to `p=quarantine`, then `p=reject`.

:::warn
Skipping straight to `p=reject` without monitoring reports can silently discard
legitimate mail from newsletters, ticket systems, or your Homelab notifier.
:::
