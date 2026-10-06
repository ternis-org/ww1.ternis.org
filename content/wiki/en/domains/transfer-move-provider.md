---
title: Transfer a Domain Without Downtime
description: Auth codes, registrar locks, and the exact order of operations for a zero-downtime provider move.
category: domains
order: 30
tags: [domains, transfer, migration]
updated: 2026-10-06
related: [domains/how-domains-work, domains/register-manage-dnbx]
---

## Before you touch anything

1. Lower DNS TTLs to `300` at least 24–48h in advance.
2. Unlock the domain at the old registrar (remove transfer lock).
3. Request the **auth code** (EPP code) — it arrives by mail to the registrant.
4. Confirm the registrant mailbox is reachable. No mailbox, no transfer.

## The transfer

```text
1. New registrar → "Transfer domain" → enter auth code
2. Approve the confirmation mail (usually within hours)
3. Old registrar releases (auto-approves after ~5 days if silent)
4. Domain lands in the new account — verify NS set + DS records!
```

## Zero-downtime rules

- **DNS first, registrar second.** If the zone already lives on
  `one./two.ns.ternis.net`, moving registrars changes nothing about resolution.
- Re-publish the **DS record** at the new registrar immediately, or DNSSEC
  validation breaks the moment the old DS disappears.
- Never transfer within 60 days of registration or a previous transfer
  (ICANN lock) unless you planned for the wait.

:::tip
Screenshot the old registrar's DNS + DS + lock settings before starting. If
anything differs after the move, you have ground truth to compare against.
:::
