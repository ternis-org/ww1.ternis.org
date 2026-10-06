---
title: DNSSEC-Grundlagen — Vertrauenskette
description: Was DNSSEC signiert, wie DS-Records Parent und Child verbinden und warum example-dns seine Zonen signiert.
category: dns
order: 30
tags: [dns, dnssec, sicherheit]
updated: 2026-10-06
related: [dns/dns-records-overview, domains/nameserver-glue-delegation]
---

## Das Problem, das DNSSEC löst

Normale DNS-Antworten lassen sich fälschen — ein Resolver kann einen gefälschten
A-Record nicht vom echten unterscheiden. **DNSSEC** fügt kryptografische
Signaturen (RRSIG-Records) hinzu, sodass Resolver die Echtheit prüfen können.

## Die Vertrauenskette

1. Die **Parent-Zone** (z. B. `.com`) veröffentlicht einen **DS-Record** mit
   einem Hash deines Key-Signing-Keys.
2. Deine Zone signiert alle Records mit dem **ZSK**, den ZSK mit dem **KSK**.
3. Validatoren laufen die Kette ab: Root → TLD → deine Zone.

```bash
dig example.com DNSKEY +short
dig example.com DS +short
dig +dnssec example.com A
```

Bei validierenden Resolvern auf das `ad`-Flag (Authenticated Data) achten.

## Key-Rotation in der Praxis

- **ZSK**: vierteljährlich rotieren — die meisten Signer automatisieren das.
- **KSK**: jährlich rotieren und den DS-Record beim Registrar **vor** dem
  Entfernen des alten Keys aktualisieren, sonst wird die Domain dunkel.

:::warn
Kaputtes DNSSEC ist schlimmer als keins: Validierende Resolver beantworten
deine gesamte Domain mit SERVFAIL. Nach jedem Key-Event mit einem DNSSEC-Check
prüfen.
:::

## example-dns

ternis.org-Zonen auf `one.ns.ternis.net` / `two.ns.ternis.net` sind
DNSSEC-signiert — DS-Records werden für jede `example-dns.*`-Domain beim
Registrar veröffentlicht.
