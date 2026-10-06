---
title: NAT and Port Forwarding on Home Routers
description: SNAT, DNAT, hairpin NAT, and forwarding services safely from behind a FritzBox or OPNsense.
category: networking
order: 15
tags: [networking, nat, port-forwarding, homelab]
updated: 2026-10-06
related: [networking/ip-subnetting-cidr, selfhosting/nginx-reverse-proxy-tls]
---

## What NAT does

**SNAT** (masquerading) rewrites your private IPs to the router's public IP on
the way out — this is why a whole LAN shares one address. **DNAT** (port
forwarding) maps an inbound public port to an internal host:port.

## Forwarding a service

```text
WAN :443  →  192.168.1.10:443   (reverse proxy)
WAN :51820 (UDP) → 192.168.1.10:51820  (WireGuard)
```

Rules: forward as few ports as possible, never forward database or admin-panel
ports, and prefer a VPN (one UDP port) over exposing every service.

## Hairpin NAT

Without **hairpinning** (NAT loopback), your public domain fails from *inside*
your own LAN even though it works externally. Symptoms: "works on mobile data,
broken on Wi-Fi." Fix: enable hairpin/NAT reflection on the router, or run
split-horizon DNS that resolves the domain to the internal IP locally.

## Carrier-grade NAT trap

If your ISP puts you behind **CGNAT** (common on LTE/5G and some fiber), inbound
port forwarding is impossible — you share the public IP with strangers. Escape
hatches: ask for a public IP, or use a VPS relay / Tailscale / Cloudflare Tunnel
instead of direct forwards.

:::warn
Every forwarded port is scanned within minutes of opening. Put authentication
(and ideally a VPN) in front of anything forwarded — an open port with a
default password is a breach waiting for a schedule.
:::
