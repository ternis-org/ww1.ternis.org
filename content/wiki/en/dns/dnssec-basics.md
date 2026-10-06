---
title: DNSSEC Basics — Cryptographic Chain of Trust Explained
description: Complete beginner guide to DNSSEC, preventing DNS spoofing and cache poisoning, understanding DS, DNSKEY, and RRSIG records, and verifying with dig.
category: dns
order: 30
tags: [dns, dnssec, security, cryptography, sysadmin, networking]
updated: 2026-10-06
related: [dns/dns-records-overview, domains/nameserver-glue-delegation, dns/debugging-dig-host-nslookup]
---

## The vulnerability: Why unencrypted DNS can be spoofed

Traditional DNS (designed in 1983) transmits queries and responses in plaintext over UDP port 53 without cryptographic verification.

An attacker on the network path can easily forge a fake DNS response (**DNS Cache Poisoning** or spoofing). If an attacker injects a fraudulent IP for your banking or email domain into a recursive resolver's cache, every user using that resolver is silently redirected to a phishing server without their browser displaying any error.

**DNSSEC (Domain Name System Security Extensions)** eliminates this vulnerability by adding digital cryptographic signatures to all DNS records.

---

## How DNSSEC works: The Cryptographic Records

DNSSEC does not encrypt queries (traffic is still readable, which is addressed by DNS-over-HTTPS/DoH). Instead, it guarantees **data authenticity and integrity**: Resolvers can mathematically prove that records were issued by the legitimate zone owner and have not been altered in transit.

DNSSEC introduces four new record types:

| Record Type | Name | Purpose |
|:-----------:|------|---------|
| **`RRSIG`** | Resource Record Signature | Contains the digital cryptographic signature for a set of DNS records (RRset). |
| **`DNSKEY`** | DNS Public Key | Stores the public cryptographic keys used to verify the `RRSIG` signatures. |
| **`DS`** | Delegation Signer | Stored in the **parent registry zone** (e.g. `.org`), containing a cryptographic fingerprint (hash) of the child zone's public key. |
| **`NSEC` / `NSEC3`** | Next Secure Record | Cryptographically proves that a specific domain or record does **not** exist (Authenticated Denial of Existence). |

---

## The Chain of Trust: From Root to Domain

DNSSEC forms a continuous unbroken cryptographic hierarchy from the top of the internet down to your server:

```text
[ ICANN Root Zone (.) ] ── Public Trust Anchor
        │  (Parent signs DS for .org)
        ▼
   [ .org Registry ]
        │  (Parent signs DS for ternis.org)
        ▼
   [ ternis.org Authoritative Zone ]
        │  (Signs DNSKEY and all A/AAAA/MX records with RRSIG)
        ▼
   [ Validating Resolver ] ──► Verified Authenticated Data (AD Flag)
```

1. **Root Zone (`.`)**: Modern validating DNS resolvers are pre-configured with the ICANN root trust anchor.
2. **Top-Level Domain**: The root zone validates the DS record for `.org`.
3. **Your Zone**: The `.org` registry validates the DS record for `ternis.org`.
4. **Your Records**: Your authoritative nameserver serves `A` records accompanied by `RRSIG` signatures signed by your zone's key.

---

## Verifying DNSSEC in the terminal

You can inspect the cryptographic signatures using `dig`:

```bash
# 1. Query the zone's public keys
dig ternis.org DNSKEY +short

# 2. Query the parent registry's DS record
dig ternis.org DS +short

# 3. Request an A record with DNSSEC validation enabled
dig +dnssec ternis.org A
```

### What to look for in the output:
Look at the `flags:` section of the header in `dig`:
```text
;; flags: qr rd ra ad; QUERY: 1, ANSWER: 2, ...
```
- **`ad` (Authenticated Data)**: The validating resolver successfully verified the entire cryptographic chain of trust from the root zone down to the target record. The answer is authentic and untampered.

---

## Key Management: ZSK vs KSK

A DNSSEC zone utilizes two keys:
1. **ZSK (Zone Signing Key)**: A fast key used to sign the everyday records in your zone. Rotated automatically every 1 to 3 months.
2. **KSK (Key Signing Key)**: Signs only the ZSK. Its cryptographic hash is published as the **DS record** at your domain registrar. Rotated annually.

:::warn
**Never delete an old KSK or change keys without updating the DS record at your registrar first!** If the DS record in the parent registry does not match the active KSK in your zone, all validating resolvers worldwide will mark your zone as **BOGUS** and return `SERVFAIL`, completely disconnecting your domain from the internet.
:::
