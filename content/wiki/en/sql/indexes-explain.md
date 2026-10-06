---
title: SQL Indexes and EXPLAIN — Make Queries Fast
description: B-tree intuition, reading EXPLAIN output, and knowing when indexes hurt.
category: sql
order: 15
tags: [sql, indexes, performance, explain]
updated: 2026-10-06
related: [sql/sql-in-10-minutes, sql/joins-explained]
---

## The intuition

Without an index, the database reads **every row** (full table scan). A B-tree
index is a sorted shortcut: lookups drop from O(n) to O(log n). Index the
columns you filter and join on — typically foreign keys and `WHERE` columns.

```sql
CREATE INDEX idx_orders_user ON orders (user_id);
CREATE INDEX idx_users_email ON users (email);
```

## Read EXPLAIN

```sql
EXPLAIN SELECT * FROM orders WHERE user_id = 42;
```

| Column | Good sign | Bad sign |
|--------|-----------|----------|
| `type` | `ref`, `range`, `const` | `ALL` (full scan) |
| `key` | Your index name | `NULL` (no index used) |
| `rows` | Small fraction of table | Near full table size |
| `Extra` | `Using index` | `Using filesort`, `Using temporary` |

## When indexes hurt

- Every index slows `INSERT`/`UPDATE` (more trees to maintain).
- Low-cardinality columns (`is_active` with two values) rarely pay off.
- Leading wildcards (`LIKE '%foo'`) cannot use B-tree indexes — use full-text.

:::tip
Measure before and after with `EXPLAIN ANALYZE` (MySQL 8.0.18+). An index that
feels faster but scans the same rows is decoration, not optimization.
:::
