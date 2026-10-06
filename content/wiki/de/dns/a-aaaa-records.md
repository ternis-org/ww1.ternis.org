---
title: DNS A- und AAAA-Records — Domains auf IP-Adressen zeigen lassen
description: Einsteigerfreundlicher Leitfaden zu IPv4-A-Records und IPv6-AAAA-Records, Dual-Stack-Betrieb, TTL-Tuning und Befehlen zur Prüfung mit dig.
category: dns
order: 10
tags: [dns, a-record, aaaa-record, ipv4, ipv6, dig, ttl, sysadmin]
updated: 2026-10-06
related: [dns/dns-records-overview, dns/cname-aliases, domains/nameserver-glue-delegation]
---

## Was sind A- und AAAA-Records?

Wenn du einen Domainnamen in den Browser eingibst, muss dieser in eine numerische IP-Adresse übersetzt werden:

- **`A`-Record (Address)**: Verknüpft einen Hostnamen mit einer 32-Bit **IPv4**-Adresse (z. B. `203.0.113.10`).
- **`AAAA`-Record (Quad-A)**: Verknüpft einen Hostnamen mit einer 128-Bit **IPv6**-Adresse (z. B. `2001:db8::10`). Er heißt Quad-A, weil eine IPv6-Adresse viermal so viele Bits (128) wie eine IPv4-Adresse (32) besitzt.

```text
example.com.        300  IN  A      203.0.113.10
example.com.        300  IN  AAAA   2001:db8::10
www.example.com.    300  IN  A      203.0.113.10
www.example.com.    300  IN  AAAA   2001:db8::10
```

---

## Warum Dual-Stack (A und AAAA) heute Pflicht ist

Viele moderne Mobilfunknetze (LTE/5G) und moderne Glasfaseranschlüsse nutzen intern reine IPv6-Netzwerke.

Moderne Betriebssysteme nutzen das Verfahren **Happy Eyeballs (RFC 8305)**:
- Der Browser fragt gleichzeitig A- und AAAA-Records ab.
- Bevorzugt wird die schnellere Verbindung (meist direkt IPv6).
- Fehlt der `AAAA`-Record, müssen reine IPv6-Nutzer über langsame Übersetzungsgateways des Providers geleitet werden.

---

## Apex-Domain (`@`) vs. Subdomains (`www`)

- **Apex-Domain (Root-Domain)**: Die nackte Basisdomain ohne vorangestellte Subdomain (`example.com`), in Zonendateien durch `@` dargestellt.
- **Subdomain**: Ein vorangestellter Bereich (`www.example.com`, `api.example.com`).

| Position | Erlaubte Records | Ist CNAME erlaubt? |
|----------|------------------|:------------------:|
| **Apex (`@`)** | `A` + `AAAA` | **NEIN.** Verletzt den DNS-Standard. |
| **Subdomain (`www`)** | `A` + `AAAA` oder `CNAME` | **JA.** Beides ist gültig. |

:::tip
Lege eine kanonische Hauptadresse fest (z. B. Apex oder `www`) und leite die jeweils andere per HTTP 301 Redirect im Webserver dauerhaft um, um Duplicate-Content bei Suchmaschinen zu vermeiden.
:::

---

## TTL (Time to Live) richtig wählen

Die **TTL** bestimmt, wie viele Sekunden Resolver die Antwort zwischenspeichern dürfen:

- **Regulärer Produktivbetrieb**: `3600` (1 Stunde) oder `86400` (24 Stunden) entlastet Nameserver und beschleunigt Abfragen.
- **Vor Serverumzügen**: 24 bis 48 Stunden vorher auf `300` (5 Minuten) senken, damit die IP-Umstellung weltweit in wenigen Minuten greift.

---

## Überprüfung mit dig im Terminal

```bash
# 1. Autoritativen Server direkt befragen
dig @one.ns.ternis.net example.com A +noall +answer

# 2. IPv6-Adresse abfragen
dig example.com AAAA +short

# 3. Schnelle Prüfung mit host
host -t A example.com
```

### Erklärung der Flags

- `@one.ns.ternis.net`: Befragt direkt unseren autoritativen Server ohne DNS-Caches.
- `+noall +answer`: Unterdrückt überflüssige Header und gibt nur das exakte Ergebnis aus.
- `+short`: Gibt ausschließlich die reine IP-Adresse aus.
