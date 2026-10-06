---
title: How Domains Work — Registry, Registrar, Registrant, and Lifecycle
description: A complete beginner-friendly overview of how internet domain names work, the three key roles, domain hierarchy, the full lifecycle, and nameserver delegation.
category: domains
order: 10
tags: [domains, dns, registry, registrar, ternisdomains, fundamentals, web]
updated: 2026-10-06
related: [domains/nameserver-glue-delegation, dns/dns-records-overview, domains/choosing-tld]
---

## Why domain names exist

Computers and routers communicate across the internet using numeric IP addresses (like `203.0.113.19` or `2001:db8::1`). Humans, however, are terrible at remembering long strings of numbers.

The **Domain Name System (DNS)** acts as the internet's global phonebook, translating memorable human-readable names like `ternis.org` into the IP addresses where servers live.

---

## The three primary roles

Behind every domain name are three distinct entities:

```text
[ ICANN / Registry ]  (Maintains Top-Level Domain zone, e.g. .de, .com)
         │
         ▼  (Accreditation & Wholesale)
  [ Registrar ]       (Retailer where you purchase domains, e.g. ternisdomains.de)
         │
         ▼  (Retail purchase & management)
  [ Registrant ]      (You — the owner with the legal right to use the domain)
```

| Entity | Real-World Example | Role & Responsibility |
|--------|--------------------|-----------------------|
| **Registry** | DENIC (`.de`), Verisign (`.com`), Public Interest Registry (`.org`) | The central organization operating the master database (zone) for a specific Top-Level Domain (TLD). Sets official wholesale pricing and TLD-level policies. |
| **Registrar** | **ternisdomains.de**, Namecheap, Porkbun | ICANN-accredited retail provider. Sells domain registrations to end customers, manages WHOIS/RDAP contact records, and coordinates with registries. |
| **Registrant** | You or your organization | The person or legal company who holds the licensed right to use the domain name for the duration of the paid registration period. |

---

## The hierarchical anatomy of a domain name

Domain names are read from right to left:

```text
  ww1    .    ternis    .    org    .
   │            │             │     │
Subdomain  Second-Level      TLD   Root Domain
             Domain
```

1. **Root Domain (`.`)**: The apex of the entire global DNS hierarchy. In full technical notations (FQDN), names end with a trailing dot (`ternis.org.`).
2. **Top-Level Domain (TLD)**: The rightmost label (`.org`, `.de`, `.com`).
3. **Second-Level Domain (SLD)**: The unique brand name registered under the TLD (`ternis`).
4. **Subdomain**: Prefixes created by the domain owner (`ww1`, `mail`, `api`) to partition different servers and services.

---

## The complete domain lifecycle

Every domain follows a standardized international lifecycle:

```text
[ Available ] ──► [ Active (1-10 Years) ] ──► [ Expiration Date ]
                                                     │
                                                     ▼
[ Dropped / Available ] ◄── [ Pending Delete ] ◄── [ Redemption Period ] ◄── [ Grace Period ]
```

1. **Available**: The domain is unregistered and open for purchase.
2. **Active**: The registrant pays the yearly registration fee. The domain resolves live DNS queries.
3. **Grace Period (Auto-Renew Grace)**: If you fail to renew before the expiration date, the domain enters a grace period (typically 30–40 days). Website traffic stops, but you can renew without penalty.
4. **Redemption Period**: The registrar returns the domain to the registry. The original registrant can still recover it, but registries charge a steep recovery fee (often €50–€150).
5. **Pending Delete**: A 5-day lock during which nobody can rescue or purchase the domain.
6. **Dropped / Available**: The registry releases the domain back to the public pool on a first-come, first-served basis.

:::tip
Always enable **Auto-Renew** and keep your billing email address active. Most high-profile "domain hijackings" are simply expired domains whose renewal reminder emails bounced off an abandoned mailbox.
:::
