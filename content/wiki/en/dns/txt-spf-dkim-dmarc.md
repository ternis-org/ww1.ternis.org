---
title: TXT Records — SPF, DKIM and DMARC Syntax
description: Writing and testing SPF, DKIM and DMARC TXT records without breaking your mail flow.
category: dns
order: 25
tags: [dns, txt, spf, dkim, dmarc]
updated: 2026-10-06
related: [dns/mx-email-deliverability, dns/debugging-dig-host-nslookup]
---

## SPF

One SPF record per domain (multiple `v=spf1` strings break evaluation):

```text
example.com.  300  IN  TXT  "v=spf1 mx include:_spf.example.net -all"
```

Qualifiers: `-all` (hard fail, recommended at the end), `~all` (soft fail
while testing), `+all` (allow everything — never use this).

## DKIM

Your mail provider gives you a selector + key. Publish under
`<selector>._domainkey`:

```text
mail._domainkey  300  IN  TXT  "v=DKIM1; k=rsa; p=MIIBIjANBgkq..."
```

## DMARC

```text
_dmarc  300  IN  TXT  "v=DMARC1; p=none; rua=mailto:dmarc@example.com"
```

Start with `p=none` to **collect reports**, then escalate:

```text
_dmarc  300  IN  TXT  "v=DMARC1; p=quarantine; rua=mailto:dmarc@example.com; pct=100"
```

## Testing

```bash
dig example.com TXT +short
dig mail._domainkey.example.com TXT +short
dig _dmarc.example.com TXT +short
```

:::tip
TXT strings longer than 255 characters must be split into quoted chunks —
most DNS UIs do this automatically, but `dig` output will show the seams.
:::
