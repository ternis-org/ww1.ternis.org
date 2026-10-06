---
title: Nameserver Delegation and Glue Records — Resolving the Chicken-and-Egg Problem
description: Complete beginner guide to DNS zone delegation, in-bailiwick nameservers, glue records, avoiding lame delegations, and CLI verification tools.
category: domains
order: 35
tags: [domains, nameserver, glue, delegation, dns, sysadmin]
updated: 2026-10-06
related: [domains/how-domains-work, dns/selfhost-authoritative-dns, dns/debugging-dig-host-nslookup]
---

## What is DNS Delegation?

The Domain Name System is organized into a tree of delegated zones. No single server in the world holds the complete database of every domain.

Instead, authority is **delegated** downward:
1. The **Root zone (`.`)** delegates authority for `.org` to the `.org` registry nameservers.
2. The **`.org` registry zone** delegates authority for `ternis.org` to our authoritative nameservers (`one.ns.ternis.net` and `two.ns.ternis.net`) by publishing **NS (Name Server)** records in the `.org` zone.

```text
; Parent zone (.org) publishes delegation records:
ternis.org.   IN  NS  one.ns.ternis.net.
ternis.org.   IN  NS  two.ns.ternis.net.
```

When a recursive DNS resolver needs to find `ww1.ternis.org`, it asks `.org`, receives this delegation pointer, and travels to `one.ns.ternis.net` to query the final A/AAAA records.

---

## The "Chicken-and-Egg" Dilemma: In-Bailiwick Nameservers

Consider this scenario:
Suppose you register the domain **`mycompany.com`**, and you decide to run your own nameservers located at:
`ns1.mycompany.com` and `ns2.mycompany.com`.

A global resolver wants to look up `mycompany.com`:
1. It queries the `.com` registry: *"Where is `mycompany.com`?"*
2. The `.com` registry replies: *"Ask `ns1.mycompany.com`."*
3. The resolver asks: *"What is the IP address of `ns1.mycompany.com`?"*
4. To find the IP of `ns1.mycompany.com`, the resolver must query the nameserver for `mycompany.com`... which is `ns1.mycompany.com`!

This circular dependency is impossible to resolve. The nameserver lives inside the very domain it is responsible for serving (known as an **in-bailiwick** nameserver).

---

## The solution: Glue Records

To break the circular dependency, the parent registry stores **Glue Records**:
A glue record is an address record (IPv4 `A` or IPv6 `AAAA`) for the nameserver that is saved **directly in the parent registry zone**.

```text
; In the .com registry zone:
mycompany.com.      IN  NS    ns1.mycompany.com.   ; Delegation
ns1.mycompany.com.  IN  A     203.0.113.53         ; GLUE RECORD
ns1.mycompany.com.  IN  AAAA  2001:db8::53         ; GLUE RECORD
```

Now, when the `.com` registry hands out the NS delegation, it includes the glue IP address in the `ADDITIONAL SECTION` of the DNS reply. The resolver can connect to `203.0.113.53` without having to resolve `ns1.mycompany.com` first.

---

## The ternis.org Architecture: Out-of-Bailiwick Nameservers

A clean architectural approach is using **out-of-bailiwick** nameservers:

Our domains (`ternis.org`, `example-dns.com`, `mail-free.eu`) point to:
- `one.ns.ternis.net`
- `two.ns.ternis.net`

Because these nameservers live under `.net`, resolving `ternis.org` does **not** require any glue records in the `.org` registry! The resolver easily looks up `one.ns.ternis.net` in the `.net` zone. Glue records were only needed once, at the `.net` registry for `ternis.net`.

---

## How to verify delegation and glue records

Use `dig` in your terminal to trace delegation step-by-step:

```bash
# 1. Trace the entire resolution hierarchy from root to authoritative
dig +trace ternis.org NS

# 2. Query the parent registry directly to inspect glue records
dig @a0.org.afilias-nst.info ternis.org NS

# 3. Verify nameserver IPs
host -t A one.ns.ternis.net
```

### Command & flag breakdown

- `dig +trace <domain> NS`: Follows the recursive query chain starting from root nameservers down to the authoritative nameserver, displaying each delegation step.
- `dig @<server> <domain> <type>`: Sends the DNS query directly to the specified nameserver rather than using your computer's local DNS resolver.
- `host -t <type> <domain>`: Simple command-line DNS lookup tool for quick record checks.

---

## Beware: The "Lame Delegation" trap

A **lame delegation** occurs when:
1. The parent zone delegates your domain to nameserver $X$.
2. But nameserver $X$ is either offline, misconfigured, or does not consider itself authoritative for your domain.

When this happens, DNS queries intermittently time out, causing random "Server Not Found" errors worldwide. Always ensure that the NS records in your registrar panel exactly match the NS records declared inside your zone file.
