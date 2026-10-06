---
title: Nameserver-Delegierung und Glue-Records
description: Wie NS-Delegierung funktioniert, wann Glue nötig ist und das one.ns.ternis.net-Setup als Beispiel.
category: domains
order: 35
tags: [domains, nameserver, glue, delegierung]
updated: 2026-10-06
related: [domains/how-domains-work, dns/selfhost-authoritative-dns, dns/debugging-dig-host-nslookup]
---

## Delegierung in einem Bild

Die Parent-Zone (`.org`) hält **NS-Records**, die auf deine Nameserver zeigen.
Resolver folgen ihnen, um deine Server nach allem anderen zu fragen.

```text
; in der .org-Zone:
ternis.org.   IN  NS  one.ns.ternis.net.
ternis.org.   IN  NS  two.ns.ternis.net.
```

## Wann Glue nötig ist

Wenn der Hostname eines Nameservers **innerhalb** der Domain liegt, die er
selbst bedient (in-bailiwick), entsteht ein Henne-Ei-Problem: Um
`ns1.example.com` zu finden, müsste man … `ns1.example.com` fragen. Die Lösung:
**Glue-Records** — A/AAAA-Einträge für den Nameserver in der *Parent*-Zone.

```text
; zusätzlich beim Parent:
ns1.example.com.  IN  A  203.0.113.53
```

ternis.org umgeht das elegant: `one./two.ns.ternis.net` bedienen Zonen wie
`ternis.org` und `example-dns.com` von *außerhalb* dieser Zonen, sodass für die
meisten Delegierungen kein Glue nötig ist — nur für `ternis.net` selbst.

## Delegierung prüfen

```bash
dig +trace ternis.org NS
host -t NS ternis.org
dig one.ns.ternis.net +short
```

:::warn
Lahme Delegierung — der Parent zeigt auf Nameserver, die für deine Zone nicht
autoritativ antworten — macht die Domain zeitweise unerreichbar. Beide
Richtungen prüfen: Parent-NS-Set muss gleich dem NS-Set der eigenen Zone sein.
:::
