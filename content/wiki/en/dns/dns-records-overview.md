---
title: DNS Records Overview — One Table to Rule Them All
description: A, AAAA, CNAME, MX, TXT, NS, SOA, SRV and CAA records explained in one compact reference.
category: dns
order: 5
tags: [dns, records, reference]
updated: 2026-10-06
related: [dns/a-aaaa-records]
---

## The record table

| Type | Purpose | Example |
|------|---------|---------|
| A | Hostname → IPv4 | `example.com → 203.0.113.10` |
| AAAA | Hostname → IPv6 | `example.com → 2001:db8::10` |
| CNAME | Alias to another name | `www → example.com` |
| MX | Mail servers | `10 mail.example.com` |
| TXT | Free text (SPF, verification) | `v=spf1 ...` |
| NS | Delegates to nameservers | `one.ns.ternis.net` |
| SOA | Zone metadata (serial, refresh) | managed by your DNS provider |
| SRV | Service discovery (port/priority) | `_matrix._tcp` |
| CAA | Which CAs may issue certificates | `letsencrypt.org` |

## How to read a zone line

```text
www   300  IN  A  203.0.113.10
```

Fields are: **name**, **TTL**, **class** (`IN` = internet), **type**, **data**.

## Where these live on ternis.org

All ternis.org zones are served authoritatively by `one.ns.ternis.net` and
`two.ns.ternis.net` (see the [example-dns project](https://example-dns.com))
and managed via [dnbx.de](https://dnbx.de).
