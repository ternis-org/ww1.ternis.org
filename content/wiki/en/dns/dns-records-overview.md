---
title: DNS Records Overview — The Definitive Beginner Guide
description: Complete reference to all fundamental DNS record types (A, AAAA, CNAME, MX, TXT, NS, SOA, SRV, CAA, PTR), zone syntax, and inspection commands.
category: dns
order: 5
tags: [dns, records, reference, beginner, sysadmin, networking]
updated: 2026-10-06
related: [dns/a-aaaa-records, dns/cname-aliases, dns/debugging-dig-host-nslookup]
---

## What is a DNS Record?

The **Domain Name System (DNS)** is a distributed database storing instructions called **Resource Records (RRs)**. A collection of records for a specific domain is saved in a text document called a **Zone File**.

Each record instructs internet resolvers how to handle requests for your domain name—whether routing website visitors to a web server, directing incoming emails to a mail provider, or cryptographically validating domain ownership.

---

## The Anatomy of a DNS Record

Every standard DNS record in a BIND-compatible zone file consists of five distinct fields:

```text
www.example.com.    300    IN    A    203.0.113.10
       │             │     │     │         │
      Name          TTL  Class  Type     Data (RDATA)
```

1. **Name (Owner)**: The domain name or subdomain the record applies to. In full zone format, it terminates with a trailing dot (`.`) to signify a Fully Qualified Domain Name (FQDN).
2. **TTL (Time to Live)**: The number of seconds recursive resolvers (like `8.8.8.8`) are permitted to cache this record in memory before querying the authoritative nameserver again.
3. **Class**: The network protocol family. In modern computing, this is almost universally `IN` (Internet).
4. **Type**: The record type identifier (e.g. `A`, `AAAA`, `CNAME`, `MX`).
5. **Data (RDATA)**: The actual target payload (an IP address, hostname, or text string).

---

## Complete DNS Record Types Reference

| Type | Record Name | What it does | Real-World Example Value |
|:----:|-------------|--------------|--------------------------|
| **`A`** | Address | Maps a hostname to a 32-bit **IPv4** address | `203.0.113.10` |
| **`AAAA`** | Quad-A | Maps a hostname to a 128-bit **IPv6** address | `2001:db8::10` |
| **`CNAME`** | Canonical Name | Creates an alias pointing one hostname to another. **Cannot be placed at the zone apex (`@`)!** | `example.com.` |
| **`MX`** | Mail Exchanger | Directs incoming emails to mail servers, ordered by preference priority number | `10 mail.example.com.` |
| **`TXT`** | Text | Stores human or machine-readable text (SPF, DKIM, DMARC, ACME challenge tokens) | `"v=spf1 include:_spf.ternis.net ~all"` |
| **`NS`** | Name Server | Delegates authority for a DNS zone to specific authoritative nameservers | `one.ns.ternis.net.` |
| **`SOA`** | Start of Authority | Declares administrative zone metadata (serial number, admin contact email, replication timers) | `one.ns.ternis.net. hostmaster.ternis.org. (2026100601 3600 600 1209600 300)` |
| **`CAA`** | Certification Authority Authorization | Restricts which Certificate Authorities (e.g., Let's Encrypt) are allowed to issue TLS certificates for the domain | `0 issue "letsencrypt.org"` |
| **`SRV`** | Service Locator | Defines the hostname and port number for specific protocol services (SIP, Matrix, Minecraft, LDAP) | `10 60 8448 matrix.example.com.` |
| **`PTR`** | Pointer | Maps an IP address back to a hostname (Reverse DNS / rDNS), primarily used by email servers to prevent spam | `10.113.0.203.in-addr.arpa. -> mail.example.com.` |

---

## Example Zone File

Here is how a real-world zone file brings these records together:

```text
$TTL 3600
@       IN  SOA   one.ns.ternis.net. admin.example.com. (
                  2026100601 ; Serial (YYYYMMDDNN)
                  7200       ; Refresh (2 hours)
                  3600       ; Retry (1 hour)
                  1209600    ; Expire (2 weeks)
                  300        ; Negative Cache TTL (5 min)
                  )

; Authoritative Nameservers
@       IN  NS    one.ns.ternis.net.
@       IN  NS    two.ns.ternis.net.

; Apex Web Server (IPv4 and IPv6)
@       IN  A     203.0.113.10
@       IN  AAAA  2001:db8::10

; Subdomains
www     IN  CNAME example.com.
api     IN  A     203.0.113.50

; Mail Routing and Security
@       IN  MX    10 mail.example.com.
@       IN  TXT   "v=spf1 mx -all"
_dmarc  IN  TXT   "v=DMARC1; p=quarantine; rua=mailto:dmarc@example.com"
```

---

## Inspecting records via CLI

To inspect any of these records from your terminal:

```bash
# Query IPv4 address
dig example.com A +short

# Query Mail Exchanger records
dig example.com MX +noall +answer

# Query TXT records (SPF, DMARC)
dig example.com TXT +short
```
