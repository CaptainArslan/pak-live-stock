# Git Secrets Removal Guide — Pak Livestock

**Repository:** `CaptainArslan/pak-live-stock`  
**Date performed:** June 2026  
**What was exposed:** Firebase Web SDK keys hardcoded in `resources/views/auth/phone_register.blade.php` (first commit).  
**What was NOT in Git:** `.env` (gitignored).

---

## 1. Summary

| Step | Tool / action |
|------|----------------|
| Find secrets in history | `git log -S`, `git grep` |
| Rewrite all commits | `git filter-repo` |
| Publish clean history | `git push --force origin main` |
| Keep secrets out going forward | `config/firebase.php` + `.env` + `@json(config('firebase.client'))` |

After cleanup, **rotate Firebase keys** in Firebase Console — removing history does not undo past exposure.

---

## 2. Commands to inspect Git (check for leaked credentials)

Run from the project root:

```bash
cd c:\Users\arslan\Herd\paklivestock
```

### 2.1 Basic repository state

```bash
git status
git log --oneline --all
git log -5 --oneline
git remote -v
git branch -a
```

### 2.2 See file changes

```bash
git diff --stat
git diff --cached --stat
```

### 2.3 Find commits that introduced a secret string

```bash
# Commits that added or removed this text (pickle / search)
git log -p --all -S "AIzaSy" --oneline
```

### 2.4 Search a specific commit

Replace `COMMIT_HASH` with the commit to inspect (e.g. first commit `065adba` before rewrite, or `aa6dcfc` after):

```bash
git grep -n "AIzaSy" COMMIT_HASH
git grep -E "AIzaSy|sk-proj|OPENAI_API_KEY=|DB_PASSWORD=|APP_KEY=base64" COMMIT_HASH
```

### 2.5 Search entire history for patterns

```bash
git grep "AIzaSy" $(git rev-list --all)

git grep -E "sk-proj|OPENAI_API_KEY=|DB_PASSWORD=@|base64:gmX" $(git rev-list --all)
```

### 2.6 Check if `.env` was ever committed

```bash
git show COMMIT_HASH:.env
# If you see: "fatal: path '.env' exists on disk, but not in 'COMMIT_HASH'" — .env was never in that commit (good).
```

### 2.7 List files in a commit related to secrets

```bash
git ls-tree -r COMMIT_HASH --name-only | findstr /i "env phone_register firebase"
```

### 2.8 First commit overview

```bash
git show COMMIT_HASH --stat
```

### 2.9 Where Firebase values appeared (example: first commit)

```bash
git grep "691783202632" COMMIT_HASH
git grep "G-WF7SCP9WNN" COMMIT_HASH
git grep "pakpoultryapp" COMMIT_HASH
```

### 2.10 View a file from an old commit

```bash
git show COMMIT_HASH:resources/views/auth/phone_register.blade.php
```

---

## 3. Commands to remove credentials from Git history

### 3.1 Install `git-filter-repo`

```bash
pip install git-filter-repo
```

Verify (optional):

```bash
python -m git_filter_repo --version
```

> **Note:** `git filter-repo` removes the `origin` remote by default. Save the remote URL first with `git remote -v`.

### 3.2 Create replacements file

Create `.git-filter-repo-replacements.txt` in the project root with:

```text
# Remove hardcoded Firebase Web SDK config from all commits
regex:(?s)  const firebaseConfig = \{\r?\n    apiKey: "[^"]+",\r?\n    authDomain: "[^"]+",\r?\n    projectId: "[^"]+",\r?\n    storageBucket: "[^"]+",\r?\n    messagingSenderId: "[^"]+",\r?\n    appId: "[^"]+",\r?\n    measurementId: "[^"]+"\r?\n  \};==>  const firebaseConfig = @json(config('firebase.client'));
```

This replaces the old inline `firebaseConfig { ... }` block in **every commit** with the env-based version (no API keys in history).

### 3.3 Rewrite history

