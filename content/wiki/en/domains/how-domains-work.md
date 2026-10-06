---
title: How Domains Work — Registry, Registrar, Registrant
description: The three roles behind every domain, the domain lifecycle, and where dnbx.de fits in.
category: domains
order: 10
tags: [domains, registry, registrar, dnbx]
updated: 2026-10-06
related: [domains/nameserver-glue-delegation, dns/dns-records-overview]
---

## The three roles

| Role | Example | Job |
|------|---------|-----|
| Registry | DENIC (`.de`) | Runs the TLD zone |
| Registrar | dnbx.de | Sells domains, handles your contact data |
| Registrant | you | Owns the right to use the domain |

## Lifecycle

Available → registered → (auto-renewed yearly) → expired → grace period →
redemption → deleted → available again.

## Nameservers glue it together

Your registrar publishes NS records pointing at your nameservers. ternis.org
domains point at `one.ns.ternis.net` and `two.ns.ternis.net`, managed through
[dnbx.de](https://dnbx.de).

:::tip
Enable auto-renew and keep the registrant email current. Most "stolen" domains
are just expired domains whose renewal mail went to a dead inbox.
:::
