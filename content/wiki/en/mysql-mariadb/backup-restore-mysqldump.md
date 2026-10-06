---
title: MySQL and MariaDB Backups with mysqldump
description: Complete beginner guide to creating, automating, and restoring database backups using mysqldump and mariadb-dump with comprehensive command and flag breakdowns.
category: mysql-mariadb
order: 20
tags: [mysql, mariadb, backup, mysqldump, sysadmin, database]
updated: 2026-10-06
related: [mysql-mariadb/choosing-mysql-vs-mariadb, sql/sql-in-10-minutes, linux/systemd-services-timers]
---

## Why backups are mandatory

A database is the heart of most web applications. Hardware failure, ransomware, buggy application migrations, or an accidental `DROP TABLE` can wipe out business data in seconds.

**`mysqldump`** (or **`mariadb-dump`** in MariaDB) is the standard utility for generating logical backups. It exports database structures and data as plain-text SQL statements (`CREATE TABLE`, `INSERT INTO`) that can be replayed to reconstruct the database.

---

## 1. Backing up a single database

To back up an individual database into a compressed `.sql.gz` archive:

```bash
mysqldump -u root -p --single-transaction --quick --routines --triggers mydatabase | gzip > /backups/mydatabase-$(date +%F).sql.gz
```

### Command & flag breakdown

- `mysqldump`: The database export utility.
- `-u root`: Specifies the database username to connect with.
- `-p`: Prompts securely for the database password.
- `--single-transaction`: **Crucial for InnoDB tables.** Instructs the server to create an isolated database transaction snapshot before dumping data. This allows the backup to run consistently without locking tables or interrupting active website traffic.
- `--quick`: Tells `mysqldump` to stream rows from the database server row-by-row rather than buffering all rows into RAM before writing. This prevents your server from running out of memory on large tables.
- `--routines`: Includes stored procedures and functions in the export.
- `--triggers`: Includes database triggers in the export.
- `mydatabase`: The name of the specific database schema to dump.
- `| gzip`: Pipes the text stream through gzip compression, reducing backup file sizes by up to 80-90%.
- `> /backups/...`: Redirects output into a file on disk.
- `$(date +%F)`: Bash command substitution inserting the current date in ISO format (e.g. `2026-10-06`).

---

## 2. Backing up all databases on the server

To back up every database, schema, and user grant table across the entire database server:

```bash
mysqldump -u root -p --all-databases --single-transaction --quick --routines --triggers | gzip > /backups/all-databases-$(date +%F).sql.gz
```

### Command & flag breakdown

- `--all-databases`: Dumps all database schemas, including system configuration and user privilege tables (`mysql` schema).

---

## 3. Restoring from a backup

A backup that has never been restored is only a theory. Regularly test your restore procedures on a staging server.

To restore an uncompressed or gzipped backup into a database:

```bash
# 1. Create a clean database target if it does not already exist
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS mydatabase_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 2. Decompress and stream the SQL statements into mysql
gunzip -c /backups/mydatabase-2026-10-06.sql.gz | mysql -u root -p mydatabase_test
```

### Command & flag breakdown

- `mysql -e "..."`: Executes the SQL query inside quotes and immediately exits.
- `gunzip -c`: Decompresses the `.gz` file and writes the plaintext SQL stream to standard output (`stdout`) without deleting the original compressed backup archive.
- `| mysql -u root -p mydatabase_test`: Pipes the SQL stream directly into the MySQL client, executing all table creation and data insertion statements into the specified database.

---

## 4. Automating backups securely with `.my.cnf`

Never put database passwords directly in bash scripts or crontabs where `ps aux` or shell histories could expose them. Instead, use an authentication options file:

Create a file named `/root/.my.cnf` with strict `600` permissions:

```ini
[client]
user=backup_user
password="YourStrongSecurePasswordHere"
```

Lock down file permissions so only root can read it:

```bash
chmod 600 /root/.my.cnf
```

Now, `mysqldump` and `mysql` will automatically authenticate without prompting for a password or needing `-p`.

### Backup cron script

Create `/usr/local/bin/db-backup.sh`:

```bash
#!/usr/bin/env bash
set -euo pipefail

BACKUP_DIR="/backups/mysql"
mkdir -p "$BACKUP_DIR"
DATE=$(date +%Y-%m-%d_%H%M%S)

# Dump and compress
mysqldump --single-transaction --quick --routines --triggers --all-databases | gzip > "$BACKUP_DIR/full-$DATE.sql.gz"

# Retain only the last 14 days of backups (cleanup old dumps)
find "$BACKUP_DIR" -type f -name "full-*.sql.gz" -mtime +14 -delete
```

Make the script executable:

```bash
chmod 700 /usr/local/bin/db-backup.sh
```

---

## The 3-2-1 backup rule

1. **3 copies of your data**: Production database, primary local backup, secondary off-site backup.
2. **2 different storage media**: e.g., Local NVMe storage + Remote Object Storage (S3 / B2).
3. **1 copy off-site**: If the datacenter or VPS provider has a physical incident, your off-site copy remains intact.