```bash
cd c:\Users\arslan\Herd\paklivestock
python -m git_filter_repo --replace-text .git-filter-repo-replacements.txt --force
```

Expected notice: `Removing 'origin' remote` — normal.

### 3.4 Verify secrets are gone

```bash
git log --oneline --all

# Should print nothing:
git grep "AIzaSy" $(git rev-list --all)

git grep -E "sk-proj|OPENAI_API_KEY=|DB_PASSWORD=@|base64:gmX" $(git rev-list --all)

# First commit should show @json(config(...)), not hardcoded keys:
git show HEAD~1:resources/views/auth/phone_register.blade.php
```

### 3.5 Re-add remote and force push

```bash
git remote add origin git@github.com:CaptainArslan/pak-live-stock.git

git push --force origin main
```

If `origin` already exists:

```bash
git push --force origin main
```

---

## 4. Commit history before vs after rewrite

| Before rewrite | After rewrite | Message |
|----------------|---------------|---------|
| `065adba` | `aa6dcfc` | first commit |
| `4c8c0fc` | `ee72a00` | Load Firebase client config from environment instead of Blade. |

Anyone with an old clone must reset or re-clone:

```bash
git fetch origin
git reset --hard origin/main
```

---

## 5. Prevent secrets in future commits

### 5.1 Firebase in `.env` (not committed)

`.env` is in `.gitignore`. Add keys in `.env`:

```env
FIREBASE_API_KEY=your_key
FIREBASE_AUTH_DOMAIN=your_project.firebaseapp.com
FIREBASE_PROJECT_ID=your_project_id
FIREBASE_STORAGE_BUCKET=your_project.appspot.com
FIREBASE_MESSAGING_SENDER_ID=your_sender_id
FIREBASE_APP_ID=your_app_id
FIREBASE_MEASUREMENT_ID=your_measurement_id
```

### 5.2 Config file (committed)

`config/firebase.php` reads from `env()` — safe to commit.

### 5.3 Blade template (committed)

`resources/views/auth/phone_register.blade.php`:

```blade
const firebaseConfig = @json(config('firebase.client'));
```

### 5.4 Template for new developers

Commit `.env.example` with empty placeholders (no real values).

### 5.5 Commit Firebase env change (normal commit, not history rewrite)

```bash
git add resources/views/auth/phone_register.blade.php config/firebase.php .env.example
git commit -m "Load Firebase client config from environment instead of Blade." -m "Add config/firebase.php and .env.example placeholders; phone registration reads config via @json so secrets stay in .env only."
git push origin main
```

---

## 6. Post-cleanup checklist

- [ ] Rotate **Firebase API key** and review Firebase Console restrictions (domain/referrer).
- [ ] Rotate any other keys if they were ever in Git (OpenAI, DB, `APP_KEY` — only Firebase was found in this repo’s history).
- [ ] Force push completed: `main` on GitHub matches rewritten local history.
- [ ] Re-clone or `git reset --hard origin/main` on all machines.
- [ ] Check GitHub **Settings → Code security** for secret scanning alerts.
- [ ] Delete or update any **forks** that still contain old history.
- [ ] Delete local `.git-filter-repo-replacements.txt` after use (do not commit it).

---

## 7. Alternative tools (reference)

| Tool | Use case |
|------|----------|
| **git-filter-repo** | Recommended; fast, replaces text or paths across history |
| **BFG Repo-Cleaner** | Replace/delete blobs by pattern |
| **git filter-branch** | Built into Git; slower, legacy |

For this project, `git-filter-repo --replace-text` was used because only one file/block needed changing.

---

## 8. What was found in Pak Livestock history

| Item | In Git history? |
|------|-----------------|
| Firebase keys in `phone_register.blade.php` | Yes (first commit) — **removed** |
| `.env` | No |
| OpenAI key | No (only in local `.env`) |
| Database password | No (only in local `.env`) |

---

*This document describes the inspection and history rewrite performed on the pak-live-stock repository. Keep `.env` out of Git; use `.env.example` for documentation only.*
