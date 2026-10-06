---
title: SQL in 10 Minuten — Deine ersten Abfragen
description: SELECT, WHERE, ORDER BY, LIMIT, NULL-Verhalten und die Fehler, die jede Anfängerin macht.
category: sql
order: 5
tags: [sql, grundlagen, select]
updated: 2026-10-06
related: [sql/joins-explained, mysql-mariadb/backup-restore-mysqldump]
---

## Daten lesen

```sql
SELECT name, email
FROM users
WHERE active = 1
ORDER BY created_at DESC
LIMIT 10;
```

Reihenfolge: `FROM` → `WHERE` → `ORDER BY` → `LIMIT`. `SELECT` nennt *was*,
der Rest grenzt ein, *welche Zeilen*.

## NULL ist nicht null

```sql
-- FALSCH: trifft NULL-Mails nie
SELECT * FROM users WHERE email != 'x@y.zz';

-- RICHTIG: das Unbekannte explizit einschließen
SELECT * FROM users WHERE email != 'x@y.zz' OR email IS NULL;
```

`NULL` heißt „unbekannt" — jeder Vergleich damit ist weder wahr noch falsch.

## Aggregieren und gruppieren

```sql
SELECT status, COUNT(*) AS n, AVG(total) AS avg_total
FROM orders
GROUP BY status
HAVING COUNT(*) > 5;
```

`WHERE` filtert Zeilen *vor* dem Gruppieren, `HAVING` filtert Gruppen *danach*.

## Anfängerfehler

1. Kein `WHERE` bei `UPDATE`/`DELETE` — immer erst die `SELECT`-Variante schreiben.
2. `LIMIT` ohne `ORDER BY` liefert beliebige Zeilen, nicht „die ersten".
3. Geld als `FLOAT` speichern — `DECIMAL(10,2)` nehmen oder Cent durch Rundung verlieren.

:::warn
Destruktive Statements beim Lernen in Transaktionen packen:
`START TRANSACTION; … ; ROLLBACK;` zeigt alles vor dem Commit.
:::
