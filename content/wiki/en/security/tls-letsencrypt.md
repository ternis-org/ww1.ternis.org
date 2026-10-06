---
title: TLS with Let's Encrypt — ACME Without Tears
description: HTTP-01 vs DNS-01 challenges, renewal, and the chain issues that break old clients.
category: security
order: 10
tags: [security, tls, letsencrypt, acme]
updated: 2026-10-06
related: [selfhosting/nginx-reverse-proxy-tls]
---

## The two challenges

| Challenge | Needs | Wildcards? |
|-----------|-------|------------|
| HTTP-01 | Public port 80 | No |
| DNS-01 | TXT record API | Yes |

## Issue and renew

```bash
sudo certbot --nginx -d example.com -d www.example.com
sudo certbot renew --dry-run
```

Renewal is automatic via systemd timer — verify the dry run once, then forget it.

## Chain gotchas

- Serve the **full chain** (`fullchain.pem`), not just the leaf.
- Test with `curl -vI https://example.com` and an SSL checker after every change.
- Old Android (<7.1) needs the long chain; modern clients prefer the short one.
