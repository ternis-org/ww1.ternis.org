---
title: PDO and MySQL in PHP — Prepared Statements Done Right
description: Complete beginner guide to secure database access in PHP with PDO, eliminating SQL injection with prepared statements, connection options, and transactions.
category: php
order: 15
tags: [php, pdo, mysql, mariadb, security, database, backend]
updated: 2026-10-06
related: [php/getting-started-83, sql/sql-in-10-minutes, mysql-mariadb/backup-restore-mysqldump]
---

## What is PDO and why use it?

**PDO (PHP Data Objects)** is the modern, secure database abstraction layer built directly into PHP.

Unlike legacy functions (like the deprecated `mysql_*` functions removed in PHP 7), PDO provides:
1. **Immunity to SQL Injection** through parameterized prepared statements.
2. **Unified Object-Oriented API** across MySQL, MariaDB, PostgreSQL, and SQLite.
3. **Structured Error Handling** via PHP Exceptions (`PDOException`).

---

## Step 1: Connecting securely with PDO

Establish your database connection by configuring a **DSN (Data Source Name)** with strict security attributes:

```php
<?php
declare(strict_types=1);

$dsn = 'mysql:host=127.0.0.1;port=3306;dbname=myapp;charset=utf8mb4';
$username = 'app_user';
$password = $_ENV['DB_PASSWORD'] ?? 'secret';

$options = [
    // 1. Throw exceptions immediately on SQL errors instead of silent failures
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

    // 2. Return database rows as clean associative arrays ($row['column'])
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

    // 3. Enforce true native database server prepared statements
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    // Log the error internally; never reveal database credentials to the user
    error_log('Database connection failed: ' . $e->getMessage());
    die('A database error occurred. Please try again later.');
}
```

### Breakdown of PDO connection options

- `mysql:host=127.0.0.1`: Connects over TCP/IP to port 3306.
- `charset=utf8mb4`: **Critical for security and Unicode.** Standard `utf8` in MySQL only supports up to 3 bytes per character. `utf8mb4` supports full 4-byte UTF-8 (emojis, international alphabets) and prevents multibyte truncation attacks.
- `PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION`: By default, PDO returns `false` when a query fails. This option transforms every SQL syntax error or failed query into a catchable `PDOException`.
- `PDO::ATTR_EMULATE_PREPARES => false`: Tells PDO to let MySQL's server engine handle the preparation and parameter binding, rather than having PHP simulate parameter interpolation locally.

---

## Step 2: Querying with Prepared Statements

:::warn
**Never concatenate or interpolate variables directly into SQL queries!**
`$sql = "SELECT * FROM users WHERE email = '$email'";` is the #1 vulnerability on the internet. An attacker entering `' OR '1'='1` can bypass login authentication completely.
:::

Always separate the SQL structure from the user data using **Prepared Statements**:

```php
// 1. Prepare the query blueprint with a named placeholder (:email)
$stmt = $pdo->prepare('SELECT id, name, password_hash FROM users WHERE email = :email LIMIT 1');

// 2. Execute by passing data array separately
$stmt->execute(['email' => $userEmail]);

// 3. Fetch the single matching record
$user = $stmt->fetch();

if ($user) {
    echo 'Found user: ' . htmlspecialchars($user['name']);
} else {
    echo 'No user with that email address.';
}
```

### How prepared statements stop SQL Injection

1. During `prepare()`, the database server compiles the SQL logic without knowing the actual values.
2. During `execute()`, user data is transmitted across the wire in a separate data channel. The database treats it strictly as a literal text value—it can never alter the syntax or logic of the query, making SQL injection mathematically impossible.

---

## Step 3: Fetching Multiple Rows

To fetch a list of multiple records (e.g. products or blog posts):

```php
$stmt = $pdo->prepare('SELECT id, title, price FROM products WHERE category_id = ? ORDER BY price ASC');
$stmt->execute([$categoryId]); // Using positional parameter (?)

// Returns all rows as an array of associative arrays
$products = $stmt->fetchAll();

foreach ($products as $product) {
    echo '<li>' . htmlspecialchars($product['title']) . ': €' . number_format($product['price'], 2) . '</li>';
}
```

---

## Step 4: ACID Transactions for Multi-Step Writes

When executing financial transfers or multi-table updates where either **all statements must succeed** or **none at all**, wrap them in a transaction:

```php
$pdo->beginTransaction();

try {
    // 1. Deduct money from sender
    $stmt1 = $pdo->prepare('UPDATE accounts SET balance = balance - :amount WHERE id = :sender_id');
    $stmt1->execute(['amount' => 50.00, 'sender_id' => 1]);

    // 2. Credit money to recipient
    $stmt2 = $pdo->prepare('UPDATE accounts SET balance = balance + :amount WHERE id = :recipient_id');
    $stmt2->execute(['amount' => 50.00, 'recipient_id' => 2]);

    // 3. Commit permanent changes to disk
    $pdo->commit();
} catch (Throwable $e) {
    // If anything threw an error, rollback all changes cleanly
    $pdo->rollBack();
    error_log('Transaction failed: ' . $e->getMessage());
    throw $e;
}
```
