---
title: Git Crash Course — Clone, Branch, Commit, and PR
description: A complete beginner-friendly Git workflow covering essential commands, flags, branch management, and contributing to open-source repositories.
category: git-devops
order: 10
tags: [git, github, contributing, devops, version-control]
updated: 2026-10-06
related: [linux/filesystem-permissions, selfhosting/nginx-reverse-proxy-tls]
---

## What is Git and why do we use it?

Git is a distributed version control system. It tracks changes to files over time so that you can recall specific versions later, compare differences, collaborate with others, and revert mistakes without fear of losing work.

Unlike saving multiple files named `project_final_v2_really_final.zip`, Git creates a chronological history of snapshots called **commits**. Every commit has a unique hash identifier and a message describing what changed.

---

## Step 1: Initial configuration

Before making your first commit, you need to configure your identity. Git embeds this name and email into every snapshot you create.

```bash
git config --global user.name "Your Name"
git config --global user.email "you@example.com"
```

### Command & flag breakdown

- `git config`: Reads and writes configuration options controlling how Git operates.
- `--global`: Tells Git to store these settings in your user home directory (`~/.gitconfig`), applying them across all repositories on your machine. Without `--global`, settings only apply to the current repository directory (`.git/config`).
- `user.name "..."`: Specifies the display name attached to your commit metadata.
- `user.email "..."`: Specifies the email address tied to your commit metadata (this should match your GitHub or GitLab account email so commits link to your profile).

To verify your configuration at any time:

```bash
git config --list
```

---

## Step 2: Cloning an existing repository

To work on an existing project hosted on GitHub (such as `ww1.ternis.org`), you clone a complete copy of the remote repository to your local computer:

```bash
git clone https://github.com/ternis-org/ww1.ternis.org.git
cd ww1.ternis.org
```

### Command & flag breakdown

- `git clone <url>`: Copies the entire repository history, all branches, and files from the remote server down to a new local folder.
- `cd <directory>`: Changes your current shell working directory into the newly created project folder.

---

## Step 3: Creating and switching to a new branch

Never work directly on the `master` or `main` branch when contributing. Creating a feature branch isolates your experimental changes from stable production code.

```bash
git checkout -b wiki/my-new-article
```

*(Modern alternative: `git switch -c wiki/my-new-article`)*

### Command & flag breakdown

- `git checkout`: Changes branches or restores working tree files.
- `-b` (create branch): Tells Git to create a brand new branch with the given name and immediately switch your working directory to it.
- `wiki/my-new-article`: The branch name. Using slashes (like `feat/`, `fix/`, or `wiki/`) is a best practice that visually namespaces your work.

To list all local branches and see which one is currently active:

```bash
git branch
```
The active branch is marked with an asterisk `*`.

---

## Step 4: Staging changes (The Staging Area)

When you create or edit files in your project directory (for example `content/wiki/en/networking/ip-subnetting-cidr.md`), Git marks them as "unstaged" or "untracked". You must explicitly tell Git which files to bundle into your next commit.

```bash
git status
git add content/wiki/
```

### Command & flag breakdown

- `git status`: Shows the working tree status: modified files, untracked files, and what is currently staged for the next commit. Run this frequently!
- `git add <path>`: Adds file contents from your working tree to the staging area (also known as the index).
  - Passing a directory path (like `content/wiki/`) stages all modified and newly created files inside that directory.
  - Passing `.` stages all modified files in the current directory and subdirectories.
  - Passing a specific file path (e.g., `git add file.md`) stages only that single file.

---

## Step 5: Recording a commit

Once your files are staged, record a permanent snapshot with a meaningful description of what was changed:

```bash
git commit -m "docs(wiki): add my-new-article guide"
```

### Command & flag breakdown

- `git commit`: Takes everything currently in the staging area and permanently saves it into the Git repository history.
- `-m "<message>"`: Specifies the commit message inline directly in your terminal. Without `-m`, Git opens your default terminal text editor (like vim or nano) to prompt you for a message.
- Conventional Commit Format: Beginning your message with a prefix such as `docs:`, `fix:`, `feat:`, or `refactor:` helps teammates understand the scope of the change immediately.

:::tip
Commits are cheap and local. Commit small, logical units of work frequently rather than making one giant commit at the end of the week.
:::

---

## Step 6: Pushing to the remote server

Your commit exists only on your local machine until you send it back to GitHub:

```bash
git push -u origin wiki/my-new-article
```

### Command & flag breakdown

- `git push`: Uploads local branch commits to the remote repository.
- `-u` (short for `--set-upstream`): Configures the local branch to track the newly created remote branch. Future pushes on this branch only require typing `git push` without repeating the remote and branch names.
- `origin`: The default alias Git gives to the remote repository you cloned from.
- `wiki/my-new-article`: The name of the remote branch to push to.

---

## Step 7: Opening a Pull Request (PR)

After pushing your branch:

1. Navigate to the repository on GitHub in your web browser.
2. A banner will appear: **"wiki/my-new-article had recent pushes - Compare & pull request"**.
3. Click the button, provide a clear description of your changes, and submit the Pull Request.
4. Maintainers can review your diff, run automated tests, suggest edits, and merge your branch into `master`.

---

## Quick Reference Summary Table

| Command | Key Flags | What it does |
|---------|-----------|--------------|
| `git status` | `-s` (short format) | Shows state of working directory and staging area |
| `git diff` | `--staged` (staged diff) | Shows line-by-line differences before committing |
| `git add <file>` | `-A` (all files) | Moves changes to the staging area |
| `git commit -m "msg"` | `--amend` (modify last) | Records staged changes into repository history |
| `git branch` | `-a` (all, remote + local) | Lists, creates, or deletes branches |
| `git checkout -b <name>` | `-b` (create & checkout) | Creates and switches to a new branch |
| `git pull` | `--rebase` | Fetches and integrates remote changes |
| `git push` | `-u` (set upstream) | Uploads local branch commits to remote |
| `git log` | `--oneline -n 5` | Shows recent commit history |

---

## Contributing rules for this wiki

1. **Frontmatter is required**: Every article must begin with `---` YAML frontmatter defining `title`, `description`, `category`, `order`, `tags`, `updated`, and optional `related`.
2. **Slug convention**: File names must be lowercase with dashes (kebab-case), e.g. `linux-filesystem-permissions.md`.
3. **English first**: All articles require an English version in `content/wiki/en/<category>/`. German translations are welcomed in `content/wiki/de/<category>/`.
4. **Verified code**: Test every command block on a real terminal before submitting your pull request.
