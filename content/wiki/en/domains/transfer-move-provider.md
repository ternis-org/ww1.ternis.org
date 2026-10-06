---
title: Transfer a Domain Without Downtime — Complete Migration Guide
description: Step-by-step guide to transferring domain names between registrars with zero downtime, EPP Auth-Codes, ICANN 60-day rules, and DNSSEC handling.
category: domains
order: 30
tags: [domains, transfer, migration, registrar, dnssec, sysadmin]
updated: 2026-10-06
related: [domains/how-domains-work, domains/register-manage-ternisdomains, domains/nameserver-glue-delegation]
---

## What happens during a domain transfer?

A **domain transfer** moves the sponsorship and retail management of a domain from one registrar (e.g. GoDaddy, Namecheap) to another (e.g. [ternisdomains.de](https://ternisdomains.de)).

Transferring does **not** automatically shut down your website or email. If performed in the correct sequence, a transfer completes with **zero seconds of downtime**.

---

## Pre-Transfer Checklist

Complete these 5 checks before initiating the transfer:

1. **Check the 60-day ICANN Lock**: ICANN rules prohibit transferring gTLDs (`.com`, `.net`, `.org`) within 60 days of initial registration or a previous transfer. (Note: Many ccTLDs like `.de` do not have this restriction).
2. **Verify the Registrant Email Address**: Transfer authorization emails and tokens are sent to the administrative/registrant email address listed on the domain. Confirm you have full access to that inbox.
3. **Disable Transfer Lock**: In your current registrar's control panel, disable the registrar lock (status: `clientTransferProhibited`).
4. **Obtain the Auth-Code (EPP Key)**: Request the authorization code (also called Auth-Info code, EPP token, or secret key) from your current registrar.
5. **Lower DNS TTLs**: If you plan to change nameservers alongside the move, lower record TTLs to `300` (5 minutes) at least 24 to 48 hours beforehand.

---

## Step-by-Step Migration Process

```text
[ Current Registrar ]                         [ New Registrar (ternisdomains.de) ]
        │                                                  │
 1. Unlock domain & get Auth-Code                          │
        │                                                  │
 2. ───────────────── Submit Transfer with Auth-Code ─────►│
                                                           │
 3. Approve confirmation email                             │
        │                                                  │
 4. Old registrar releases domain (takes 1-5 days)         │
        │                                                  │
 5. Domain arrives in new account ─────────────────────────►
```

### 1. Initiate transfer at the new registrar
Log into your new registrar account (e.g. ternisdomains.de), select **Transfer Domain**, enter your domain name, and paste the EPP Auth-Code.

### 2. Approve authorization requests
Check your email. Depending on the TLD, the registry or gaining registrar sends an authorization link. Click to confirm.

### 3. Registry processing
The losing registrar receives the transfer request. They typically give you 5 days to cancel. Most registrars offer an *"Approve Transfer Immediately"* button in their dashboard to speed this up to just a few minutes.

---

## How to guarantee ZERO Downtime

The secret to a seamless migration is separating **Registrar Transfer** from **Nameserver Hosting**:

1. **Keep Nameservers External**: If your DNS is hosted on independent authoritative nameservers (such as `one.ns.ternis.net` and `two.ns.ternis.net`), moving registrars changes nothing about DNS resolution. Resolvers continue querying the same nameservers throughout the entire process.
2. **Handle DNSSEC Carefully**: If your domain uses DNSSEC, the parent registry publishes a **DS (Delegation Signer) record**.
   - If the losing registrar deletes the DNSSEC keys when releasing the domain, global recursive resolvers that validate DNSSEC will fail with `SERVFAIL` (bogus zone).
   - Either disable DNSSEC 24 hours prior to the transfer and re-enable it at the new registrar, or immediately submit your new DS record at the new registrar as soon as the domain lands.

---

## Verification commands

After the transfer finishes, verify that your nameservers and domain status are correct:

```bash
# Check WHOIS status (should show OK or clientTransferProhibited once re-locked)
whois yourdomain.com | grep -E "Registrar:|Domain Status:"

# Confirm nameservers respond accurately
dig @one.ns.ternis.net yourdomain.com +short
```
