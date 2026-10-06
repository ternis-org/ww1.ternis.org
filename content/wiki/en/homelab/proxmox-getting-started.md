---
title: Proxmox VE Getting Started — Install to First VM
description: Install Proxmox, choose ZFS or LVM storage, and launch your first VM and LXC container.
category: homelab
order: 15
tags: [homelab, proxmox, virtualization, zfs]
updated: 2026-10-06
related: [homelab/planning-first-rack, homelab/docker-compose-homelab]
---

## Install

Flash the Proxmox VE ISO to USB, boot, and follow the wizard. Static IP on the
management interface — DHCP for a hypervisor is asking for lockout.

## Storage choice at install time

| Option | When | Notes |
|--------|------|-------|
| ZFS (mirror) | 2+ disks, data you care about | Snapshots, checksums, RAM-hungry (1GB per TB rule of thumb) |
| LVM-thin | Single SSD, VMs only | Lean, no checksums |
| ext4 + external NAS | Compute-only node | Keep bulk data on the NAS |

## First VM (Debian)

1. Datacenter → Storage → Upload the Debian netinst ISO.
2. Create VM: 2 cores, 4GB RAM, 32GB disk, bridge `vmbr0`.
3. Install, then install the guest agent: `apt install qemu-guest-agent`.

## First LXC (lightweight services)

For Docker hosts and small daemons, LXC containers beat full VMs on overhead:

```bash
pct create 100 local:vztmpl/debian-12-standard_12.0-1_amd64.tar.zst \
  --cores 2 --memory 2048 --storage local-lvm --net0 name=eth0,bridge=vmbr0,ip=dhcp
pct start 100
```

:::warn
Unprivileged containers for everything facing the network. Privileged LXC plus
a container escape equals host compromise — the hardening article in the Linux
section explains the rest.
:::
