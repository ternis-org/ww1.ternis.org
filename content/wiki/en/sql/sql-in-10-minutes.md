---
title: SQL in 10 Minutes — Your First Queries
description: SELECT, WHERE, ORDER BY, LIMIT, NULL handling, and the mistakes every beginner makes.
category: sql
order: 5
tags: [sql, basics, select]
updated: 2026-10-06
related: [sql/joins-explained, mysql-mariadb/backup-restore-mysqldump]
---

## Read data

```sql
SELECT name, email
FROM users
WHERE active = 1
ORDER BY created_at DESC
LIMIT 10;
```

Order matters: `FROM` → `WHERE` → `ORDER BY` → `LIMIT`. `SELECT` names *what*,
the rest narrows *which rows*.

## NULL is not zero

```sql
-- WRONG: never matches NULL emails
SELECT * FROM users WHERE email != 'x@y.zz';

-- RIGHT: explicitly include the unknown
SELECT * FROM users WHERE email != 'x@y.zz' OR email IS NULL;
```

`NULL` means "unknown" — every comparison with it is neither true nor false.

## Aggregate and group

```sql
SELECT status, COUNT(*) AS n, AVG(total) AS avg_total
FROM orders
GROUP BY status
HAVING COUNT(*) > 5;
```

`WHERE` filters rows *before* grouping, `HAVING` filters groups *after*.

## Beginner mistakes

1. No `WHERE` on `UPDATE`/`DELETE` — always write the `SELECT` version first.
2. `LIMIT` without `ORDER BY` returns arbitrary rows, not "the first".
3. Storing money as `FLOAT` — use `DECIMAL(10,2)` or lose cents to rounding.

:::warn
Run destructive statements inside a transaction while learning:
`START TRANSACTION; … ; ROLLBACK;` lets you inspect before committing.
:::
