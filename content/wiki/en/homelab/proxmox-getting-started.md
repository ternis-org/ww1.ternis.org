---
title: Proxmox VE Getting Started — Installation, Storage, VMs, and LXC
description: Complete beginner guide to Proxmox VE bare-metal virtualization, ZFS vs LVM storage, launching KVM virtual machines, and managing LXC containers via CLI.
category: homelab
order: 15
tags: [homelab, proxmox, virtualization, kvm, lxc, zfs, sysadmin]
updated: 2026-10-06
related: [homelab/planning-first-rack, homelab/docker-compose-homelab, linux/systemd-services-timers]
---

## What is Proxmox Virtual Environment (PVE)?

**Proxmox VE** is an open-source, enterprise-grade **Type-1 (bare-metal) hypervisor**. Unlike software like VirtualBox or VMware Workstation that runs on top of a desktop OS, Proxmox installs directly onto your server hardware, combining a Debian Linux core with:
1. **KVM (Kernel-based Virtual Machine)**: Full hardware virtualization for running Linux, Windows, BSD, or TrueNAS.
2. **LXC (Linux Containers)**: Lightweight container virtualization sharing the host kernel for minimal CPU and RAM overhead.
3. **Web-based Management GUI**: A web dashboard on port `8006` to monitor resources, manage disks, take snapshots, and cluster nodes.

---

## Step 1: Installation & Initial Access

1. Download the official Proxmox VE ISO from proxmox.com and flash it to a USB drive with BalenaEtcher or Ventoy.
2. Boot your server from the USB drive and run the installer.
3. **Crucial Network Setting**: Always assign a **static IP address** (e.g. `192.168.1.100/24`) and your router gateway (`192.168.1.1`). Never use DHCP on a hypervisor; if the IP changes, you will lose web access.
4. Once installation completes and the server reboots, connect to the web interface from any computer on your network:
   `https://192.168.1.100:8006`
   *(Accept the self-signed TLS warning, then log in as `root` with the password set during installation).*

---

## Step 2: Choosing your Storage Backend

During installation, Proxmox asks for your target filesystem:

| Storage Type | Disk Count | Key Strengths | Considerations |
|--------------|:----------:|---------------|----------------|
| **ZFS (RAID 1 / Mirror)** | 2+ disks | Self-healing bit-rot protection, instant copy-on-write snapshots, compression. | Consumes more RAM (~1GB RAM per 1TB storage recommended). |
| **LVM-Thin** | 1 SSD | Extremely fast, supports VM snapshots, low RAM usage. | No bit-rot detection or checksums. |
| **ext4** | 1 drive | Standard simple Linux filesystem. | Does not support live VM snapshots out of the box. |

:::tip
For a single-drive mini PC, **LVM-Thin** is ideal. For a multi-drive desktop or server where data redundancy matters, choose **ZFS RAID 1 (Mirror)**.
:::

---

## Step 3: VMs vs. LXC Containers — Which to use?

- **Virtual Machine (KVM)**: Emulates a complete virtual computer with virtual BIOS, virtual CPU, and virtual devices. Use VMs when you need:
  - Windows or FreeBSD/TrueNAS.
  - Complete kernel isolation.
  - Custom kernel modules or Docker with complex storage drivers.
- **LXC (Linux Container)**: Shares the host Linux kernel directly. Starts in 1 second and consumes virtually zero idle RAM (often under 30MB). Use LXC for:
  - Small Linux services (Pi-hole, reverse proxies, WireGuard, lightweight web apps).

:::warn
**Always use Unprivileged LXC containers for network-facing apps!** In an unprivileged container, root inside the container maps to an unprivileged UID (e.g. `100000`) on the host. If a service is compromised, the attacker cannot break out and gain root on the Proxmox host.
:::

---

## Step 4: Managing LXC Containers from the CLI

While the web GUI is intuitive, sysadmins often manage containers from the terminal using `pct` (Proxmox Container Toolkit):

```bash
# 1. Download a Debian 12 container template
pveam update
pveam download local debian-12-standard_12.7-1_amd64.tar.zst

# 2. Create an unprivileged container (ID 100)
pct create 100 local:vztmpl/debian-12-standard_12.7-1_amd64.tar.zst \
  --hostname webserver \
  --cores 2 \
  --memory 2048 \
  --swap 512 \
  --rootfs local-lvm:16 \
  --net0 name=eth0,bridge=vmbr0,ip=dhcp \
  --unprivileged 1

# 3. Start the container
pct start 100

# 4. Open a root shell inside the container
pct enter 100
```

### Command & flag breakdown

- `pct create 100`: Creates a new container assigned numeric ID `100`.
- `--hostname webserver`: Sets the internal container hostname.
- `--cores 2`: Grants the container access to 2 virtual CPU cores.
- `--memory 2048`: Allocates 2048 MB (2 GB) of RAM.
- `--rootfs local-lvm:16`: Provisions a 16 GB root disk on the `local-lvm` storage pool.
- `--net0 name=eth0,bridge=vmbr0,ip=dhcp`: Connects virtual interface `eth0` to the default Proxmox network bridge `vmbr0` using DHCP.
- `--unprivileged 1`: Enforces UID namespace isolation for security.
- `pct enter 100`: Drops you directly into an interactive root terminal session inside container 100 without needing SSH.

---

## VM Essential: Install the QEMU Guest Agent

Whenever you install a Linux VM (like Debian or Ubuntu) inside Proxmox, always install the guest agent:

```bash
# Inside your VM guest operating system:
sudo apt update
sudo apt install -y qemu-guest-agent
sudo systemctl enable --now qemu-guest-agent
```

This communicates with Proxmox, allowing the web GUI to display the VM's real IP address, sync time, and safely trigger graceful ACPI OS shutdowns during backups.
