---
title: Git Crash Course — Clone, Branch, PR
description: The minimum Git workflow to contribute to this wiki and any ternis.org project.
category: git-devops
order: 10
tags: [git, github, contributing]
updated: 2026-10-06
related: [sql/joins-explained]
---

## Setup once

```bash
git config --global user.name "Your Name"
git config --global user.email "you@example.com"
```

## The loop

```bash
git clone https://github.com/ternis-org/ww1.ternis.org.git
cd ww1.ternis.org
git checkout -b wiki/my-new-article
# edit content/wiki/en/<category>/<slug>.md
git add content/wiki/
git commit -m "docs(wiki): add <slug> article"
git push -u origin wiki/my-new-article
```

Then open a Pull Request on GitHub.

## Contributing rules for this wiki

1. Every article needs frontmatter: `title`, `description`, `category`.
2. Slugs are lowercase-with-dashes, max 80 chars.
3. EN body is required; DE translation may follow in a linked PR.
4. Test code blocks by copy-paste before pushing.
