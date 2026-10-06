---
title: Proxmox VE einrichten — Von der Installation zur ersten VM
description: Proxmox installieren, ZFS- oder LVM-Speicher wählen und erste VM sowie LXC-Container starten.
category: homelab
order: 15
tags: [homelab, proxmox, virtualisierung, zfs]
updated: 2026-10-06
related: [homelab/planning-first-rack, homelab/docker-compose-homelab]
---

## Installieren

Proxmox-VE-ISO auf USB schreiben, booten, dem Assistenten folgen. Statische IP
für das Management-Interface — DHCP für einen Hypervisor endet im Lockout.

## Speicherwahl bei der Installation

| Option | Wann | Hinweis |
|--------|------|---------|
| ZFS (Mirror) | 2+ Platten, wichtige Daten | Snapshots, Checksummen, RAM-hungrig (ca. 1GB pro TB) |
| LVM-thin | Einzelne SSD, nur VMs | Schlank, keine Checksummen |
| ext4 + externes NAS | Reiner Compute-Knoten | Massendaten liegen auf dem NAS |

## Erste VM (Debian)

1. Datacenter → Storage → Debian-netinst-ISO hochladen.
2. VM erstellen: 2 Kerne, 4GB RAM, 32GB Platte, Bridge `vmbr0`.
3. Installieren, dann Guest-Agent dazu: `apt install qemu-guest-agent`.

## Erster LXC (schlanke Dienste)

Für Docker-Hosts und kleine Daemons schlagen LXC-Container jede VM beim Overhead:

```bash
pct create 100 local:vztmpl/debian-12-standard_12.0-1_amd64.tar.zst \
  --cores 2 --memory 2048 --storage local-lvm --net0 name=eth0,bridge=vmbr0,ip=dhcp
pct start 100
```

:::warn
Unprivilegierte Container für alles mit Netzseite. Privilegiertes LXC plus
Container-Escape bedeutet Host-Kompromittierung.
:::
