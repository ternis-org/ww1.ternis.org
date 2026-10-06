---
title: SQL Indexes and EXPLAIN — How to Optimize Database Queries
description: Complete beginner guide to understanding B-tree indexes, reading EXPLAIN query plans, avoiding full table scans, and knowing when indexes hurt performance.
category: sql
order: 15
tags: [sql, indexes, performance, explain, database, optimization]
updated: 2026-10-06
related: [sql/sql-in-10-minutes, sql/joins-explained, mysql-mariadb/backup-restore-mysqldump]
---

## The intuition: Book indexes vs Full Table Scans

Imagine searching an 800-page encyclopedia for the term "Cryptography".
- **Without an index (Full Table Scan)**: You must turn and read every single page from page 1 to 800. If the book grows to 10,000 pages, the search takes 12 times longer. In computer science, this is $O(N)$ linear time.
- **With an index (B-Tree Index)**: You flip straight to the back index, locate "Cryptography" under letter 'C', read the exact page number (e.g. page 312), and jump directly to it. This takes $O(\log N)$ logarithmic time.

In databases, an **index** is a sorted, separate data structure (usually a balanced tree, or **B-Tree**) that maps column values directly to the physical storage locations of table rows.

---

## 1. Creating and dropping indexes

You should index columns that appear frequently in `WHERE`, `JOIN ON`, and `ORDER BY` clauses:

```sql
-- Single-column index for foreign keys
CREATE INDEX idx_orders_user_id ON orders (user_id);

-- Unique index for columns that must never contain duplicates
CREATE UNIQUE INDEX idx_users_email ON users (email);

-- Composite (multi-column) index
CREATE INDEX idx_orders_user_status ON orders (user_id, status);

-- Dropping an unnecessary index
DROP INDEX idx_orders_user_id ON orders;
```

### The Leftmost Prefix Rule for composite indexes

If you create a composite index on `(user_id, status)`:
- Queries filtering on `user_id` **can** use the index.
- Queries filtering on `user_id AND status` **can** use the index.
- Queries filtering **only** on `status` **cannot** use this index, because the tree is sorted primarily by `user_id`.

---

## 2. Reading query execution plans with `EXPLAIN`

To see whether a query uses an index or scans millions of rows, prefix your query with `EXPLAIN`:

```sql
EXPLAIN SELECT id, total_amount FROM orders WHERE user_id = 42;
```

### Essential EXPLAIN columns to understand

| Column | What it means | Good values | Dangerous values |
|--------|---------------|:-----------:|:----------------:|
| **`type`** | Join/lookup type | `const`, `eq_ref`, `ref`, `range` | **`ALL`** (Full table scan!) |
| **`possible_keys`** | Indexes the query could use | List of index names | `NULL` |
| **`key`** | The actual index chosen | Your index name | **`NULL`** (No index used) |
| **`rows`** | Estimated rows examined | Small number (e.g. 1 to 50) | Hundreds of thousands |
| **`Extra`** | Diagnostic execution details | `Using index` (Covering index) | `Using filesort`, `Using temporary` |

### Understanding the `type` column hierarchy (Best to Worst):
1. **`const`**: Direct lookup by primary key or unique index (instant 1 row).
2. **`eq_ref`**: One row is read from this table for each row combination from earlier tables.
3. **`ref`**: All matching rows for an indexed non-unique value are fetched (very fast).
4. **`range`**: An index range scan (used for `BETWEEN`, `<`, `>`, `IN`).
5. **`index`**: Full index scan (scans the index tree instead of table).
6. **`ALL`**: **Full table scan.** The database reads every row from disk.

---

## 3. When indexes hurt performance

Indexes are not free:
1. **Write Overhead**: Every `INSERT`, `UPDATE`, and `DELETE` must write to the table **and** update every index tree on that table. Having 15 indexes on a high-velocity table drastically slows down writes.
2. **Disk and RAM Bloat**: Indexes consume storage and compete for space in the database buffer pool memory (`innodb_buffer_pool_size`).
3. **Low Cardinality Columns**: Indexing a column with very few distinct values (e.g., `is_active` which is only `0` or `1`) is rarely beneficial, because the database optimizer usually determines that a table scan is cheaper than reading an index where 50% of rows match.
4. **Leading Wildcards**: Queries like `WHERE name LIKE '%smith'` cannot use standard B-Tree indexes because the leading wildcard hides the alphabetical starting character. Use Full-Text indexing (`FULLTEXT`) instead.
