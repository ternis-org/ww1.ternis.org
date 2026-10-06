---
title: Register and Manage Domains with dnbx.de
description: Buying, configuring nameservers, and managing the ternis.org domain portfolio via dnbx.de.
category: domains
order: 20
tags: [domains, dnbx, registrar]
updated: 2026-10-06
related: [domains/how-domains-work, domains/nameserver-glue-delegation]
---

## The ternis.org flow

All ternis.org domains are managed through [dnbx.de](https://dnbx.de):

1. Search and register the domain in dnbx.de.
2. Point its NS set at the authoritative pair:
   `one.ns.ternis.net` + `two.ns.ternis.net`.
3. Edit the zone (A/AAAA/MX/TXT) — changes propagate after the old TTL expires.
4. Enable DNSSEC: publish the DS record dnbx.de generates for your zone.

## Nameserver checklist per domain

- [ ] Both `one.` and `two.ns.ternis.net` listed (redundancy is the point).
- [ ] Glue records present if a nameserver lives inside the domain itself.
- [ ] `host -t NS yourdomain.example` returns exactly your two servers.
- [ ] DS record published if the zone is signed.

## Housekeeping that prevents outages

- Auto-renew **on**, registrant email current, payment method valid.
- Registrar lock enabled against unauthorized transfers.
- Calendar reminder 30 days before any manual-renewal domain expires.

:::tip
After any NS change, verify from three vantage points: your authoritative
server, Google (`@8.8.8.8`), and Cloudflare (`@1.1.1.1`). Propagation is just
TTL expiry wearing a trench coat.
:::
