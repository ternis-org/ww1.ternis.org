---
title: Linux Filesystem Permissions — rwx, chmod, chown, and sudo Hygiene
description: Complete beginner guide to Linux file permissions, user/group ownership, chmod and chown commands and flags, umask, and safe sudo rules.
category: linux
order: 5
tags: [linux, permissions, chmod, chown, sudo, security, sysadmin]
updated: 2026-10-06
related: [linux/ssh-hardening, linux/systemd-services-timers, git-devops/git-crash-course]
---

## Understanding Linux file permissions

Linux is a multi-user operating system. Every file and directory on the filesystem has an **owner user**, an **owning group**, and a set of permission bits defining who is allowed to **read**, **write**, or **execute** it.

When you run `ls -l` in a terminal, each file displays an 10-character permission string like `-rwxr-xr--`:

```text
- rwx r-x r--   1  fabian  developers  4096  Oct 06 12:00  app.sh
│  │   │   │
│  │   │   └── Others (everyone else on the system)
│  │   └────── Group (members of the group 'developers')
│  └────────── User (owner 'fabian')
└───────────── File type: '-' for file, 'd' for directory, 'l' for symlink
```

### The three permission types

| Permission | Symbol | File Meaning | Directory Meaning |
|------------|:------:|--------------|-------------------|
| **Read** | `r` | View the file contents | List files inside directory (`ls`) |
| **Write** | `w` | Modify or overwrite file | Create, delete, or rename files inside |
| **Execute** | `x` | Run file as a program/script | Enter directory (`cd`) and access its files |

---

## Numeric (Octal) permissions explained

Permissions are represented mathematically using binary bits:
- **Read (`r`)** = 4
- **Write (`w`)** = 2
- **Execute (`x`)** = 1
- **None (`-`)** = 0

Add the numbers together to form a 3-digit octal permission code (Owner, Group, Others):

| Octal Code | Permissions | Common Usage |
|:----------:|:-----------:|--------------|
| `755` | `rwxr-xr-x` | Executable scripts, public directories |
| `644` | `rw-r--r--` | Standard text files, web assets (HTML/CSS), images |
| `600` | `rw-------` | Private secrets (SSH private keys, `.env` config files) |
| `700` | `rwx------` | Private directories (e.g. `~/.ssh`) |
| `664` | `rw-rw-r--` | Shared team project files |

---

## Changing permissions with `chmod`

The `chmod` (change mode) command modifies permission bits.

### 1. Using numeric mode

```bash
chmod 755 deploy.sh
chmod 600 ~/.ssh/id_ed25519
chmod -R 755 /var/www/html/
```

#### Command & flag breakdown

- `chmod`: The utility that alters file mode bits.
- `755`: Grants owner read+write+execute (7), group read+execute (5), others read+execute (5).
- `600`: Grants owner read+write (6), nobody else has any access (0, 0).
- `-R` (recursive): Recursively applies the permission change to all files and subdirectories inside the specified directory path.

### 2. Using symbolic mode

You can also add (`+`), remove (`-`), or set (`=`) permissions for User (`u`), Group (`g`), Others (`o`), or All (`a`):

```bash
chmod +x build.sh       # Add execute permission for everyone
chmod g+w shared.txt    # Grant write permission to group members
chmod o-r secret.txt    # Strip read permission from others
```

---

## Changing ownership with `chown`

To change which user or group owns a file or directory, use `chown` (change owner):

```bash
sudo chown www-data:www-data /var/www/app
sudo chown -R www-data:www-data /var/www/app/storage
```

### Command & flag breakdown

- `chown`: Modifies user and/or group ownership.
- `-R`: Recursively applies ownership change through all nested folders and files.
- `www-data:www-data`: Format is `<user>:<group>`. Here, user `www-data` and group `www-data` (the standard web server user) are set as owners.
- If you only want to change the user: `chown user filename`.
- If you only want to change the group: `chown :group filename` (or `chgrp group filename`).

---

## What is `umask`?

`umask` (user file-creation mask) determines default permissions for newly created files and directories. It subtracts permissions from `777` (for directories) and `666` (for files).

```bash
# View current umask (typically 0022 or 0002)
umask

# Set a stricter umask:
umask 027
```

With `027`:
- New directories become `750` (`rwxr-x---`)
- New files become `640` (`rw-r-----`)
- "Others" receive no permissions by default.

---

## Sudo hygiene: Principle of least privilege

Never grant users blanket passwordless root access (`ALL=(ALL) NOPASSWD: ALL`). Instead, scope permissions to specific binaries in `/etc/sudoers.d/`:

```bash
# Create a dedicated sudo rule file
sudo visudo -f /etc/sudoers.d/deploy
```

Inside `/etc/sudoers.d/deploy`:

```text
# Allow user 'deploy' to restart only this specific service without typing password
deploy ALL=(root) NOPASSWD: /usr/bin/systemctl restart myapp
```

### Safety rules for sudoers

1. **Always use `visudo`**: Never edit `/etc/sudoers` with a plain text editor. `visudo` validates syntax before saving; a syntax error in sudoers can lock you out of `sudo` completely.
2. **Use `/etc/sudoers.d/`**: Keep modular drop-in files instead of modifying `/etc/sudoers` directly, so system package upgrades don't overwrite your rules.
3. **Specify full paths**: Always write absolute paths to binaries (e.g. `/usr/bin/systemctl`, not just `systemctl`) to prevent PATH hijacking.

:::warn
**Never use `chmod 777` to fix permissions!** While `777` might make an error message go away, it grants every process and local user on the machine full permission to read, overwrite, or delete that file. Fix the owner (`chown`) or group instead.
:::
