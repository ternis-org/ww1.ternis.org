---
title: SQL in 10 Minutes — Your First Queries and Core Mental Model
description: Complete beginner guide to SQL querying, clause execution order, SELECT, WHERE, ORDER BY, LIMIT, NULL logic, grouping, and transaction safety.
category: sql
order: 5
tags: [sql, database, select, queries, beginner, tutorial]
updated: 2026-10-06
related: [sql/joins-explained, sql/indexes-explain, mysql-mariadb/backup-restore-mysqldump]
---

## What is SQL?

**SQL (Structured Query Language)** is the universal standard language used to interact with relational database management systems like PostgreSQL, MySQL, MariaDB, and SQLite.

In a relational database:
- Data is organized into **tables** (similar to spreadsheets).
- Each table has **columns** (fields defining data type, e.g. `id`, `name`, `email`) and **rows** (individual data records).

---

## 1. The Anatomy of a SELECT query

Here is a standard SQL query fetching active users sorted by creation date:

```sql
SELECT id, name, email
FROM users
WHERE status = 'active'
ORDER BY created_at DESC
LIMIT 10 OFFSET 0;
```

### Written order vs Execution order

Beginners are often confused because SQL is written in one order, but executed internally by the database engine in a different order:

| Step | Clause | What happens under the hood |
|:----:|--------|-----------------------------|
| **1** | `FROM users` | The database identifies the source table to scan. |
| **2** | `WHERE status = 'active'` | Filters rows, discarding any row where condition evaluates to FALSE or NULL. |
| **3** | `SELECT id, name, email` | Extracts only the requested columns for the remaining rows. |
| **4** | `ORDER BY created_at DESC` | Sorts the resulting rows (here: `DESC` = descending, newest first). |
| **5** | `LIMIT 10 OFFSET 0` | Takes the first 10 rows and discards the rest (ideal for pagination). |

### Clause breakdown

- `SELECT`: Specifies which columns you want to retrieve. Use specific column names instead of `SELECT *` in production code to reduce memory and network bandwidth.
- `FROM`: Names the table containing the rows.
- `WHERE`: A conditional filter. Only rows that satisfy this boolean expression are kept.
- `ORDER BY`: Sorts the output. By default, sorting is `ASC` (ascending, A-Z, 0-9). Specify `DESC` for descending order.
- `LIMIT <number>`: Restricts the maximum number of rows returned.
- `OFFSET <number>`: Skips the specified number of rows before beginning to return results.

---

## 2. Filtering conditions and comparison operators

```sql
-- Pattern matching with LIKE (% matches zero or more characters)
SELECT name FROM products WHERE name LIKE 'Pro%';

-- Multiple allowed values with IN
SELECT * FROM orders WHERE status IN ('shipped', 'delivered');

-- Inclusive numeric ranges with BETWEEN
SELECT * FROM products WHERE price BETWEEN 10.00 AND 50.00;
```

---

## 3. The `NULL` trap: Three-valued logic

In SQL, `NULL` does **not** mean zero, empty string, or false. `NULL` means **"unknown"** or **"missing data"**.

Because `NULL` is unknown, mathematical and equality comparisons with `NULL` evaluate to UNKNOWN:

```sql
-- WRONG: This will NEVER match rows where email is NULL!
SELECT * FROM users WHERE email != 'test@example.com';

-- CORRECT: Explicitly check for NULL with IS NULL / IS NOT NULL
SELECT * FROM users WHERE email != 'test@example.com' OR email IS NULL;
```

:::warn
Never use `= NULL` or `!= NULL`. Always use `IS NULL` or `IS NOT NULL`.
:::

---

## 4. Aggregations and grouping: GROUP BY and HAVING

Aggregations calculate a single summary value across multiple rows:
- `COUNT(*)`: Counts matching rows.
- `SUM(column)`: Totals values in column.
- `AVG(column)`: Calculates the arithmetic mean.
- `MIN(column)` / `MAX(column)`: Smallest and largest values.

```sql
SELECT status, COUNT(*) AS total_orders, AVG(total_amount) AS average_spent
FROM orders
WHERE created_at >= '2026-01-01'
GROUP BY status
HAVING COUNT(*) > 5;
```

### Crucial difference: `WHERE` vs `HAVING`

- `WHERE`: Filters individual rows **before** any grouping or aggregation takes place.
- `HAVING`: Filters aggregated group summaries **after** rows are grouped by `GROUP BY`.

---

## 5. Preventing accidental disasters: Transactions

When running `UPDATE` or `DELETE` statements while learning or performing maintenance, an accidental omission of the `WHERE` clause can overwrite or delete an entire table.

Always use a transaction:

```sql
-- 1. Start a safe transaction boundary
START TRANSACTION;

-- 2. Run your change
UPDATE users SET status = 'inactive' WHERE last_login < '2025-01-01';

-- 3. Verify the number of affected rows
SELECT COUNT(*) FROM users WHERE status = 'inactive';

-- 4a. If something looks wrong, undo everything cleanly:
ROLLBACK;

-- 4b. If everything is verified correct, make changes permanent:
-- COMMIT;
```

### Safety Rules

1. **Always test with SELECT first**: Before running `DELETE FROM users WHERE ...`, run `SELECT * FROM users WHERE ...` with the identical condition to verify exactly which rows will be affected.
2. **Never store money in FLOAT or DOUBLE**: Always use `DECIMAL(10,2)` or store integers in cents to avoid IEEE floating-point rounding errors.
