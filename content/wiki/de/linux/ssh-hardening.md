---
title: SSH-Hardening — Keys, sshd_config und Brute-Force-Schutz
description: Schritt-für-Schritt-Anleitung zur Absicherung von SSH auf Linux-Servern mit Ed25519-Keys, Deaktivierung von Passwörtern und Daemon-Härtung.
category: linux
order: 10
tags: [linux, ssh, security, hardening, sysadmin, devops]
updated: 2026-10-06
related: [ubuntu/ufw-basics, linux-packages/fail2ban, linux/filesystem-permissions]
---

## Warum SSH gehärtet werden muss

**SSH (Secure Shell)** ist das zentrale Administrationswerkzeug für Linux-Server. Weil Port 22 öffentlich im Internet erreichbar ist, scannen automatische Bots das Netz rund um die Uhr mit Wörterbüchern gängiger Benutzernamen (`root`, `admin`) und Standardpasswörtern ab.

Eine saubere SSH-Absicherung beruht auf drei Säulen:
1. **Kryptografische Schlüssel-Authentifizierung** (ersetzt erratbare Passwörter).
2. **Deaktivierung direkter Root-Logins** (Angreifer können nicht direkt das Superuser-Konto anvisieren).
3. **Konfigurationshärtung des SSH-Daemons** (Timeouts verkürzen, Login-Versuche begrenzen).

---

## Schritt 1: Modernes Ed25519-Schlüsselpaar generieren

Erstelle auf deinem **lokalen Rechner** (nicht auf dem Server) ein Ed25519-Schlüsselpaar. Ed25519 bietet im Vergleich zu klassischem RSA höhere Sicherheit, kompaktere Schlüssel und Schutz vor Seitenkanalangriffen:

```bash
ssh-keygen -t ed25519 -C "du@example.com"
```

### Erklärung der Befehle und Flags

- `ssh-keygen`: Das Standardprogramm zur Generierung von OpenSSH-Schlüsselpaaren.
- `-t ed25519`: Legt den Verschlüsselungsalgorithmus fest. `ed25519` ist der moderne Standard.
- `-C "du@example.com"`: Hinterlegt einen beschreibenden Kommentar im Public Key, um den Schlüssel später in `authorized_keys` leicht zuordnen zu können.
- Passphrase: **Verwende immer eine Passphrase!** Sie verschlüsselt deinen privaten Schlüssel auf der Festplatte deines Laptops gegen Diebstahl.

Dabei entstehen zwei Dateien in `~/.ssh/`:
- `id_ed25519` (Private Key): **Niemals weitergeben.** Dateirechte müssen `600` sein.
- `id_ed25519.pub` (Public Key): Dieser öffentliche Schlüssel wird auf den Server kopiert.

---

## Schritt 2: Public Key auf den Server übertragen

Installiere deinen öffentlichen Schlüssel auf dem Zielserver:

```bash
ssh-copy-id -i ~/.ssh/id_ed25519.pub benutzer@server-ip
```

### Erklärung der Befehle und Flags

- `ssh-copy-id`: Kopiert deinen öffentlichen Schlüssel automatisch in die Datei `~/.ssh/authorized_keys` des Zielbenutzers auf dem Server.
- `-i <pfad>`: Spezifiziert den genauen Pfad zum öffentlichen Schlüssel.
- `benutzer@server-ip`: Zielbenutzer und IP-Adresse deines Servers.

---

## Schritt 3: `/etc/ssh/sshd_config` absichern

Bearbeite auf dem Server die SSH-Konfiguration:

```bash
sudo nano /etc/ssh/sshd_config
```

Hinterlege die folgenden Sicherheitsdirektiven:

```text
# Passwort-Authentifizierung vollständig abschalten
PasswordAuthentication no
ChallengeResponseAuthentication no

# Direkten Root-Login verbieten
PermitRootLogin no

# Nur Public-Key-Logins erlauben
PubkeyAuthentication yes

# Verbindungslimits & Versuche drosseln
MaxAuthTries 3
LoginGraceTime 30
X11Forwarding no

# Optional: Nur bestimmte Benutzer zulassen
AllowUsers deploy fabian
```

### Erklärung der Direktiven

- `PasswordAuthentication no`: Schaltet Passwörter ab. Brute-Force-Angriffe laufen ins Leere, da der Server keine Passwörter mehr abfragt.
- `PermitRootLogin no`: Verbietet die direkte Anmeldung als `root`. Man meldet sich als normaler Benutzer mit `sudo`-Berechtigung an.
- `PubkeyAuthentication yes`: Aktiviert schlüsselbasierte Anmeldungen.
- `MaxAuthTries 3`: Trennt die Verbindung nach 3 Fehlversuchen.
- `LoginGraceTime 30`: Trennt unauthentifizierte Verbindungen nach 30 Sekunden Inaktivität.
- `X11Forwarding no`: Deaktiviert die Weiterleitung grafischer Fenster.
- `AllowUsers`: Lässt ausschließlich die hier gelisteten Benutzernamen zu.

---

## Schritt 4: Syntax testen und sicher neu starten

:::warn
**Schließe niemals deine bestehende SSH-Sitzung, bevor du die neue Konfiguration in einem zweiten Terminalfenster erfolgreich getestet hast!**
:::

Teste immer zuerst die Konfigurationssyntax auf Fehler:

```bash
# 1. Syntax prüfen
sudo sshd -t

# 2. Dienst neu starten
sudo systemctl restart ssh    # Auf Debian/Ubuntu
# bzw.: sudo systemctl restart sshd   # Auf RHEL/CentOS
```

### Erklärung der Befehle und Flags

- `sshd -t`: **Test-Modus**. Prüft die Konfigurationsdateien auf Tippfehler. Gibt der Befehl nichts aus, ist die Syntax fehlerfrei.
- `systemctl restart ssh`: Startet den SSH-Daemon mit der neuen Konfiguration neu.

Öffne jetzt ein **neues, separates Terminalfenster** auf deinem lokalen Rechner:

```bash
ssh benutzer@server-ip
```

Wenn der Login reibungslos per Key funktioniert, ist dein Server optimal geschützt.

---

## Schritt 5: Sicherheitsprüfungen durchführen

```bash
# 1. Testen, ob Passwörter abgelehnt werden (Ergebnis: Permission denied (publickey))
ssh -o PreferredAuthentications=password benutzer@server-ip

# 2. Testen, ob Root abgewiesen wird
ssh root@server-ip

# 3. Authentifizierungs-Logs ansehen
sudo journalctl -u ssh -n 20 --no-pager
```
