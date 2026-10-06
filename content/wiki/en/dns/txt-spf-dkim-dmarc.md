---
title: TXT Records — SPF, DKIM, and DMARC Syntax Masterclass
description: Complete beginner guide to writing, parsing, and debugging SPF, DKIM, and DMARC TXT records, understanding qualifiers, tags, and avoiding the 10-lookup limit.
category: dns
order: 25
tags: [dns, txt, spf, dkim, dmarc, email, security, sysadmin]
updated: 2026-10-06
related: [dns/mx-email-deliverability, dns/debugging-dig-host-nslookup, dns/dns-records-overview]
---

## What are DNS TXT Records?

A **`TXT` (Text) record** was originally introduced to hold arbitrary human-readable notes inside a DNS zone.

Today, TXT records serve as the global identity layer of the internet. They store machine-readable cryptographic keys, domain ownership verification tokens (Google Search Console, GitHub domain verification), and email authentication policies (**SPF**, **DKIM**, and **DMARC**).

:::tip
**The 255-Character Chunking Rule**: The DNS wire specification limits individual text strings inside a TXT record to 255 bytes. Long records (such as 2048-bit RSA DKIM keys) must be split into multiple quoted chunks within the same record:
`"v=DKIM1; ... chunk 1 ... " "chunk 2 ..."`
Resolvers automatically concatenate these chunks into a single continuous string.
:::

---

## 1. SPF (Sender Policy Framework) Syntax

An SPF record tells recipient mail servers which IP addresses are authorized to send outbound emails claiming to be from `@example.com`.

```text
example.com.    300    IN    TXT    "v=spf1 ip4:203.0.113.19 mx include:_spf.google.com ~all"
```

### Breakdown of SPF components

- `v=spf1`: **Mandatory prefix**. Identifies the record as an SPF version 1 declaration. **A domain must have exactly one SPF record!** Multiple SPF records cause permanent validation errors (`PermError`).
- `ip4:203.0.113.19` (or `ip6:`): Authorizes a specific static IP address or CIDR subnet (`ip4:198.51.100.0/24`) directly without extra DNS lookups.
- `mx`: Authorizes all IP addresses pointed to by your domain's own MX records.
- `include:_spf.google.com`: Recursively queries and includes the SPF policy of a third-party email provider (e.g., Google Workspace, SendGrid, Postmark).
- `Qualifiers` (The Ending):
  - `-all` (**Hard Fail**): Any server not matching the above rules is unauthorized and should be rejected. (The final goal of production security).
  - `~all` (**Soft Fail**): Unlisted servers are unauthorized, but receiving mailboxes should accept the message and mark it as suspicious or move it to spam. (Recommended during testing).
  - `?all` (**Neutral**): No policy stated. Offers zero protection.
  - `+all` (**Pass**): Authorizes the entire internet to send email from your domain. **Never use this.**

:::warn
**The 10-Lookup Limit (RFC 7208)**: SPF evaluations are strictly capped at 10 recursive DNS lookups (`include`, `a`, `mx`, `ptr`). If your `include:` statements chain together and trigger more than 10 lookups, receiving mail servers will throw `PermError` and reject your mail.
:::

---

## 2. DKIM (DomainKeys Identified Mail) Syntax

DKIM attaches a digital cryptographic signature to the header of every outgoing email. The public key is published in your DNS under a subdomain called a **selector**:

```text
mail._domainkey.example.com.    300    IN    TXT    "v=DKIM1; k=rsa; p=MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA..."
```

### Breakdown of DKIM tags

- `mail._domainkey`: The subdomain location where the key lives. `mail` is the **selector name** chosen by your email server, followed by `._domainkey`.
- `v=DKIM1`: Specifies the DKIM protocol version.
- `k=rsa`: The key algorithm (`rsa` or `ed25519`).
- `p=...`: The base64-encoded public cryptographic key. Receiving servers use this public key to verify that the email was actually signed by the private key on your server and that the email body was not modified during transit.

---

## 3. DMARC Syntax

DMARC specifies what action receiving servers should take if an incoming email fails SPF or DKIM verification, and configures aggregate XML reporting.

It is always published at `_dmarc.yourdomain.com`:

```text
_dmarc.example.com.    300    IN    TXT    "v=DMARC1; p=quarantine; rua=mailto:dmarc-reports@example.com; pct=100"
```

### Breakdown of DMARC tags

- `_dmarc.example.com`: The standard subdomain where DMARC records must be located.
- `v=DMARC1`: Identifies the record as DMARC version 1.
- `p=...`: The enforcement policy for the apex domain:
  - `p=none`: Monitor mode. Deliver mail normally and send reports.
  - `p=quarantine`: Send failing emails to spam/junk folders.
  - `p=reject`: Refuse connection / drop failing emails completely.
- `rua=mailto:...`: Aggregate reporting destination. Receiving providers (Google, Yahoo, Microsoft) will send daily XML summaries of all emails received claiming to be from your domain, showing passing/failing IPs.
- `pct=100`: Percentage of failing mail subject to policy (100 = 100% of messages).

---

## Testing TXT records from the terminal

```bash
# Query the SPF policy
dig example.com TXT +short | grep "v=spf1"

# Query the DKIM key for selector 'mail'
dig mail._domainkey.example.com TXT +short

# Query the DMARC policy
dig _dmarc.example.com TXT +short
```
