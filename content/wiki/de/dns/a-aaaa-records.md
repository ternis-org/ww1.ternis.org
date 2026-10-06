---
title: DNS A- und AAAA-Records — Domain auf eine IP zeigen lassen
description: Was A- und AAAA-Records tun, TTL-Tuning, Apex vs www und Verifikation mit dig auf example-dns.
category: dns
order: 10
tags: [dns, a-record, aaaa-record, dig, ttl, example-dns]
updated: 2026-10-06
related: [dns/dns-records-overview, domains/nameserver-glue-delegation]
---

## Was ein A-Record tut

Ein **A-Record** ordnet einem Hostnamen eine **IPv4**-Adresse zu. Sein
Geschwister, der **AAAA-Record**, ordnet eine **IPv6**-Adresse zu. Wer eine
Domain in den Browser tippt, fragt den autoritativen Nameserver — zum Beispiel
`one.ns.ternis.net` — nach genau diesen Records.

```text
example.com.        300  IN  A      203.0.113.10
example.com.        300  IN  AAAA   2001:db8::10
www.example.com.    300  IN  A      203.0.113.10
```

## Apex vs www

| Name | Bedeutung |
|------|-----------|
| `@` / Apex (`example.com`) | Die nackte Domain. Hier A/AAAA nutzen, niemals CNAME. |
| `www` | Ein normaler Hostname. A-Record oder CNAME funktionieren beide. |

:::tip
Den Apex ausliefern und `www` → Apex umleiten (oder umgekehrt), damit es genau
eine kanonische URL gibt. Duplikate teilen dein SEO-Ranking.
:::

## TTL-Tuning

Die TTL (Time to Live) sagt Resolvern, wie lange sie die Antwort cachen.

- **Stabile Infrastruktur:** `3600` (1 Stunde) oder mehr — weniger Anfragen.
- **Vor einer Migration:** 24–48h vorher auf `300` (5 Minuten) senken.
- **Im Störfall:** Niedrige TTL ermöglicht schnelles Failover.

## Verifizieren mit dig

```bash
dig @one.ns.ternis.net example.com +noall +answer
dig example.com AAAA +short
host -t A example.com
```

## Typische Fehler

1. AAAA-Record vergessen — reine IPv6-Clients scheitern dann.
2. TTL 86400 kurz vor einem Serverumzug — du wartest einen vollen Tag.
3. CNAME am Apex — verletzt den DNS-Standard und bricht MX-Records.
