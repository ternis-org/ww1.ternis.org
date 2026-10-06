---
title: Register and Manage Domains with ternisdomains.de
description: Practical beginner guide to domain registration, nameserver delegation, DNS record management, and security settings on ternisdomains.de.
category: domains
order: 20
tags: [domains, ternisdomains, registrar, dns, nameserver, security]
updated: 2026-10-06
related: [domains/how-domains-work, domains/nameserver-glue-delegation, dns/dnssec-basics]
---

## Managing domains on ternisdomains.de

**[ternisdomains.de](https://ternisdomains.de)** is the domain management and registrar platform used across the `ternis.org` infrastructure ecosystem. It provides registration, automated zone management, DNSSEC signing, and nameserver delegation.

Whether you are purchasing your first domain or managing an enterprise portfolio, this guide covers the standard operational workflow.

---

## 1. Domain Registration Workflow

1. **Search availability**: Enter your desired domain name on ternisdomains.de to confirm availability and review regular renewal pricing.
2. **Contact information (Registrant Handle)**: Ensure your registrant contact details (name, email address, physical address) are accurate. Important renewal and transfer authorizations are delivered to this address.
3. **Nameserver assignment**: Choose whether to use:
   - **Custom authoritative nameservers**: For all ternis.org domains, point to our redundant nameserver cluster:
     - `one.ns.ternis.net`
     - `two.ns.ternis.net`
   - **Registrar DNS management**: Use ternisdomains.de's built-in web DNS zone editor to manage individual records.

---

## 2. Managing DNS Records

When managing records directly in the ternisdomains.de zone editor:

| Record Type | What it points to | Example Value |
|:-----------:|-------------------|---------------|
| **`A`** | IPv4 Server Address | `203.0.113.19` |
| **`AAAA`** | IPv6 Server Address | `2001:db8::19` |
| **`CNAME`** | Domain alias (subdomains only!) | `app.example.com.` |
| **`MX`** | Mail exchange server + priority | `10 mail.ternis.org.` |
| **`TXT`** | SPF, DKIM, DMARC, or site verification | `"v=spf1 include:_spf.ternis.net ~all"` |

:::tip
Always terminate fully qualified domain names (FQDN) in zone records with a trailing dot (`.`) if supported by the zone format, preventing the nameserver from appending your root domain twice.
:::

---

## 3. Understanding TTL and Propagation

When you update an `A` record or `MX` record in your DNS control panel, the change does not always take effect across the world immediately.

This delay is controlled by the **TTL (Time to Live)** parameter:
- If your old record had a TTL of `3600` (1 hour), public recursive DNS resolvers (like Google `8.8.8.8` or Cloudflare `1.1.1.1`) cache the old value for up to 60 minutes.
- **Best Practice for Planned Migrations**: 24 to 48 hours before migrating servers, reduce your DNS record TTL to `300` (5 minutes). Once the TTL expires, make the IP switch. The change will take effect within 5 minutes globally. Once verified, raise the TTL back to `3600` or `86400`.

---

## 4. Security & Maintenance Checklist

To protect domains against unauthorized takeover and accidental expiration:

- [ ] **Registrar Transfer Lock**: Ensure the transfer lock (`clientTransferProhibited`) is enabled to prevent unauthorized domain transfers.
- [ ] **Two-Factor Authentication (2FA)**: Enforce hardware security key (FIDO2/WebAuthn) or TOTP authenticator app on your ternisdomains.de account.
- [ ] **Auto-Renewal Enabled**: Never rely on manual reminders for mission-critical domain renewals.
- [ ] **DNSSEC Activation**: Enable DNSSEC signing in the control panel to cryptographically protect against DNS cache poisoning.

---

## Verifying your configuration in the terminal

```bash
# Check the registered nameservers
host -t NS yourdomain.de

# Query the primary nameserver directly for your web server IP
dig @one.ns.ternis.net yourdomain.de A +short
```
