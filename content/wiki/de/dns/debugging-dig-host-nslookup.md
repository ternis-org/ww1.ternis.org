---
title: DNS-Debugging mit dig, host und nslookup — Das Toolkit für Administratoren
description: DNS-Probleme systematisch beheben mit dig, host und nslookup, Auflösungsketten mit +trace analysieren, Status-Codes (NXDOMAIN, SERVFAIL) und Caching verstehen.
category: dns
order: 35
tags: [dns, dig, host, nslookup, debugging, troubleshooting, sysadmin]
updated: 2026-10-06
related: [dns/a-aaaa-records, dns/txt-spf-dkim-dmarc, dns/dnssec-basics]
---

## Warum DNS-Debugging essenziell ist

Wenn eine Website nicht erreichbar ist, E-Mails abgewiesen werden oder TLS-Zertifikate fehlschlagen, liegt die Ursache fast immer im DNS.

Das Terminal-Tool **`dig` (Domain Information Groper)** ist der weltweite Standard, um DNS-Einträge präzise und ohne Verfälschung durch Zwischenspeicher zu prüfen.

---

## Die wichtigsten Befehle & Flags im Überblick

```bash
# 1. Autoritativen Server direkt abfragen (Caches umgehen)
dig @one.ns.ternis.net example.com A +noall +answer

# 2. Die gesamte Auflösungskette von den Root-Servern an tracen
dig example.com +trace

# 3. Nur die reine IP-Adresse ausgeben (ideal für Skripte)
dig example.com +short

# 4. Mailserver-Einträge (MX) prüfen
dig example.com MX +noall +answer

# 5. TXT-Einträge (SPF, DMARC) einsehen
dig example.com TXT +short
```

### Erklärung der Flags

- `@<server>`: Sendet die Anfrage gezielt an diesen Nameserver (z. B. `@1.1.1.1` für Cloudflare oder `@one.ns.ternis.net` für unsere autoritativen Server).
- `+trace`: Simuliert die vollständige Abfragekette: Beginnend bei den Root-Servern (`.`), über die TLD-Registry (`.de` / `.org`) bis hin zum autoritativen Server. So siehst du sofort, an welchem Knotenpunkt die Kette abreißt.
- `+noall`: Entfernt alle standardmäßigen Kommentarblöcke aus der Ausgabe.
- `+answer`: Aktiviert ausschließlich den Ergebnisblock (`ANSWER SECTION`).
- `+short`: Gibt nur den reinen Ergebniswert ohne Tabellenformatierung zurück.

---

## DNS-Statuscodes (RCODEs) verstehen

In der Kopfzeile von `dig` gibt das Feld `status:` Auskunft über das Ergebnis:

| Status | Bedeutung | Häufige Ursache |
|:------:|-----------|-----------------|
| **`NOERROR`** | Erfolgreich | Anfrage war erfolgreich. Fehlen Antworten, existiert die Domain, hat aber keinen Eintrag des angefragten Typs. |
| **`NXDOMAIN`** | Nicht gefunden | Domain oder Subdomain existiert nicht in der Zone (Tippfehler oder fehlender Zoneneintrag). |
| **`SERVFAIL`** | Server-Fehler | Der Server konnte nicht antworten. Häufigste Ursachen: **Fehlgeschlagene DNSSEC-Validierung** oder fehlerhafte Nameserver-Delegierung. |
| **`REFUSED`** | Verweigert | Der Nameserver verweigert die Antwort (z. B. keine Berechtigung für rekursive Abfragen). |

---

## Caching-Probleme diagnostizieren

Wenn Änderungen bei dir funktionieren, aber bei Kunden oder Kollegen nicht:

Vergleiche verschiedene öffentliche DNS-Resolver:

```bash
dig @1.1.1.1 example.com +noall +answer
dig @8.8.8.8 example.com +noall +answer
dig @one.ns.ternis.net example.com +noall +answer
```

Die Zahl in der Ausgabe (z. B. `example.com. 240 IN A ...`) zeigt die **verbleibenden TTL-Sekunden** im Cache des jeweiligen Resolvers. Erst wenn dieser Zähler auf `0` fällt, wird der neue Eintrag abgefragt.
