---
title: Proxmox VE Erste Schritte — Installation, Storage, VMs und LXC
description: Einsteigerfreundlicher Leitfaden zu Proxmox VE Bare-Metal-Virtualisierung, ZFS vs. LVM, Erstellung virtueller KVM-Maschinen und Verwaltung von LXC-Containern per CLI.
category: homelab
order: 15
tags: [homelab, proxmox, virtualisierung, kvm, lxc, zfs, sysadmin]
updated: 2026-10-06
related: [homelab/planning-first-rack, homelab/docker-compose-homelab, linux/systemd-services-timers]
---

## Was ist Proxmox Virtual Environment (PVE)?

**Proxmox VE** ist ein quelloffener **Type-1 (Bare-Metal) Hypervisor** auf Basis von Debian Linux. Im Gegensatz zu Desktop-Virtualisierern (wie VirtualBox) wird Proxmox direkt auf der Hardware des Servers installiert und bietet:
1. **KVM (Kernel-based Virtual Machine)**: Vollständige Hardware-Virtualisierung für Linux, Windows, BSD und TrueNAS.
2. **LXC (Linux Containers)**: Schlanke Container, die sich den Host-Kernel teilen und fast keinen RAM-Overhead erzeugen.
3. **Web-Management-GUI**: Verwaltungsoberfläche im Browser auf Port `8006`.

---

## 1. Installation und Zugriff

1. Proxmox VE ISO auf einen USB-Stick schreiben und den Server damit starten.
2. Im Installationsassistenten zwingend eine **statische IP-Adresse** vergeben (z. B. `192.168.1.100/24`) mit dem Standard-Gateway deines Routers (`192.168.1.1`). Niemals DHCP für Hypervisor verwenden!
3. Nach dem Neustart im Browser die Weboberfläche aufrufen:
   `https://192.168.1.100:8006`
   *(Login als `root` mit dem bei der Installation gewählten Passwort).*

---

## 2. Storage-Wahl bei der Installation

| Storage-Typ | Festplatten | Vorteile | Besonderheiten |
|-------------|:-----------:|----------|----------------|
| **ZFS (Mirror / RAID 1)** | Ab 2 Disks | Selbstheilender Schutz vor Bit-Rot, blitzschnelle Snapshots, Kompression. | Benötigt mehr RAM (Faustregel: 1 GB RAM pro 1 TB Speicher). |
| **LVM-Thin** | 1 SSD | Sehr schnell, unterstützt VM-Snapshots, schlank. | Keine Prüfsummen oder Bit-Rot-Korrektur. |
| **ext4** | 1 Festplatte | Standard-Linux-Dateisystem. | Keine nativen Live-Snapshots für VMs. |

---

## 3. VMs vs. LXC-Container

- **Virtuelle Maschine (KVM)**: Emuliert einen kompletten Computer inklusive virtuellem BIOS. Ideal für Windows, pfSense/OPNsense oder wenn strikte Kernel-Isolation erforderlich ist.
- **LXC-Container**: Teilt sich den Linux-Kernel mit Proxmox. Startet in 1 Sekunde und verbraucht im Leerlauf oft unter 30 MB RAM.

:::warn
Verwende für alle Dienste mit Netzwerkzugriff **Unprivileged (unberechtigte) LXC-Container** (`--unprivileged 1`). Dadurch wird der Root-Benutzer im Container auf eine unprivilegierte UID auf dem Host abgebildet.
:::

---

## 4. LXC-Container per CLI verwalten mit `pct`

```bash
# 1. Debian-Template herunterladen
pveam update
pveam download local debian-12-standard_12.7-1_amd64.tar.zst

# 2. Unprivileged Container (ID 100) anlegen
pct create 100 local:vztmpl/debian-12-standard_12.7-1_amd64.tar.zst \
  --hostname webserver \
  --cores 2 \
  --memory 2048 \
  --rootfs local-lvm:16 \
  --net0 name=eth0,bridge=vmbr0,ip=dhcp \
  --unprivileged 1

# 3. Container starten
pct start 100

# 4. Direkt ins Terminal des Containers springen
pct enter 100
```

### Erklärung der Flags

- `pct create 100`: Erstellt Container mit der ID 100.
- `--cores 2`: Weist 2 virtuelle CPU-Kerne zu.
- `--memory 2048`: Weist 2 GB RAM zu.
- `--rootfs local-lvm:16`: Erstellt eine 16 GB Festplatte auf dem LVM-Storage.
- `--unprivileged 1`: Aktiviert die sichere Benutzer-Isolation.
- `pct enter 100`: Öffnet sofort eine interaktive Root-Shell im Container.

---

## Wichtig für Linux-VMs: QEMU Guest Agent installieren

Installiere in jeder virtuellen Maschine den Gast-Agenten:

```bash
sudo apt update && sudo apt install -y qemu-guest-agent
sudo systemctl enable --now qemu-guest-agent
```

Dadurch zeigt Proxmox die IP-Adresse der VM in der Weboberfläche an und kann die Maschine bei Backups sauber und ohne Datenverlust herunterfahren.
