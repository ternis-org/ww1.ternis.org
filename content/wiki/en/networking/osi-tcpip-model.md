---
title: OSI and TCP/IP Model — What to Actually Memorize
description: The 7 OSI layers vs the 4-layer TCP/IP model, encapsulation, and where your homelab tools sit.
category: networking
order: 5
tags: [networking, osi, tcp-ip, fundamentals]
updated: 2026-10-06
related: [networking/ip-subnetting-cidr, dns/a-aaaa-records]
---

## The two models side by side

| OSI (7) | TCP/IP (4) | Example at that layer |
|---------|-----------|----------------------|
| 7 Application | Application | HTTP, DNS, SSH |
| 6 Presentation | Application | TLS, JSON encoding |
| 5 Session | Application | TCP sessions, WireGuard tunnels |
| 4 Transport | Transport | TCP, UDP, ports |
| 3 Network | Internet | IP, routing, ICMP ping |
| 2 Data Link | Link | Ethernet, MAC, VLAN tags |
| 1 Physical | Link | Cables, SFP modules, Wi-Fi radio |

In practice everyone uses TCP/IP's 4 layers; OSI survives as vocabulary
("that's a layer 2 problem" = switching/VLANs, "layer 7" = the app itself).

## Encapsulation in one sentence

Each layer wraps the previous payload with its own header: Ethernet frame →
IP packet → TCP segment → TLS → HTTP. `tcpdump` shows you the outer layers,
Wireshark unwraps all of them.

## Debugging bottom-up

```bash
ping 1.1.1.1        # layer 3 alive?
ping example.com    # + DNS (layer 7) working?
curl -v https://example.com  # TLS + HTTP details
```

:::tip
"Check layer 1 first" is a cliché because it keeps being true: half of all
homelab network outages are a loose cable, a dead switch port, or PoE that
never came back after a power cut.
:::
