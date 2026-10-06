---
title: Planning Your First Rack — Power, Noise, Network
description: Budget ladder, UPS sizing, noise control, and the network drops to install before you need them.
category: homelab
order: 5
tags: [homelab, planning, rack, ups]
updated: 2026-10-06
related: [homelab/proxmox-getting-started, homelab/docker-compose-homelab]
---

## The budget ladder

| Stage | Spend | Gets you |
|-------|-------|----------|
| 1. Spare hardware | €0 | Old laptop + Docker, learn the patterns |
| 2. Mini PC | €150–300 | Silent N100 node, 10W idle |
| 3. Real server | €500+ | Used enterprise gear, ECC, IPMI |
| 4. Rack | €1000+ | Patch panel, UPS, managed switch |

Start at stage 1 or 2. Expensive hardware never fixed a missing backup strategy.

## Power and UPS

Measure first: a Kill-a-Watt (€20) beats all guessing. Size the UPS for
**graceful shutdown**, not uptime — 10 minutes at your measured load plus an
automated shutdown script (NUT + Proxmox integrates in minutes).

## Noise and placement

Enterprise 1U servers scream at 60+ dB — unsuitable for living spaces. Quiet
options: mini PCs, tower servers with Noctua fan swaps, or a closed 12U cabinet
in the basement. Decide placement *before* buying, not after the first night.

## Network drops to install now

Run two CAT6A cables to every room you might ever serve, terminated at a patch
panel. Cable is cheap; opening walls twice is not. Add one drop near the
electricity meter for the future smart-home gateway.

:::tip
Label both ends of every cable on day one. Future-you, debugging at midnight,
will be grateful.
:::
