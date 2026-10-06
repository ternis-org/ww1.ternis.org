---
title: IP Subnetting and CIDR in 10 Minutes
description: CIDR notation, subnet masks, usable hosts, and a cheat sheet you can memorize.
category: networking
order: 10
tags: [networking, subnetting, cidr, ip]
updated: 2026-10-06
related: [dns/a-aaaa-records]
---

## CIDR notation

`/24` means the first 24 bits are the network. Bigger number = smaller network.

| CIDR | Mask | Usable hosts |
|------|------|--------------|
| `/24` | 255.255.255.0 | 254 |
| `/16` | 255.255.0.0 | 65,534 |
| `/30` | 255.255.255.252 | 2 (point-to-point links) |
| `/32` | single host | 1 |

## The formula

Usable hosts = `2^(32 - prefix) - 2` (minus network + broadcast address).

```bash
# What range is 192.168.1.0/24?
# Network:   192.168.1.0
# First usable: 192.168.1.1
# Last usable:  192.168.1.254
# Broadcast: 192.168.1.255
```

## Private ranges (RFC 1918)

- `10.0.0.0/8` — giant homelabs
- `172.16.0.0/12` — Docker's favorite
- `192.168.0.0/16` — home routers

:::tip
Give infrastructure static leases outside the DHCP pool (e.g. `.2–.49`
static, `.100–.250` DHCP) so printers and servers never collide.
:::
