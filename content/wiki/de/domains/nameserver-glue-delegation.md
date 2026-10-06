---
title: Nameserver-Delegierung und Glue Records — Das Henne-Ei-Problem im DNS
description: Ausführliche Einsteiger-Erklärung zu DNS-Zonendelegierung, In-Bailiwick-Nameservern, Glue Records und der Behebung von Lame Delegations.
category: domains
order: 35
tags: [domains, nameserver, glue, delegation, dns, sysadmin]
updated: 2026-10-06
related: [domains/how-domains-work, dns/selfhost-authoritative-dns, dns/debugging-dig-host-nslookup]
---

## Was bedeutet DNS-Delegierung?

Das Domain Name System (DNS) ist als hierarchischer Baum organisiert. Kein einzelner Server weltweit speichert alle Domainnamen.

Stattdessen wird die Zuständigkeit schrittweise **delegiert**:
1. Die **Root-Zone (`.`)** delegiert `.org` an die Nameserver der `.org`-Registry.
2. Die **`.org`-Registry-Zone** delegiert `ternis.org` an unsere autoritativen Nameserver (`one.ns.ternis.net` und `two.ns.ternis.net`), indem sie **NS-Einträge** veröffentlicht:

```text
; In der übergeordneten .org-Zone:
ternis.org.   IN  NS  one.ns.ternis.net.
ternis.org.   IN  NS  two.ns.ternis.net.
```

---

## Das Henne-Ei-Problem: In-Bailiwick-Nameserver

Angenommen, du betreibst deine eigene Domain **`meinedomain.de`** und möchtest eigene Nameserver unter folgenden Namen einsetzen:
`ns1.meinedomain.de` und `ns2.meinedomain.de`.

Ein weltweiter DNS-Resolver möchte `meinedomain.de` auflösen:
1. Er fragt die `.de`-Registry: *"Wer verwaltet `meinedomain.de`?"*
2. Die Registry antwortet: *"Frage `ns1.meinedomain.de`."*
3. Der Resolver muss nun die IP von `ns1.meinedomain.de` herausfinden.
4. Dafür müsste er den Nameserver von `meinedomain.de` befragen — was aber genau `ns1.meinedomain.de` ist!

Diese Endlosschleife ist unlösbar, weil der Nameserver innerhalb der Domain liegt, für die er zuständig ist (**In-Bailiwick**).

---

## Die Lösung: Glue Records ("Klebedatensätze")

Um diese Schleife aufzulösen, hinterlegt man bei der übergeordneten Registry sogenannte **Glue Records**:
Dabei werden die IP-Adressen (IPv4 `A` und IPv6 `AAAA`) der Nameserver **direkt in der Registry-Zone** gespeichert.

```text
; In der Registry-Zone hinterlegt:
meinedomain.de.      IN  NS    ns1.meinedomain.de.
ns1.meinedomain.de.  IN  A     203.0.113.53        ; GLUE RECORD
ns1.meinedomain.de.  IN  AAAA  2001:db8::53        ; GLUE RECORD
```

Wenn die Registry den NS-Verweis ausliefert, hängt sie die Glue-IPs direkt im Antwortpaket an (`ADDITIONAL SECTION`). Der Resolver kann den Nameserver sofort kontaktieren.

---

## Die ternis.org-Architektur: Out-of-Bailiwick

Wir vermeiden Glue Records für Kunden- und Projektzonen durch **Out-of-Bailiwick**-Nameserver:
Alle unsere Zonen (`ternis.org`, `example-dns.com`, `mail-free.eu`) verweisen auf:
- `one.ns.ternis.net`
- `two.ns.ternis.net`

Da diese Nameserver unter `.net` liegen, benötigt eine `.org`-Domain keinerlei Glue Records in der `.org`-Registry. Glue Records waren nur ein einziges Mal für die Basisdomain `ternis.net` bei der `.net`-Registry notwendig.

---

## Prüfung mit dig im Terminal

```bash
# Gesamte Delegierungskette von Root bis Ziel nachverfolgen
dig +trace ternis.org NS

# Nameserver-IPs prüfen
host -t A one.ns.ternis.net
```
