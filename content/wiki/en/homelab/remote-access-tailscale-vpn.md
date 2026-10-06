---
title: Remote Access — Tailscale and WireGuard vs Port Forwarding
description: Reaching the homelab from outside without exposing services: mesh VPNs compared.
category: homelab
order: 20
tags: [homelab, vpn, tailscale, wireguard, remote-access]
updated: 2026-10-06
related: [homelab/docker-compose-homelab, networking/nat-port-forwarding]
---

## The ranking

1. **Mesh VPN (Tailscale/Headscale)** — zero open ports, NAT traversal built in.
2. **WireGuard on one UDP port** — one forward, modern crypto, fast.
3. **Port forwarding each service** — last resort; every port gets probed daily.

## Tailscale in five minutes

```bash
curl -fsSL https://tailscale.com/install.sh | sh
sudo tailscale up
```

Your nodes get stable `100.x.y.z` addresses reachable from anywhere — including
behind CGNAT, where port forwarding is impossible. Enable `tailscale serve` to
expose a single service to the tailnet without any firewall changes.

## Self-hosted control plane

If Tailscale's account-based control plane bothers you, **Headscale** is the
open-source coordination server speaking the same protocol. Same clients,
your keys, your server.

## When WireGuard directly

For site-to-site (homelab ↔ VPS) or maximum control, plain WireGuard wins:

```ini
[Interface]
PrivateKey = <node-private-key>
Address = 10.9.0.1/24
ListenPort = 51820

[Peer]
PublicKey = <peer-public-key>
AllowedIPs = 10.9.0.2/32
```

:::tip
Keep SSH off the public internet entirely: bind it to the VPN interface only
(`ListenAddress 100.x.y.z`). The entire internet then cannot even attempt a
login.
:::
