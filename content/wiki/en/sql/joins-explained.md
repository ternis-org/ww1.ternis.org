---
title: SQL JOINs Explained with Visual Examples and Code
description: Master INNER JOIN, LEFT JOIN, RIGHT JOIN, and anti-joins with step-by-step beginner explanations, table diagrams, and syntax breakdowns.
category: sql
order: 10
tags: [sql, joins, inner-join, left-join, relational-database, beginner]
updated: 2026-10-06
related: [sql/sql-in-10-minutes, sql/indexes-explain, php/pdo-mysql-guide]
---

## Why do we need JOINs?

In relational databases, data is organized into specialized tables to prevent duplication (a process called **normalization**).

Instead of storing user names, email addresses, and phone numbers repeatedly inside every single purchase record, we keep two tables:
1. `users` table (stores customer accounts).
2. `orders` table (stores purchases, referencing the user via a `user_id` foreign key).

A **JOIN** allows you to connect and combine rows from two or more tables in a single query based on a related column between them.

---

## Our sample tables

To understand joins intuitively, imagine these two small tables:

### Table `users`
| id | name |
|:--:|------|
| 1 | Alice |
| 2 | Bob |
| 3 | Charlie |

### Table `orders`
| id | user_id | amount |
|:--:|:-------:|:------:|
| 101 | 1 | 49.00 |
| 102 | 1 | 15.00 |
| 103 | 2 | 99.00 |

*(Notice: Alice placed two orders, Bob placed one order, and Charlie has placed zero orders).*

---

## 1. INNER JOIN — Keep only matching pairs

An **`INNER JOIN`** returns rows only when there is a match in **both** tables. If a row in the left table has no matching row in the right table (or vice versa), it is excluded from the result.

```sql
SELECT users.name, orders.id AS order_id, orders.amount
FROM users
INNER JOIN orders ON orders.user_id = users.id;
```

### Syntax breakdown

- `FROM users`: Specifies the first (left) table.
- `INNER JOIN orders`: Specifies the second (right) table to join.
- `ON orders.user_id = users.id`: The join condition defining how rows correspond to each other.
- Table Aliases: In practice, developers abbreviate table names using aliases for readability (e.g. `FROM users u INNER JOIN orders o ON o.user_id = u.id`).

### Resulting output
| name | order_id | amount |
|------|:--------:|:------:|
| Alice | 101 | 49.00 |
| Alice | 102 | 15.00 |
| Bob | 103 | 99.00 |

*(Charlie is omitted because he has no matching rows in the `orders` table).*

---

## 2. LEFT JOIN — Keep every row from the left table

A **`LEFT JOIN`** (or `LEFT OUTER JOIN`) preserves **every single row** from the left table (`users`), regardless of whether a matching row exists in the right table (`orders`). Where no match exists, the columns from the right table are filled with `NULL`.

```sql
SELECT u.name, o.id AS order_id, o.amount
FROM users u
LEFT JOIN orders o ON o.user_id = u.id;
```

### Resulting output
| name | order_id | amount |
|------|:--------:|:------:|
| Alice | 101 | 49.00 |
| Alice | 102 | 15.00 |
| Bob | 103 | 99.00 |
| **Charlie** | **NULL** | **NULL** |

*(Charlie is preserved, with `NULL` indicating no order records exist).*

---

## 3. Finding missing or orphan records (The Anti-Join)

One of the most powerful real-world uses of `LEFT JOIN` is finding records that have **never** interacted or have missing foreign keys:

```sql
-- Find all users who have never placed an order
SELECT u.name, u.id
FROM users u
LEFT JOIN orders o ON o.user_id = u.id
WHERE o.id IS NULL;
```

### How it works

1. `LEFT JOIN` attaches orders to users, producing `NULL` for `o.id` whenever a user has zero orders.
2. The `WHERE o.id IS NULL` filter eliminates all users who have orders, leaving only the users without orders (in our case: Charlie).

---

## 4. Counting with LEFT JOIN: The `COUNT(*)` trap

When calculating aggregates like "number of orders per user":

```sql
-- WRONG: COUNT(*) counts the row itself, so Charlie would show 1 order!
SELECT u.name, COUNT(*) AS total_orders
FROM users u
LEFT JOIN orders o ON o.user_id = u.id
GROUP BY u.id, u.name;

-- CORRECT: COUNT(o.id) only counts non-NULL order IDs, so Charlie correctly shows 0!
SELECT u.name, COUNT(o.id) AS total_orders
FROM users u
LEFT JOIN orders o ON o.user_id = u.id
GROUP BY u.id, u.name;
```

:::tip
Always use `COUNT(right_table.id)` instead of `COUNT(*)` when aggregating over a `LEFT JOIN` to avoid counting `NULL` rows as 1.
:::

---

## Summary comparison matrix

| JOIN Type | Left Table Rows | Right Table Rows | Unmatched Columns Become |
|-----------|:---------------:|:----------------:|:------------------------:|
| **`INNER JOIN`** | Only if matched | Only if matched | Not returned |
| **`LEFT JOIN`** | **All rows** | Only if matched | `NULL` |
| **`RIGHT JOIN`** | Only if matched | **All rows** | `NULL` |
| **`FULL OUTER JOIN`** | **All rows** | **All rows** | `NULL` |
