---
title: DNS-Debugging mit dig, host und nslookup
description: Auflösung mit +trace verfolgen, negative Antworten lesen und die fünf Befehle für 90 % aller DNS-Probleme.
category: dns
order: 35
tags: [dns, dig, host, debugging]
updated: 2026-10-06
related: [dns/a-aaaa-records, dns/txt-spf-dkim-dmarc]
---

## Einen bestimmten Server fragen

Gecachte Resolver umgehen und direkt die Authority befragen:

```bash
dig @one.ns.ternis.net example.com +noall +answer
host -t NS example.com one.ns.ternis.net
```

## Die komplette Kette verfolgen

```bash
dig example.com +trace
```

Das läuft Root → TLD → autoritative Server ab. Der Hop, an dem die Spur
stirbt, ist das Problem (meist ein fehlender Glue-Record oder falsches NS-Set).

## Negative Antworten lesen

```bash
dig nichtexistent.example.com
```

- `NXDOMAIN` — Name existiert nicht. Schreibweise und Zoneninhalt prüfen.
- `NOERROR` ohne Antworten — Name existiert, hat aber keine Records dieses
  Typs (z. B. AAAA angefragt, nur A vorhanden).
- `SERVFAIL` — oft DNSSEC-Validierungsfehler oder lahme Delegierung.

## TTL- und Cache-Prüfung

```bash
dig example.com +noall +answer   # herunterzählende TTL = gecacht
dig +short example.com
```

:::tip
Wenn „bei mir geht's, bei anderen nicht": `dig @8.8.8.8` vs `dig @1.1.1.1` vs
autoritativer Server vergleichen. Unterschiedliche gecachte TTLs erklären die
Abweichung fast immer.
:::
