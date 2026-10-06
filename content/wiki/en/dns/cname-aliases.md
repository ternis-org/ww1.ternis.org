---
title: CNAME Aliases — When and How to Use Canonical Name Records
description: Complete beginner guide to CNAME DNS records, resolution mechanics, why CNAME breaks the zone apex, ALIAS flattening, and the trailing dot rule.
category: dns
order: 15
tags: [dns, cname, alias, apex, sysadmin, networking]
updated: 2026-10-06
related: [dns/a-aaaa-records, dns/dns-records-overview, dns/debugging-dig-host-nslookup]
---

## What is a CNAME Record?

A **CNAME (Canonical Name)** record creates an alias that maps one hostname to another domain name instead of directly to an IP address.

When a client queries a CNAME, the DNS resolver reads the alias and performs a subsequent lookup to find the target's actual `A` (IPv4) or `AAAA` (IPv6) address:

```text
www.example.com.    300    IN    CNAME    example.com.
```

In this example, `www.example.com` is an alias for the canonical name `example.com`.

---

## How CNAME resolution works behind the scenes

```text
[ Browser ] ── 1. Query A for www.example.com ──► [ DNS Resolver ]
                                                           │
[ DNS Resolver ] ◄── 2. Returns CNAME: example.com ────────┤
        │                                                  │
        └─── 3. Query A for example.com ───────────────────┤
                                                           │
[ Browser ] ◄── 4. Returns IP 203.0.113.10 ────────────────┘
```

Because CNAME records require the resolver to perform multiple sequential lookups, **keep CNAME chains short**. Never point a CNAME to another CNAME to another CNAME; point aliases directly to the final canonical destination.

---

## The "Zone Apex" Problem: Why CNAME cannot be on `@`

A fundamental rule of the DNS specification (RFC 1034 and RFC 2181) states:
> *"If a CNAME record exists at a specific name node, no other data records of any type may exist for that same name."*

Every domain apex (the root of your zone, represented as `@` or `example.com`) **must** contain:
- An **`SOA`** (Start of Authority) record.
- At least two **`NS`** (Name Server) records.
- Often an **`MX`** (Mail Exchanger) record.

If you attempt to place a CNAME record on the apex domain (`@`), it legally overrides and destroys all `NS`, `SOA`, and `MX` records. Email delivery to `@example.com` fails, and DNSSEC validation breaks.

| Domain Location | Allowed Record Types | Can you put a CNAME? |
|:---------------:|----------------------|:--------------------:|
| **Apex (`@` / `example.com`)** | `A`, `AAAA`, `MX`, `TXT`, `SOA`, `NS` | **NO (Forbidden)** |
| **Subdomains (`www`, `blog`, `cdn`)** | `A`, `AAAA`, or `CNAME` | **YES (Fully supported)** |

---

## What is CNAME Flattening (ALIAS / ANAME)?

Some modern managed DNS providers (such as Cloudflare, AWS Route 53, or DNSimple) offer pseudo-records called **ALIAS**, **ANAME**, or **CNAME Flattening**.

How it works:
1. You enter an alias target for your apex domain in the web dashboard.
2. The provider's nameservers internally resolve that target to an IP address.
3. When external visitors query your apex, the nameserver serves standard `A` and `AAAA` records, preserving RFC compliance.

On standard BIND or sovereign authoritative nameservers (like `ternis.org`'s `example-dns`), we adhere strictly to standard DNS rules: **Apex gets direct A/AAAA records**, and subdomains use CNAMEs.

---

## The critical "Trailing Dot" rule

In raw DNS zone files and zone editors, pay close attention to the trailing dot:

```text
# CORRECT: Fully Qualified Domain Name (FQDN)
www.example.com.    300    IN    CNAME    example.com.

# INCORRECT: Missing trailing dot
www.example.com.    300    IN    CNAME    example.com
```

Without the trailing dot at the end of `example.com`, the DNS software automatically appends the current zone name to the end, turning the target into:
`example.com.example.com.` (which does not exist and results in `NXDOMAIN`).

---

## Verifying CNAME records in the terminal

```bash
# Query the CNAME record specifically
dig www.example.com CNAME +noall +answer

# Follow the resolution to the resolved IP
host www.example.com
```
