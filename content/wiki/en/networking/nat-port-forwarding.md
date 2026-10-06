---
title: NAT and Port Forwarding — A Beginner's Guide to Router Networking
description: Understand SNAT, DNAT (Port Forwarding), Hairpin NAT loopback, avoiding CGNAT traps, and safely hosting services from a home or office network.
category: networking
order: 15
tags: [networking, nat, port-forwarding, homelab, router, firewall]
updated: 2026-10-06
related: [networking/ip-subnetting-cidr, networking/reverse-proxy-basics, selfhosting/nginx-reverse-proxy-tls]
---

## What is NAT (Network Address Translation)?

When IPv4 was designed, 4.3 billion total IP addresses seemed like an infinite quantity. By the late 1990s, the global explosion of internet devices rapidly threatened to exhaust this pool.

**NAT (Network Address Translation)** solves this shortage by allowing an entire local area network (LAN) containing dozens of laptops, phones, and smart devices with private IP addresses (such as `192.168.1.0/24`) to share a **single public IPv4 address** provided by your Internet Service Provider (ISP).

---

## The two types of NAT

```text
[ Private LAN: 192.168.1.42 ]
          │ (Internal Request)
          ▼
   [ HOME ROUTER ]
   WAN IP: 203.0.113.19 (Public)
          │ (SNAT Masquerade Outbound / DNAT Port Forward Inbound)
          ▼
   [ PUBLIC INTERNET ]
```

### 1. Source NAT (SNAT / Masquerading) — Outbound Traffic

When your laptop (`192.168.1.42`) visits a website:
1. Your router intercepts the packet.
2. It replaces the source IP (`192.168.1.42`) with the router's public WAN IP (`203.0.113.19`).
3. It remembers this translation in a **state table** (tracking source port numbers).
4. When the website replies, the router checks its state table and delivers the response back to your laptop.

### 2. Destination NAT (DNAT / Port Forwarding) — Inbound Traffic

When an outside internet visitor connects to your public WAN IP, your router does not know which device on your home network should receive the packet, because the connection did not originate from the inside.

**Port forwarding** (DNAT) creates an explicit rule instructing the router:
*"When an incoming connection arrives on WAN port $X$, forward it to internal IP $Y$ on port $Z$."*

```text
Incoming WAN :443 (HTTPS)  ──►  Forward to 192.168.1.10 :443 (Reverse Proxy)
Incoming WAN :51820 (UDP)  ──►  Forward to 192.168.1.10 :51820 (WireGuard VPN)
```

---

## Port forwarding safety hygiene

Opening ports to the public internet means automated bots will begin scanning that port within minutes:

1. **Never forward database ports**: Never expose ports `3306` (MySQL), `5432` (PostgreSQL), or `6379` (Redis) to the internet. Keep databases strictly internal.
2. **Never expose router admin consoles**: Remote management on port 80/443 of your router is a critical security vulnerability.
3. **Prefer a single VPN tunnel over many ports**: Instead of forwarding 10 different ports for 10 internal services, forward **one single UDP port** for WireGuard or Tailscale, connect your phone/laptop to the VPN, and access your home services privately.
4. **Use a Reverse Proxy**: If hosting public web services, forward only port 80 and 443 to a hardened reverse proxy (Caddy or Nginx) rather than exposing backend app ports directly.

---

## The "Hairpin NAT" problem (NAT Loopback)

Have you ever encountered this frustrating bug?
> *"My self-hosted website loads perfectly when I test it on my mobile phone using 5G cell data, but when I connect my phone to my home Wi-Fi, the website fails to load!"*

This is the **Hairpin NAT** (or NAT Reflection) issue:
- From inside your LAN, your computer queries DNS for `myservice.example.com` and receives your public WAN IP (`203.0.113.19`).
- Your computer sends packets to `203.0.113.19`.
- Without hairpin NAT support, the router receives packets from the LAN interface aimed at its own external WAN interface and drops them.

### Solutions:
1. **Enable NAT Loopback / Hairpin NAT** in your router settings (enabled by default on Fritz!Box, pfSense, OPNsense, and UniFi).
2. **Split-Horizon DNS**: Run an internal DNS resolver (Pi-hole, AdGuard Home, or Unbound) that resolves `myservice.example.com` directly to `192.168.1.10` when queried from inside your home network.

---

## The Carrier-Grade NAT (CGNAT) roadblock

Many fiber, cellular (LTE/5G), and cable ISPs use **CGNAT (RFC 6598)**. Under CGNAT, your ISP does not assign you a real public IPv4 address. Instead, they place you behind another layer of ISP-level NAT.

### How to check for CGNAT:
Look at your router's WAN IP address. If it begins with:
`100.64.0.0` through `100.127.255.255` (the `100.64.0.0/10` block), you are behind CGNAT.

Under CGNAT, traditional port forwarding is **impossible** because you do not have a dedicated public IP address.

### Workarounds for CGNAT:
- **Request a public IPv4 address** from your ISP (some ISPs provide this free or for a small monthly fee).
- **Use IPv6**: If your ISP provides an IPv6 `/64` prefix, each device on your home network has a globally unique public IPv6 address.
- **Use an outbound reverse tunnel**: Services like **Cloudflare Tunnels**, **Tailscale Funnel**, or a $3/month cloud VPS running a WireGuard relay connect outbound from your home network to bypass CGNAT completely.
