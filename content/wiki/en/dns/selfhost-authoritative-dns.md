---
title: Self-Hosting Authoritative DNS with example-dns
description: Complete beginner guide to running authoritative nameservers, Primary-Secondary replication, AXFR zone transfers, TSIG security, and the example-dns architecture.
category: dns
order: 40
tags: [dns, authoritative, selfhosting, example-dns, bind, sysadmin]
updated: 2026-10-06
related: [dns/dnssec-basics, domains/nameserver-glue-delegation, homelab/docker-compose-homelab]
---

## Authoritative Nameservers vs. Recursive Resolvers

Before hosting DNS servers, understand the fundamental distinction between the two types of DNS software:

- **Recursive Resolver** (Client-facing, e.g. Unbound, Pi-hole, Google 8.8.8.8): Does not own any zones. It walks the internet hierarchy to find answers on behalf of your laptop or phone.
- **Authoritative Nameserver** (Server-facing, e.g. BIND9, Knot DNS, NSD, PowerDNS): Owns the definitive master copy of records for a specific domain zone (e.g. `ternis.org`). It does not answer recursive queries for third-party sites like `google.com`.

Self-hosting authoritative DNS gives you complete digital sovereignty, eliminates vendor lock-in, enables Git-based CI/CD zone deployments, and gives you total control over DNSSEC key management.

---

## The Resilient Two-Node Architecture

The DNS specification requires at least two separate, geographically dispersed nameservers for redundancy:

```text
       [ Administrator / Git CI/CD ]
                    │ (Edits Zone File)
                    ▼
     [ PRIMARY NAMESERVER: NS1 ]
         one.ns.ternis.net
                    │
                    │ DNS NOTIFY + AXFR/IXFR
                    ▼
    [ SECONDARY NAMESERVER: NS2 ]
         two.ns.ternis.net
```

### 1. Primary Node (NS1 — `one.ns.ternis.net`)
The primary source of truth. All zone additions, edits, and serial number updates happen here.

### 2. Secondary Node (NS2 — `two.ns.ternis.net`)
Whenever the zone file is edited on NS1, NS1 sends a **DNS NOTIFY** packet to NS2. NS2 connects back to NS1 and performs an **incremental or full zone transfer (IXFR/AXFR)** to replicate the changes.

---

## Securing Zone Transfers with TSIG

:::warn
**Never leave AXFR open to the public internet (`allow-transfer { any; };`)!** An open zone transfer allows anyone to download your entire DNS database with a single `dig axfr` command, exposing internal hostnames, staging servers, and IP topology to attackers.
:::

Secure zone transfers between NS1 and NS2 using **TSIG (Transaction Signature)** keys:

```text
// On Primary (NS1):
key "transfer-key" {
    algorithm hmac-sha256;
    secret "Kx82J...base64_secret_key...";
};

zone "ternis.org" {
    type primary;
    file "/var/lib/bind/zones/ternis.org.zone";
    notify yes;
    also-notify { 198.51.100.2; }; // NS2 IP
    allow-transfer { key "transfer-key"; };
};
```

With TSIG, every zone transfer packet is cryptographically authenticated using an HMAC-SHA256 signature, ensuring no unauthorized third party can read or spoof zone data.

---

## The open-source `example-dns` project

All ternis.org public DNS zones are managed through our open-source **example-dns** initiative:

- **Official Website**: [example-dns.com](https://example-dns.com)
- **Source Code**: [github.com/example-dns/example-dns](https://github.com/example-dns/example-dns)

Zone configurations are stored in version control, validated using automated linters on every commit, and deployed automatically to `one.ns.ternis.net` and `two.ns.ternis.net`.

---

## Verifying Authoritative Nameservers

```bash
# Query the primary server directly for zone serial number
dig @one.ns.ternis.net ternis.org SOA +short

# Query the secondary server to confirm serial numbers match
dig @two.ns.ternis.net ternis.org SOA +short
```

If both servers return the exact same SOA serial number (e.g., `2026100601`), zone synchronization is healthy.
