---
title: OSI and TCP/IP Models — What Every Developer & Sysadmin Should Know
description: Practical comparison of the 7-layer OSI model and 4-layer TCP/IP model, packet encapsulation, and bottom-up network debugging techniques.
category: networking
order: 5
tags: [networking, osi, tcp-ip, troubleshooting, sysadmin, fundamentals]
updated: 2026-10-06
related: [networking/ip-subnetting-cidr, dns/a-aaaa-records, networking/reverse-proxy-basics]
---

## Why network models matter

When two computers communicate over the internet, thousands of hardware components, protocols, and software layers interact seamlessly. To design, build, and troubleshoot these systems without chaos, computer science organizes networking into **standardized layers**.

Each layer has one specific responsibility and provides services to the layer above it while ignoring the internal details of how lower layers work.

---

## OSI 7-Layer Model vs. TCP/IP 4-Layer Model

The **OSI (Open Systems Interconnection)** model is a theoretical 7-layer framework. In practice, the actual internet runs on the **TCP/IP** 4-layer model. Sysadmins and developers frequently use OSI terminology (e.g., *"Layer 4 load balancer"*, *"Layer 7 proxy"*, *"Layer 2 switch"*) to describe where tools operate:

| OSI Layer | Name | TCP/IP Layer | Protocols & Data Unit | What happens here | Real-World Tools |
|:---------:|------|:------------:|:---------------------:|-------------------|------------------|
| **7** | Application | **Application** | HTTP, DNS, SSH, SMTP | The user software and protocol format | Web browsers, Nginx, cURL |
| **6** | Presentation | (Combined) | TLS/SSL, JSON, gzip | Encryption, compression, serialization | OpenSSL, Certbot |
| **5** | Session | (Combined) | Sockets, RPC | Manages ongoing application sessions | Sockets API, gRPC |
| **4** | Transport | **Transport** | TCP, UDP *(Segment / Datagram)* | End-to-end communication, port numbers, reliability | HAProxy, iptables, `ss`, `netstat` |
| **3** | Network | **Internet** | IPv4, IPv6, ICMP *(Packet)* | Logical routing between different networks | Routers, `ping`, `traceroute`, IP routing |
| **2** | Data Link | **Network Access (Link)** | Ethernet, Wi-Fi, ARP *(Frame)* | Physical device delivery on the same local LAN (MAC addresses) | Network switches, VLANs, `arp` |
| **1** | Physical | (Combined) | Bits (0s and 1s) | Electrical signals, radio waves, light pulses | RJ45 Ethernet cables, fiber optics, SFP+ |

---

## Packet encapsulation in action

When your browser loads `https://example.com`, data is packaged like nested envelopes:

```text
[ Application Data ]                      (e.g., "GET /index.html HTTP/1.1")
        │
        ▼  Layer 4: Adds TCP Source & Destination Ports (e.g. 54321 → 443)
[ TCP Header | Application Data ]         = TCP Segment
        │
        ▼  Layer 3: Adds Source & Destination IP Addresses
[ IP Header | TCP Header | Data ]         = IP Packet
        │
        ▼  Layer 2: Adds Source & Destination MAC Addresses + Frame Check Sequence
[ Ethernet Header | IP | TCP | Data | FCS ] = Ethernet Frame
        │
        ▼  Layer 1: Modulates into electrical voltages or light pulses
 0 1 1 0 1 0 0 1 ...
```

When the packet arrives at the destination server, the reverse process (**decapsulation**) happens: each layer strips its outer header and passes the remaining payload upward.

---

## The "Bottom-Up" troubleshooting methodology

When an application fails or a server cannot connect, never guess randomly. Always diagnose bottom-up, starting from Layer 1 up to Layer 7:

```bash
# Layer 1 & 2: Is physical link active? Do we have an IP and link carrier?
ip link show eth0

# Layer 3: Can we reach our local default gateway and public internet?
ping -c 3 192.168.1.1
ping -c 3 1.1.1.1

# Layer 4: Is the target TCP port open and accepting connections?
nc -zv example.com 443

# Layer 7: Can DNS resolve and does the HTTP application respond?
dig +short example.com
curl -vI https://example.com
```

### Command & flag breakdown

- `ip link show eth0`: Checks if the network card interface is `UP` and carrier cable is detected.
- `ping -c 3 <IP>`:
  - `-c 3`: Sends exactly 3 ICMP echo request packets then stops (preventing infinite ping loops).
  - Pinging an IP directly tests Layer 3 without relying on DNS.
- `nc -zv <host> <port>` (netcat):
  - `-z`: Zero-I/O mode (scans for listening daemons without transmitting data payload).
  - `-v`: Verbose output (reports whether connection succeeded or was refused).
- `dig +short <domain>`: Queries DNS nameservers and prints only the resolved IP address.
- `curl -vI <url>`:
  - `-v`: Verbose TLS handshake and HTTP header exchange details.
  - `-I`: Issues a `HEAD` request to inspect response headers without downloading the HTML body.

:::tip
Always test IP connectivity (`ping 1.1.1.1`) before testing domain names (`ping example.com`). If IP ping succeeds but domain ping fails, you have an isolated DNS resolution problem, not a physical network outage!
:::
