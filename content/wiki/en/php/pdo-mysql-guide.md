---
title: PDO and MySQL in PHP — Prepared Statements Done Right
description: Connect with PDO, bind parameters, handle errors as exceptions, and wrap writes in transactions.
category: php
order: 15
tags: [php, pdo, mysql, security]
updated: 2026-10-06
related: [php/getting-started-83, sql/sql-in-10-minutes]
---

## Connect once

```php
<?php
$pdo = new PDO(
    'mysql:host=127.0.0.1;dbname=shop;charset=utf8mb4',
    'shop_app',
    $_ENV['DB_PASSWORD'],
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
);
```

`ERRMODE_EXCEPTION` turns silent failures into catchable errors.
`EMULATE_PREPARES => false` uses real server-side prepares.

## Query with bound parameters

```php
$stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
$stmt->execute(['email' => $email]);
$user = $stmt->fetch();
```

Never interpolate variables into SQL. Bound parameters separate code from data —
this single habit eliminates SQL injection.

## Transactions for multi-step writes

```php
$pdo->beginTransaction();
try {
    $pdo->prepare('UPDATE accounts SET balance = balance - ? WHERE id = ?')
        ->execute([$amount, $from]);
    $pdo->prepare('UPDATE accounts SET balance = balance + ? WHERE id = ?')
        ->execute([$amount, $to]);
    $pdo->commit();
} catch (Throwable $e) {
    $pdo->rollBack();
    throw $e;
}
```

:::warn
One database user per app, with only the privileges it needs (`SELECT,
INSERT, UPDATE` — rarely `DROP` or `GRANT`). The wiki's MySQL section shows
the `GRANT` statements.
:::
