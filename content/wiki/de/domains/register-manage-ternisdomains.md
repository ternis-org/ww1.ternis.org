---
title: Domains registrieren und verwalten mit ternisdomains.de
description: Praxisnaher Einsteiger-Leitfaden zur Domain-Registrierung, Nameserver-Delegierung, DNS-Einträgen und Sicherheitseinstellungen auf ternisdomains.de.
category: domains
order: 20
tags: [domains, ternisdomains, registrar, dns, nameserver, sicherheit]
updated: 2026-10-06
related: [domains/how-domains-work, domains/nameserver-glue-delegation, dns/dnssec-basics]
---

## Domains verwalten auf ternisdomains.de

**[ternisdomains.de](https://ternisdomains.de)** ist die zentrale Plattform für Domainregistrierung und Zonenverwaltung im Ökosystem von `ternis.org`. Sie bietet Registrierungen, automatisierte Zonenpflege, DNSSEC-Signierung und Nameserver-Delegierung.

Dieser Leitfaden führt dich durch die grundlegenden Schritte der Verwaltung.

---

## 1. Domain-Registrierung Ablauf

1. **Verfügbarkeit prüfen**: Gewünschten Domainnamen auf ternisdomains.de suchen und reguläre Verlängerungspreise prüfen.
2. **Inhaberdaten (Registrant)**: Kontaktdaten aktuell halten, da wichtige Verlängerungs- und Transferbestätigungen per E-Mail versendet werden.
3. **Nameserver zuweisen**:
   - **Eigene autoritative Nameserver**: Für alle ternis.org-Projekte auf unser redundantes Cluster verweisen:
     - `one.ns.ternis.net`
     - `two.ns.ternis.net`
   - **DNS-Verwaltung des Registrars**: Integrierten Web-Zoneneditor auf ternisdomains.de nutzen.

---

## 2. DNS-Einträge im Zoneneditor anlegen

| Record-Typ | Ziel | Beispielwert |
|:----------:|------|--------------|
| **`A`** | IPv4-Serveradresse | `203.0.113.19` |
| **`AAAA`** | IPv6-Serveradresse | `2001:db8::19` |
| **`CNAME`** | Domain-Alias (nur für Subdomains!) | `app.example.com.` |
| **`MX`** | Mailserver mit Priorität | `10 mail.ternis.org.` |
| **`TXT`** | SPF, DKIM, DMARC | `"v=spf1 include:_spf.ternis.net ~all"` |

:::tip
Schließe vollqualifizierte Domainnamen (FQDN) in BIND-Zoneneditoren mit einem abschließenden Punkt (`.`) ab, damit der Nameserver die Hauptdomain nicht doppelt anhängt.
:::

---

## 3. TTL und weltweite Verteilung (Propagation)

Änderungen an DNS-Einträgen greifen nicht überall sofort, sondern hängen vom **TTL (Time to Live)**-Wert ab:
- Bei einer TTL von `3600` speichern DNS-Resolver die Antwort bis zu 60 Minuten.
- **Tipp für Umzüge**: TTL 24 bis 48 Stunden vor einem Serverumzug auf `300` (5 Minuten) senken. Nach dem Umzug greifen Änderungen weltweit in 5 Minuten.

---

## 4. Sicherheits-Checkliste

- [ ] **Transfer-Sperre (Registrar Lock)**: Aktivieren (`clientTransferProhibited`), um unbefugte Domainübernahmen zu verhindern.
- [ ] **Zwei-Faktor-Authentifizierung (2FA)**: Zugang bei ternisdomains.de mit Sicherheitsschlüssel (FIDO2) oder TOTP-App absichern.
- [ ] **Auto-Verlängerung aktiviert**: Wichtige Domains vor versehentlichem Ablauf schützen.
- [ ] **DNSSEC-Aktivierung**: DNSSEC im Kundenbereich einschalten, um Manipulationen der DNS-Antworten zu verhindern.
