---
title: MX Records and Email Deliverability — The SPF, DKIM, and DMARC Trinity
description: Complete beginner guide to routing incoming email with MX records and achieving 100% inbox delivery using SPF, DKIM, and DMARC authentication.
category: dns
order: 20
tags: [dns, mx, email, spf, dkim, dmarc, deliverability, sysadmin]
updated: 2026-10-06
related: [dns/txt-spf-dkim-dmarc, dns/dns-records-overview, dns/debugging-dig-host-nslookup]
---

## How inbound email routing works: MX Records

When an external mail server (such as Gmail or Outlook) sends an email to `user@example.com`, it does not connect to the web server IP. Instead, it queries the DNS for **MX (Mail Exchanger)** records.

```text
example.com.    300    IN    MX    10    mail1.example.com.
example.com.    300    IN    MX    20    mail2.example.com.
```

### Understanding MX Priority numbers

Each MX record has a numeric priority preference:
- **Lower numbers have higher priority**: In this example, sending mail servers will attempt to deliver to `mail1.example.com` (priority 10) first.
- **Higher numbers act as backups**: If `mail1.example.com` is offline or unreachable, sending servers automatically fall back to `mail2.example.com` (priority 20).

### Strict RFC Rules for MX Records:
1. **Never point an MX record to an IP address**: MX records must point to a valid domain name (`mail.example.com.`), not an IP (`203.0.113.10`).
2. **Never point an MX record to a CNAME**: The MX target must resolve directly to `A` and `AAAA` records. Pointing an MX record to a CNAME alias violates RFC 2181 and causes delivery failures.

---

## Why receiving email is only half the battle: Deliverability

Anyone with a Linux VPS can run an SMTP script claiming to be `ceo@yourdomain.com`. Because original SMTP lacked authentication, malicious spam and phishing spoofed sender addresses freely.

To protect your domain reputation and ensure legitimate emails land in recipient **inboxes** instead of spam folders, major providers (Google, Microsoft, Yahoo) require three cryptographic and DNS authentication standards:

```text
[ Incoming Email ]
        │
        ├──► 1. Check SPF: Did mail originate from an authorized IP?
        │
        ├──► 2. Check DKIM: Does the cryptographic cryptographic header match the public key?
        │
        └──► 3. Check DMARC: Do SPF/DKIM align with the "From" header? Apply policy (reject/quarantine).
```

### The Authentication Trinity

| Record | Protocol Name | How it works |
|:------:|---------------|--------------|
| **`SPF`** | Sender Policy Framework | A TXT record listing the specific IP addresses and servers permitted to send outbound emails on behalf of your domain. |
| **`DKIM`** | DomainKeys Identified Mail | Your sending mail server cryptographically signs every outgoing email header. The receiving server fetches your public key from DNS to verify the message was not modified in transit. |
| **`DMARC`** | Domain-based Message Authentication, Reporting & Conformance | Instructs receiving servers what to do if an email fails SPF or DKIM checks, and generates aggregate feedback reports sent to your admin mailbox. |

---

## The Safe 4-Stage DMARC Rollout Strategy

:::warn
**Never jump directly to `p=reject` on day one!** If you enforce strict rejection before auditing all third-party services that send email on your behalf (such as Zendesk, Shopify, GitHub notifications, or newsletter tools), legitimate business emails will be permanently dropped.
:::

1. **Stage 1: Observation (`p=none`)**
   Deploy SPF and DKIM. Publish a DMARC policy with `p=none` and a reporting mailbox:
   `v=DMARC1; p=none; rua=mailto:dmarc-reports@example.com`
   Monitor XML reports for 2 to 4 weeks to identify all legitimate sending services and add them to SPF.
2. **Stage 2: Quarantine (`p=quarantine; pct=25`)**
   Move suspicious emails to spam for a fraction of traffic while monitoring for false positives.
3. **Stage 3: Full Quarantine (`p=quarantine; pct=100`)**
   All unauthenticated emails are routed directly to recipient junk/spam folders.
4. **Stage 4: Full Protection (`p=reject`)**
   Receiving mail servers outright reject fraudulent emails at the SMTP connection layer.

---

## Verifying MX and Mail records in the terminal

```bash
# Check Mail Exchangers and priorities
dig example.com MX +noall +answer

# Inspect SPF policy
dig example.com TXT +short | grep "v=spf1"

# Inspect DMARC policy
dig _dmarc.example.com TXT +short
```
