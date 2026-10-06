---
title: IP Subnetting and CIDR in 10 Minutes — A Practical Guide
description: Complete beginner guide to IPv4 addresses, CIDR prefix notation, calculating usable hosts, subnet masks, RFC 1918 private ranges, and CLI tools.
category: networking
order: 10
tags: [networking, subnetting, cidr, ip, ipv4, sysadmin, beginner]
updated: 2026-10-06
related: [dns/a-aaaa-records, networking/nat-port-forwarding, networking/osi-tcpip-model]
---

## Understanding IPv4 Addresses

Every device connected to an IP network needs an IP address. An **IPv4 address** is a 32-bit binary number, represented in human-readable dotted-decimal notation as 4 octets separated by dots:

```text
192  .   168  .    1   .   42
  │        │       │       │
8 bits   8 bits  8 bits  8 bits  =  32 bits total
```
Each octet can range from `0` (`00000000` in binary) to `255` (`11111111` in binary).

An IP address always consists of two parts:
1. **Network identifier**: Identifies which network or subnet the device belongs to.
2. **Host identifier**: Identifies the specific device (computer, phone, printer) on that network.

---

## What is CIDR notation?

**CIDR (Classless Inter-Domain Routing)** specifies how many bits belong to the network identifier using a slash followed by a prefix number (e.g. `/24`).

The remaining bits belong to host devices:

$$\text{Host Bits} = 32 - \text{Prefix Length}$$

The formula for total IP addresses in any subnet is:

$$\text{Total Addresses} = 2^{(32 - \text{Prefix})}$$

Because two addresses are reserved by networking standards:
1. **Network Address** (all host bits 0): Represents the subnet itself.
2. **Broadcast Address** (all host bits 1): Sends packets to all devices on the subnet simultaneously.

The formula for **usable hosts** is:

$$\text{Usable Hosts} = 2^{(32 - \text{Prefix})} - 2$$

---

## CIDR Cheat Sheet

| CIDR Prefix | Subnet Mask | Total IPs | Usable Hosts | Typical Real-World Use Case |
|:-----------:|-------------|:---------:|:------------:|-----------------------------|
| **`/32`** | 255.255.255.255 | 1 | 1 | Single host route / firewall rule |
| **`/30`** | 255.255.255.252 | 4 | 2 | Point-to-point router-to-router links |
| **`/29`** | 255.255.255.248 | 8 | 6 | Small static IP block from ISP |
| **`/28`** | 255.255.255.240 | 16 | 14 | Small DMZ or homelab VLAN |
| **`/24`** | 255.255.255.0 | 256 | **254** | Standard home LAN / office subnet |
| **`/16`** | 255.255.0.0 | 65,536 | 65,534 | Large corporate campus / Cloud VPC |
| **`/8`** | 255.0.0.0 | 16,777,216 | 16,777,214 | Massive enterprise network |

---

## Step-by-step example: Analyzing `192.168.1.0/24`

Let's break down the most common home network subnet:
- **Prefix length**: `/24` (first 24 bits are fixed as network `192.168.1`).
- **Host bits**: $32 - 24 = 8$ bits.
- **Total addresses**: $2^8 = 256$.
- **Usable host addresses**: $256 - 2 = 254$.

Specific addresses:
- **Network ID**: `192.168.1.0` (cannot be assigned to a device).
- **First usable host**: `192.168.1.1` (commonly assigned to the default gateway / router).
- **Last usable host**: `192.168.1.254`.
- **Broadcast address**: `192.168.1.255` (used for LAN broadcast packets).

---

## Private IP ranges (RFC 1918)

To conserve public IPv4 addresses, the Internet Engineering Task Force reserved three private address blocks that are **never routed over the public internet**:

| RFC 1918 Block | Address Range | Total Available IPs |
|----------------|---------------|:-------------------:|
| `10.0.0.0/8` | `10.0.0.0` – `10.255.255.255` | 16.7 Million |
| `172.16.0.0/12`| `172.16.0.0` – `172.31.255.255` | 1.04 Million (default Docker range) |
| `192.168.0.0/16`| `192.168.0.0` – `192.168.255.255` | 65,536 (home Wi-Fi routers) |

Any traffic destined for these addresses is dropped by internet service provider routers. To access the public internet, a home router uses **NAT (Network Address Translation)**.

---

## Practical CLI inspection tools

```bash
# View IP addresses assigned to local network interfaces
ip -brief addr show

# View routing table and default gateway
ip route show

# Calculate subnets instantly using the ipcalc utility
sudo apt install -y ipcalc
ipcalc 192.168.1.0/24
```

### Command & flag breakdown

- `ip -brief addr show`: Shows an uncluttered list of network interfaces (`eth0`, `wlan0`), their UP/DOWN status, and assigned IPv4/IPv6 CIDR addresses.
- `ip route show`: Reveals the default gateway (e.g. `default via 192.168.1.1 dev eth0`).
- `ipcalc <CIDR>`: Computes netmask, wildcard bits, network address, min/max usable hosts, and broadcast address instantly without manual arithmetic.
