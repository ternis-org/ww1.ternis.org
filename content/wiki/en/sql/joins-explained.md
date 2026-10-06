---
title: SQL JOINs Explained with Code
description: INNER, LEFT, RIGHT and FULL joins with a mental model and copy-paste examples.
category: sql
order: 10
tags: [sql, joins]
updated: 2026-10-06
related: [sql/sql-in-10-minutes]
---

## The mental model

Think of `users LEFT JOIN orders`: keep **every user**, attach orders where
they exist, `NULL` where they don't. `INNER` keeps only rows that match on
both sides.

## Examples

```sql
-- Users WITH orders only
SELECT u.name, o.total
FROM users u
INNER JOIN orders o ON o.user_id = u.id;

-- ALL users, order total or NULL
SELECT u.name, o.total
FROM users u
LEFT JOIN orders o ON o.user_id = u.id;

-- Orders per user, including zero
SELECT u.name, COUNT(o.id) AS orders
FROM users u
LEFT JOIN orders o ON o.user_id = u.id
GROUP BY u.id;
```

:::tip
`LEFT JOIN` + `WHERE right.id IS NULL` finds orphans — e.g. users who never
ordered. It is the most useful debugging join you will write.
:::
