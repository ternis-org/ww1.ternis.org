---
title: WHOIS, RDAP, and Domain Privacy — Reading Registration Data
description: Complete beginner guide to legacy WHOIS vs modern RDAP (RESTful JSON), querying via curl and jq, GDPR redaction rules, and WHOIS privacy.
category: domains
order: 25
tags: [domains, whois, rdap, privacy, gdpr, security]
updated: 2026-10-06
related: [domains/how-domains-work, domains/transfer-move-provider]
---

## What are WHOIS and RDAP?

When you register a domain name, ICANN and TLD registries require contact information to identify who is legally responsible for the domain.

Historically, this data was queried using **WHOIS**:
- **Protocol**: Raw TCP port 43 plain-text protocol created in 1982 (RFC 812).
- **Format**: Unstructured text with no universal schema; every registrar and registry formatted responses differently.
- **Drawbacks**: No internationalization (non-ASCII characters broke), no authentication, and contact information was harvested by spammers.

To modernize domain lookups, the IETF developed **RDAP (Registration Data Access Protocol)** (RFC 7480–7484):
- **Protocol**: Secure RESTful queries over **HTTPS**.
- **Format**: Standardized, machine-readable **JSON**.
- **Security**: Built-in support for role-based access control and rate limiting.

---

## Querying RDAP via cURL and jq

Instead of relying on third-party ad-ridden lookup websites, query the authoritative RDAP endpoint directly from your terminal:

```bash
# Query a .com domain directly from Verisign's RDAP endpoint
curl -sL https://rdap.verisign.com/com/v1/domain/example.com | jq '{name: .ldhName, status: .status, events: .events}'
```

### Command & flag breakdown

- `curl`: Command-line tool for transferring data via network protocols (HTTP/HTTPS).
- `-s` (silent mode): Suppresses progress meters and error messages.
- `-L` (follow redirects): Automatically follows HTTP 301/302 redirects to the authoritative registry endpoint.
- `| jq`: Pipes the JSON response into `jq` to parse, filter, and format the output cleanly.
- `ldhName`: Domain name in ASCII (Letters, Digits, Hyphens).
- `status`: ICANN domain status codes (e.g. `clientTransferProhibited`, `active`).
- `events`: Array of key lifecycle timestamps (`registration`, `expiration`, `last changed`).

---

## Legacy WHOIS in the terminal

The traditional `whois` client remains widely installed on Linux and macOS:

```bash
whois example.com
```

Key fields to look for:
- `Domain Name`: The registered domain.
- `Registrar`: The retail provider handling the domain.
- `Creation Date`: When the domain was first registered.
- `Registry Expiry Date`: The date the domain will expire if not renewed.
- `Name Server`: The authoritative nameservers currently delegated for the domain.

---

## How GDPR revolutionized Domain Privacy

Before May 2018 (when the European General Data Protection Regulation came into effect), anyone could look up the private home address, personal mobile number, and personal email address of any domain registrant in public WHOIS databases.

**Under modern GDPR rules:**
- Personal contact data of individual registrants is **automatically redacted** by default across all ICANN-accredited registrars.
- The public RDAP/WHOIS response displays:
  ```text
  Registrant Name: REDACTED FOR PRIVACY
  Registrant Street: REDACTED FOR PRIVACY
  Registrant Email: https://contact-privacy-proxy.example/d/domain.com
  ```
- Technical details (registration date, expiry date, registrar, nameservers, DNSSEC status) remain **fully public**, as they are strictly required for internet routing and troubleshooting.

---

## WHOIS Privacy / Proxy Services

If you register domains outside the European Union or with registries that do not apply GDPR by default, registrars offer **WHOIS Privacy (ID Protection)**:
- A proxy service replaces your personal contact details with the proxy company's corporate information and forwarding address.
- Legitimate legal notices and transfer verification links are forwarded to your real private email address without revealing your physical address to public scrapers.
