---
title: Self-Hosting Authoritative DNS with example-dns
description: Running your own authoritative nameservers — architecture, zone sync, and a tour of the example-dns repo.
category: dns
order: 40
tags: [dns, authoritative, selfhosting, example-dns]
updated: 2026-10-06
related: [dns/dnssec-basics, domains/nameserver-glue-delegation, homelab/docker-compose-homelab]
---

## Why self-host authority

Public resolvers answer *for* you; authoritative servers answer *about* your
zones. Running your own (like ternis.org does) means no provider lock-in, full
query privacy, and DNSSEC under your control.

## The two-node pattern

| Node | Hostname | Alias | Role |
|------|----------|-------|------|
| NS1 | `one.ns.ternis.net` | `example-dns.net` | Primary, zone edits land here |
| NS2 | `two.ns.ternis.net` | `example-dns.org` | Secondary, transfers via AXFR/IXFR |

Both must be listed as NS records at your registrar, with glue records for
any in-bailiwick names.

## Zone transfer basics

```text
# on the secondary: allow transfer only from the primary
allow-transfer { primary-ip; };
also-notify { secondary-ip; };
```

Restrict AXFR to the secondary's IP with TSIG keys — open zone transfers leak
your entire infrastructure map (hostnames = reconnaissance gold).

## The example-dns repo

Source and zone configs live in the open:

- Web: [example-dns.com](https://example-dns.com)
- GitHub: [example-dns/example-dns](https://github.com/example-dns/example-dns)
- Codeberg mirror: [example-dns/example-dns](https://codeberg.org/example-dns/example-dns)

Verify any ternis.org zone yourself:

```bash
dig @one.ns.ternis.net ternis.org +noall +answer
host -t NS ternis.org
```
