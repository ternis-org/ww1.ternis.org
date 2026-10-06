---
title: WHOIS, RDAP and Domain Privacy
description: Reading RDAP records, GDPR redaction, and keeping your contact data clean.
category: domains
order: 25
tags: [domains, whois, rdap, privacy, gdpr]
updated: 2026-10-06
related: [domains/how-domains-work, domains/transfer-move-provider]
---

## WHOIS is legacy, RDAP is now

Classic WHOIS (port 43, free-form text) is being replaced by **RDAP**
(HTTPS + JSON). Query it directly:

```bash
curl -s https://rdap.verisign.com/com/v1/domain/example.com | head -c 600
whois example.com   # still works, output varies by registry
```

## What GDPR changed

Since 2018, personal contact data of EU registrants is **redacted by default**
in public WHOIS/RDAP. You will typically see:

- Registrant: "REDACTED FOR PRIVACY" + registrar proxy address
- Technical dates (created, updated, expires) — always public
- Nameservers — always public

## Hygiene checklist

1. Use a dedicated, monitored mailbox for the registrant contact (renewal and
   transfer approvals go there).
2. Keep organization name spelled consistently — mismatches slow transfers.
3. For commercial projects, consider the registrar's trustee/proxy service so
   private addresses never appear in historical WHOIS archives.

:::warn
"Private" WHOIS only hides data from *public* output. The registry and
registrar still hold your real details — and must, for abuse handling.
:::
