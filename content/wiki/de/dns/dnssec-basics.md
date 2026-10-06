---
title: DNSSEC Grundlagen — Die kryptografische Vertrauenskette im DNS
description: Einsteigerfreundlicher Leitfaden zu DNSSEC, Schutz vor Cache-Poisoning und Spoofing, Erklärung von DS, DNSKEY, RRSIG und Prüfung mit dig.
category: dns
order: 30
tags: [dns, dnssec, security, kryptografie, sysadmin, netzwerk]
updated: 2026-10-06
related: [dns/dns-records-overview, domains/nameserver-glue-delegation, dns/debugging-dig-host-nslookup]
---

## Warum unverschlüsseltes DNS angreifbar ist

Klassisches DNS überträgt Anfragen unverschlüsselt und ohne kryptografische Signaturen über UDP-Port 53.

Ein Angreifer auf der Netzwerkstrecke kann gefälschte Antworten einschleusen (**DNS Cache Poisoning**). Gelingt es einem Angreifer, einen fremden Server in den Cache eines Resolvers einzuschleusen, werden alle Nutzer dieses Resolvers unbemerkt auf gefälschte Server umgeleitet.

**DNSSEC (Domain Name System Security Extensions)** schließt diese Sicherheitslücke durch digitale Signaturen für alle DNS-Einträge.

---

## Die kryptografischen Records

DNSSEC verschlüsselt die Daten nicht, sondern garantiert die **Authentizität und Integrität**: Resolver können mathematisch beweisen, dass eine Antwort unverändert vom echten Zoneninhaber stammt.

| Record | Bezeichnung | Aufgabe |
|:------:|-------------|---------|
| **`RRSIG`** | Resource Record Signature | Die digitale Signatur für ein Set von DNS-Einträgen. |
| **`DNSKEY`** | DNS Public Key | Die öffentlichen Schlüssel zur Überprüfung der Signaturen. |
| **`DS`** | Delegation Signer | Der in der **übergeordneten Registry-Zone** hinterlegte kryptografische Fingerabdruck (Hash) des Zonenschlüssels. |
| **`NSEC` / `NSEC3`** | Next Secure Record | Beweist kryptografisch, dass eine Subdomain oder ein Record **nicht** existiert. |

---

## Die Vertrauenskette (Chain of Trust)

DNSSEC baut eine lückenlose Kette von den Internet-Root-Servern bis zu deiner Domain auf:

1. **Root-Zone (`.`)**: Validierende Resolver kennen den öffentlichen Trust-Anchor der Root-Server.
2. **Top-Level-Domain (`.org` / `.de`)**: Die Root-Zone beglaubigt den DS-Eintrag der Registry.
3. **Deine Domain**: Die Registry beglaubigt den DS-Eintrag deiner Zone.
4. **Deine Records**: Dein autoritativer Nameserver liefert A/AAAA-Records zusammen mit `RRSIG`-Signaturen aus.

---

## Überprüfung im Terminal mit dig

```bash
# 1. Öffentliche Schlüssel der Zone abfragen
dig ternis.org DNSKEY +short

# 2. DS-Record bei der übergeordneten Registry prüfen
dig ternis.org DS +short

# 3. DNSSEC-validierte A-Abfrage durchführen
dig +dnssec ternis.org A
```

### Worauf man in der Ausgabe achten muss:
In den Header-Flags von `dig`:
```text
;; flags: qr rd ra ad; ...
```
Das Flag **`ad` (Authenticated Data)** bestätigt, dass der Resolver die gesamte kryptografische Vertrauenskette bis zu den Root-Servern erfolgreich validiert hat.
