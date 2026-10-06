---
title: Choosing MySQL vs MariaDB in 2026
description: Divergence, licensing, compatibility notes, and a decision rule for new projects.
category: mysql-mariadb
order: 5
tags: [mysql, mariadb, choice, licensing]
updated: 2026-10-06
related: [mysql-mariadb/backup-restore-mysqldump, sql/sql-in-10-minutes]
---

## How they diverged

MariaDB forked from MySQL in 2009 and both evolved separately: different
storage-engine defaults, different JSON functions, different authentication
plugins. "Drop-in replacement" stopped being true years ago — treat them as
cousins, not twins.

## Decision rule

| Situation | Pick |
|-----------|------|
| New homelab / small project | **MariaDB** — in every distro repo, truly open, zero friction |
| Managed cloud DB | Whichever your provider runs best (often MySQL 8) |
| Existing MySQL 8 app | Stay — migration buys little, risks much |
| GPL-averse commercial embedding | Check lawyers; MariaDB's LGPL client libs differ from MySQL's GPL ones |

## Compatibility notes

- `mysqldump` ↔ `mariadb-dump`: same flags, interchangeable output.
- Authentication: MySQL 8 defaults to `caching_sha2_password`; older clients
  (including old PHP `mysqlnd`) choke — create users with
  `mysql_native_password` or upgrade the client.
- JSON: function names overlap but semantics differ at the edges — test queries
  when porting, don't assume.

:::tip
For everything documented in this wiki, commands work on both unless noted.
When they differ, the article says so explicitly.
:::
