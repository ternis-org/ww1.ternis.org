# 06 — Article Inventory (v1)

Category slugs are stable/English. Target: **~60 seed articles** so no category
ships empty. Each ships in EN + DE (`content/wiki/{en,de}/...`).

## `networking` — fundamentals
1. `osi-tcpip-model` — OSI vs TCP/IP, encapsulation, what to memorize
2. `ip-subnetting-cidr` — CIDR, masks, usable hosts, cheat sheet
3. `vlans-trunks` — VLANs, tagging (802.1Q), trunk vs access
4. `nat-port-forwarding` — SNAT/DNAT, home-router forwarding, hairpin NAT
5. `firewall-basics-ufw-iptables` — allow-list mindset, UFW → iptables mapping
6. `reverse-proxy-basics` — Nginx/Caddy/Traefik, SNI, X-Forwarded-*, TLS termination

## `homelab` — practical builds
1. `planning-first-rack` — power, noise, UPS, network drops, budget ladder
2. `proxmox-getting-started` — install, storage (ZFS/LVM), first VM/LXC
3. `docker-compose-homelab` — compose patterns, volumes, updates, backups
4. `nas-storage-zfs` — RAID/ZFS levels, snapshots, SMART, 3-2-1 backups
5. `remote-access-tailscale-vpn` — Tailscale/WireGuard vs port-forwarding, SSO
6. `monitoring-uptime` — Uptime Kuma, logs, alerts that don't spam

## `domains` — owning names on the internet
1. `how-domains-work` — registry/registrar/registrant, lifecycle
2. `choosing-tld` — `.de` vs `.eu` vs `.com`, pricing traps, renewal math
3. `register-manage-dnbx` — buying + managing via dnbx.de (ternis.org flow)
4. `whois-rdaps-privacy` — RDAP, redaction, GDPR, contact hygiene
5. `transfer-move-provider` — auth codes, locks, downtime-free moves
6. `nameserver-glue-delegation` — NS records, glue, `one.ns.ternis.net` example

## `dns` — the phonebook (ties into example-dns)
1. `dns-records-overview` — A/AAAA/CNAME/MX/TXT/NS/SOA/SRV/CAA in one table
2. `a-aaaa-records` — apex vs `www`, TTL tuning, verification with `dig`
3. `cname-aliases` — when (not) to CNAME, apex problem, ANAME/ALIAS
4. `mx-email-deliverability` — MX + SPF/DKIM/DMARC minimum viable setup
5. `txt-spf-dkim-dmarc` — syntax, testing, rollout without breaking mail
6. `dnssec-basics` — chain of trust, DS records, why `example-dns` signs
7. `debugging-dig-host-nslookup` — `dig +trace`, `host -t`, negative answers
8. `selfhost-authoritative-dns` — running authoritative NS (example-dns repo tour)

## `sql` — querying data
1. `sql-in-10-minutes` — SELECT/WHERE/ORDER/LIMIT, nulls, first queries
2. `joins-explained` — INNER/LEFT/RIGHT/FULL with Venn + code
3. `indexes-explain` — B-tree intuition, `EXPLAIN`, when indexes hurt
4. `transactions-acid` — BEGIN/COMMIT/ROLLBACK, isolation levels
5. `backups-restores` — `mysqldump`/`mariadb-dump`, point-in-time thinking

## `linux` — the base layer
1. `filesystem-permissions` — `rwx`, `chmod`/`chown`, umask, sudo hygiene
2. `ssh-hardening` — keys, `sshd_config`, fail2ban, agent forwarding risks
3. `systemd-services-timers` — units, `systemctl`, timers vs cron
4. `logs-journald` — `journalctl`, logrotate, disk pressure

## `ubuntu` — the daily driver
1. `apt-survival-guide` — update/upgrade, PPAs, holds, unattended-upgrades
2. `ufw-basics` — default-deny, app profiles, rate limiting SSH
3. `users-sudo-management` — adduser, groups, passwordless sudo (carefully)

## `mysql-mariadb` — the database
1. `choosing-mysql-vs-mariadb` — divergence, licensing, compat notes
2. `install-secure-first-db` — install on Ubuntu, `mariadb-secure-installation`, users
3. `users-privileges` — `CREATE USER`, `GRANT` least-privilege, host scoping
4. `backup-restore-mysqldump` — full + single-DB dumps, restore drills, cron
5. `tuning-for-small-vps` — InnoDB buffer pool, slow log, what not to touch

## `phpmyadmin` — the GUI
1. `install-secure-phpmyadmin` — install, alias/cookie auth, blowfish secret
2. `daily-workflows` — browse/edit, import/export, SQL tab, designer
3. `hardening-checklist` — restrict by IP/VPN, 2FA/proxy auth, no root login

## `php` — server language of ternis.org itself
1. `getting-started-83` — install, `php -S`, opcache, first router (like this site)
2. `forms-security` — `htmlspecialchars`/`e()`, POST handling, CSRF sketch
3. `pdo-mysql-guide` — prepared statements, errors as exceptions, transactions

## `javascript` — browser interactivity
1. `fetch-basics` — GET/POST JSON, errors, AbortController
2. `dom-without-framework` — query/select, events, IntersectionObserver (as used here)
3. `theme-toggle-pattern` — `localStorage` + `prefers-color-scheme` (this site's FOUC guard)

## `css` — styling
1. `layout-grid-flexbox` — when to use which, holy-grail in 20 lines
2. `variables-dark-mode` — custom props + `[data-theme]` (this design system)
3. `responsive-without-framework` — clamp(), container queries intro, mobile-first

## Overflow (`selfhosting`, `security`, `git-devops`) — "and more"
1. `selfhosting/nginx-reverse-proxy-tls` — server blocks, Let's Encrypt, HSTS
2. `selfhosting/docker-compose-patterns` — cross-ref homelab track
3. `security/tls-letsencrypt` — ACME DNS-01 vs HTTP-01, renewal, chain issues
4. `security/backup-321-rule` — the one page to print and tape to the rack
5. `git-devops/git-crash-course` — clone/branch/PR flow for wiki contributions

> Contribution rule: every new article PR must include EN body; DE may follow
> within the same PR or a linked follow-up (tracked, never silently missing).
