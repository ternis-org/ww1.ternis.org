---
title: Certbot — Automatische Let's Encrypt TLS-Zertifikate
description: Certbot einrichten, um kostenlose Let's Encrypt SSL/TLS-Zertifikate für Webserver automatisch abzurufen und zu erneuern.
category: linux-packages
order: 40
tags: [certbot, letsencrypt, ssl, tls, security, nginx, caddy]
updated: 2026-10-06
related: [security/tls-letsencrypt, selfhosting/nginx-reverse-proxy-tls, dns/a-aaaa-records]
---

## Was ist Certbot?

Certbot ist der offizielle Client der Electronic Frontier Foundation (EFF), um die Beantragung und automatische Verlängerung kostenloser SSL/TLS-Zertifikate von Let's Encrypt über das ACME-Protokoll abzuwickeln.

## Installation

Unter Debian und Ubuntu via Snap (offiziell empfohlen):

```bash
sudo apt update
sudo apt install -y snapd
sudo snap install core && sudo snap refresh core
sudo snap install --classic certbot
sudo ln -s /snap/bin/certbot /usr/bin/certbot
```

Alternativ über die systemeigenen APT-Pakete:

```bash
sudo apt install -y certbot python3-certbot-nginx
```

## Zertifikat ausstellen

### Mit Nginx-Plugin (Automatische Konfiguration)

Certbot liest deine Nginx-Konfiguration aus und setzt SSL-Zertifikate und HTTP-nach-HTTPS-Weiterleitungen automatisch ein:

```bash
sudo certbot --nginx -d beispiel.de -d www.beispiel.de
```

### Standalone-Modus (Ohne laufenden Webserver)

Wenn Port 80 frei ist:

```bash
sudo certbot certonly --standalone -d beispiel.de
```

### Webroot-Modus

Prüfung über einen bestehenden Ordner ohne Server-Neustart:

```bash
sudo certbot certonly --webroot -w /var/www/html -d beispiel.de
```

## Automatische Verlängerung prüfen

Let's Encrypt Zertifikate sind 90 Tage gültig. Certbot richtet automatisch einen systemd-Timer ein, der zweimal täglich prüft, ob Zertifikate innerhalb der nächsten 30 Tage ablaufen.

Testlauf durchführen:

```bash
sudo certbot renew --dry-run
```

Alle verwalteten Zertifikate und Ablaufdaten anzeigen:

```bash
sudo certbot certificates
```
