---
title: DNSSEC Basics — Chain of Trust
description: What DNSSEC signs, how DS records link parent to child, and why example-dns signs its zones.
category: dns
order: 30
tags: [dns, dnssec, security]
updated: 2026-10-06
related: [dns/dns-records-overview, domains/nameserver-glue-delegation]
---

## The problem DNSSEC solves

Plain DNS answers can be spoofed — a resolver cannot tell a forged A record
from the real one. **DNSSEC** adds cryptographic signatures (RRSIG records)
so resolvers can verify authenticity.

## The chain of trust

1. The **parent zone** (e.g. `.com`) publishes a **DS record** containing a
   hash of your zone's key-signing key.
2. Your zone signs all records with its **ZSK**, and the ZSK with the **KSK**.
3. Validators walk the chain: root → TLD → your zone.

```bash
dig example.com DNSKEY +short
dig example.com DS +short
dig +dnssec example.com A
```

Look for the `ad` (authenticated data) flag in validating resolvers.

## Key rotation reality

- **ZSK**: rotate quarterly — automated by most signers.
- **KSK**: rotate yearly, and update the DS record at your registrar **before**
  removing the old key, or validation fails and your domain goes dark.

:::warn
A broken DNSSEC setup is worse than none: validating resolvers will SERVFAIL
your entire domain. Monitor with a DNSSEC checker after every key event.
:::

## example-dns

ternis.org zones served by `one.ns.ternis.net` / `two.ns.ternis.net` are
DNSSEC-signed — DS records are published via the registrar for every
`example-dns.*` domain.
