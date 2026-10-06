---
title: SQL in 10 Minuten — Deine ersten Abfragen und Kernkonzepte
description: Einsteigerfreundlicher Leitfaden zu SQL-Abfragen, Ausführungsreihenfolge, SELECT, WHERE, ORDER BY, LIMIT, NULL-Logik, Gruppierung und Transaktionen.
category: sql
order: 5
tags: [sql, datenbank, select, abfragen, einsteiger, tutorial]
updated: 2026-10-06
related: [sql/joins-explained, sql/indexes-explain, mysql-mariadb/backup-restore-mysqldump]
---

## Was ist SQL?

**SQL (Structured Query Language)** ist die weltweite Standardsprache zur Kommunikation mit relationalen Datenbanken wie PostgreSQL, MySQL, MariaDB und SQLite.

In relationalen Datenbanken gilt:
- Daten liegen strukturiert in **Tabellen**.
- Jede Tabelle hat feste **Spalten** (Attribute wie `id`, `name`, `email`) und dynamische **Zeilen** (Datensätze).

---

## 1. Aufbau einer SELECT-Abfrage

Eine typische Abfrage zum Abrufen aktiver Benutzer sortiert nach Erstellungsdatum:

```sql
SELECT id, name, email
FROM users
WHERE status = 'active'
ORDER BY created_at DESC
LIMIT 10 OFFSET 0;
```

### Schreibweise vs. interne Ausführungsreihenfolge

Datenbanken führen SQL-Klauseln in einer logischen Reihenfolge aus, die von der geschriebenen Reihenfolge abweicht:

| Schritt | Klausel | Was im Hintergrund geschieht |
|:-------:|---------|------------------------------|
| **1** | `FROM users` | Die Datenbank bestimmt die Quelltabelle. |
| **2** | `WHERE status = 'active'` | Filtert die Zeilen. Nur Datensätze, die TRUE ergeben, bleiben erhalten. |
| **3** | `SELECT id, name, email` | Wählt die gewünschten Spalten für das Ergebnis aus. |
| **4** | `ORDER BY created_at DESC` | Sortiert die verbliebenen Zeilen (`DESC` = absteigend, neueste zuerst). |
| **5** | `LIMIT 10 OFFSET 0` | Beschränkt die Anzahl der Treffer (ideal für Pagination). |

### Klauseln im Detail

- `SELECT`: Gibt an, welche Spalten zurückgegeben werden. Verwende gezielte Spaltennamen statt `SELECT *`, um Bandbreite und Arbeitsspeicher zu schonen.
- `FROM`: Nennt die Zieltabelle.
- `WHERE`: Filterbedingung für Zeilen.
- `ORDER BY`: Sortierung (`ASC` aufsteigend, `DESC` absteigend).
- `LIMIT`: Maximale Trefferanzahl.
- `OFFSET`: Überspringt eine bestimmte Anzahl von Datensätzen.

---

## 2. Filterbedingungen

```sql
-- Textsuche mit Wildcards per LIKE (% steht für beliebige Zeichen)
SELECT name FROM products WHERE name LIKE 'Pro%';

-- Listenvergleich per IN
SELECT * FROM orders WHERE status IN ('shipped', 'delivered');

-- Wertebereiche per BETWEEN
SELECT * FROM products WHERE price BETWEEN 10.00 AND 50.00;
```

---

## 3. Die `NULL`-Falle: Dreiwertige Logik

In SQL bedeutet `NULL` **nicht** Null (0), false oder leerer Text, sondern **"unbekannt"** (fehlender Wert).

Vergleiche mit `NULL` liefern weder TRUE noch FALSE, sondern UNKNOWN:

```sql
-- FALSCH: Findet NIEMALS Zeilen mit NULL als E-Mail!
SELECT * FROM users WHERE email != 'test@example.com';

-- RICHTIG: Explizite Abfrage auf NULL mit IS NULL / IS NOT NULL
SELECT * FROM users WHERE email != 'test@example.com' OR email IS NULL;
```

:::warn
Verwende niemals `= NULL` oder `!= NULL`. Nutze immer `IS NULL` oder `IS NOT NULL`.
:::

---

## 4. Aggregationen und Gruppierungen: GROUP BY und HAVING

- `COUNT(*)`: Zählt Treffer.
- `SUM(spalte)`: Summiert Werte.
- `AVG(spalte)`: Bildet den Durchschnitt.

```sql
SELECT status, COUNT(*) AS anzahl, AVG(gesamtbetrag) AS durchschnitt
FROM orders
WHERE created_at >= '2026-01-01'
GROUP BY status
HAVING COUNT(*) > 5;
```

### Der Unterschied zwischen `WHERE` und `HAVING`

- `WHERE`: Filtert Datensätze **vor** der Gruppierung.
- `HAVING`: Filtert die aggregierten Gruppen **nach** der Gruppierung.

---

## 5. Vor Missgeschicken schützen: Transaktionen

```sql
-- 1. Transaktion starten
START TRANSACTION;

-- 2. Änderung ausführen
UPDATE users SET status = 'inactive' WHERE last_login < '2025-01-01';

-- 3. Ergebnis prüfen
SELECT COUNT(*) FROM users WHERE status = 'inactive';

-- 4a. Bei Fehlern alles rückgängig machen:
ROLLBACK;

-- 4b. Nur wenn alles korrekt ist, dauerhaft speichern:
-- COMMIT;
```
