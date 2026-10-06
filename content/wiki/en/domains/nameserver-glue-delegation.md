---
title: Nameserver Delegation and Glue Records
description: How NS delegation works, when glue is required, and the one.ns.ternis.net setup as a worked example.
category: domains
order: 35
tags: [domains, nameserver, glue, delegation]
updated: 2026-10-06
related: [domains/how-domains-work, dns/selfhost-authoritative-dns, dns/debugging-dig-host-nslookup]
---

## Delegation in one picture

The parent zone (`.org`) holds **NS records** pointing at your nameservers.
Resolvers follow them to ask your servers for everything else.

```text
; in the .org zone:
ternis.org.   IN  NS  one.ns.ternis.net.
ternis.org.   IN  NS  two.ns.ternis.net.
```

## When glue is required

If a nameserver's own hostname lives **inside** the domain it serves
(in-bailiwick), resolvers face a chicken-and-egg problem: to find
`ns1.example.com` they must ask… `ns1.example.com`. The fix: **glue records**
— A/AAAA entries for the nameserver stored in the *parent* zone.

```text
; parent additionally stores:
ns1.example.com.  IN  A  203.0.113.53
```

ternis.org avoids this elegantly: `one./two.ns.ternis.net` serve zones like
`ternis.org` and `example-dns.com` from *outside* those zones, so no glue is
needed for most delegations — only for `ternis.net` itself.

## Verify a delegation

```bash
dig +trace ternis.org NS
host -t NS ternis.org
dig one.ns.ternis.net +short
```

:::warn
A lame delegation — parent points at nameservers that don't answer
authoritatively for your zone — makes the domain intermittently unreachable.
Check both directions: parent NS set must equal the NS set in your own zone.
:::
