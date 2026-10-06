---
title: MySQL and MariaDB Backups with mysqldump
description: Full and single-database dumps, restore drills, and a cron pattern that actually gets tested.
category: mysql-mariadb
order: 20
tags: [mysql, mariadb, backup, mysqldump]
updated: 2026-10-06
related: [sql/sql-in-10-minutes]
---

## Full backup

```bash
mysqldump --all-databases --single-transaction --quick \
  | gzip > /backups/mysql-$(date +%F).sql.gz
```

`--single-transaction` gives a consistent InnoDB snapshot without locking tables.

## Single database

```bash
mysqldump --single-transaction shop | gzip > shop-$(date +%F).sql.gz
```

## Restore drill

A backup you never restored is a rumor. Test monthly:

```bash
gunzip -c shop-2026-10-06.sql.gz | mysql -u root -p shop_restore_test
```

## Automate with cron

```text
30 2 * * * /usr/local/bin/mysql-backup.sh >> /var/log/mysql-backup.log 2>&1
```

:::tip
Follow the 3-2-1 rule: 3 copies, 2 different media, 1 off-site. A dump that
only exists on the database server itself is not a backup.
:::

## MariaDB note

`mariadb-dump` is the same tool under the MariaDB name — flags are identical.
