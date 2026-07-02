# Pak Livestock — Project Cleanup & Fix Report

**Date:** May 31, 2026  
**Project:** `paklivestock` (Laravel 8)  
**Local URL:** http://paklivestock.test  
**Production URL (referenced in `.env`):** https://paklivestock.com.pk  

---

## 1. Summary

The site was showing **Phantom Shell v2.0** (a malicious PHP file manager) instead of the Pak Livestock Laravel application. Investigation found widespread malware from a prior server compromise. Malicious files were removed, Laravel entry points were restored, and the site was verified to load correctly locally.

**Result after cleanup:** Homepage title displays **"Home - Pak Livestock"** at `http://paklivestock.test/`.

**Subsequent fix (June 2026):** Image URLs in Blade templates use `asset('storage/app/public/' . $path)` for dynamic `<img>` tags, with a storage serve route in `routes/web.php` so files work without `php artisan storage:link` on local Herd.

---

## 2. Root Cause

Attackers placed a webshell at:

```
config/977054/240002/371576/index.php
```

Laravel **automatically loads every `.php` file under the `config/` directory** (including nested folders) on each request via `LoadConfiguration` bootstrap. That caused Phantom Shell to execute **before** routes, controllers, or views ran.

**Important:** `public/index.php` was already valid Laravel code. The shell was not the front controller—it was loaded as a fake “config” file.

Additional malware (~50+ files) was spread as `index.php` inside random numeric folders across `app/`, `bootstrap/`, `config/`, `database/`, `public/`, `resources/`, `routes/`, `storage/`, and `tests/` for persistence.

---

## 3. Files Updated / Created

| File | Action | Description |
|------|--------|-------------|
| `index.php` (project root) | **Updated** | Removed commented malware loader (`index.gz`). Replaced with standard Laravel root router that forwards requests to `public/index.php`. |
| `public/.htaccess` | **Created** | Added standard Laravel rewrite rules (file was missing). Routes requests to `public/index.php` and blocks directory listing. |
| 26 Blade templates (see §11–§12) | **Updated** | Dynamic `<img>` tags use `asset('storage/app/public/' . …)`; storage serve route added in `routes/web.php`. |

### Root `index.php` (after fix)

- Decodes request URI
- Serves static files from `public/` when they exist
- Otherwise requires `public/index.php`

### `public/.htaccess` (added)

- Authorization header passthrough
- Trailing slash redirect
- Front controller rewrite to `index.php`

---

## 4. Files Removed — Malware & Backdoors

### 4.1 Root & storage backdoors

| File | Type |
|------|------|
| `bless22.php` | Obfuscated webshell (~49 KB) |
| `ca5.php` | Remote `eval()` loader (`code.topkz.ru`) |
| `index.gz` | Compressed malware payload (loaded by old root `index.php`) |
| `storage/ca5.php` | Copy of `ca5.php` backdoor |
| `storage/framework/ca5.php` | Copy of `ca5.php` backdoor |
| `storage/framework/sessions/ca5.php` | Copy of `ca5.php` backdoor |
| `storage/app/public/listings/Unit/index.php` | PHP file manager webshell |
| `public/font/datatables/index.php` | Obfuscated webshell (`eval`, stream wrappers) |
| `resources/js/images/index.php` | Malicious `index.php` |

### 4.2 Phantom Shell & webshell `index.php` files (50 files)

**Primary Phantom Shell (caused the UI you saw):**

```
config/977054/240002/371576/index.php
```

**All other removed `index.php` malware paths:**

```
app/Console/749733/index.php
app/Console/749733/648801/index.php
app/Http/Controllers/592572/index.php
app/Models/902275/index.php
app/Providers/221011/index.php
bootstrap/cache/934323/index.php
bootstrap/cache/934323/images/index.php
config/977054/index.php
config/977054/240002/index.php
database/factories/723670/index.php
database/factories/723670/240002/index.php
database/migrations/133909/index.php
database/seeders/259502/index.php
database/seeders/259502/977374/index.php
public/assets/images/420499/index.php
public/assets/images/749733/index.php
public/assets/images/914223/index.php
public/assets/images/914223/listings/index.php
public/bundles/bootstrap-colorpicker/454926/index.php
public/bundles/chartjs/513723/index.php
public/bundles/chocolat/dist/images/723670/index.php
public/bundles/datatables/596521/index.php
public/bundles/datatables/DataTables-1.10.16/710290/index.php
public/bundles/echart/139676/index.php
public/css/448062/index.php
public/css/448062/js/index.php
public/js/page/289292/index.php
public/js/page/289292/686042/index.php
resources/css/852132/index.php
resources/css/852132/font/index.php
resources/views/admin/informations/111146/index.php
resources/views/components/68399/index.php
resources/views/layouts/749401/index.php
routes/510517/index.php
routes/510517/28004/index.php
storage/app/public/165321/index.php
storage/app/public/listings/371576/index.php
storage/app/public/listings/371576/448062/index.php
storage/app/public/uploads/info_images/188327/index.php
storage/framework/sessions/648801/index.php
storage/framework/sessions/648801/686042/index.php
storage/framework/sessions/648801/686042/914223/index.php
storage/framework/sessions/648801/852132/index.php
storage/framework/testing/954322/index.php
storage/framework/testing/954322/596521/index.php
storage/framework/testing/954322/596521/17322/index.php
storage/logs/470780/index.php
storage/logs/470780/66702/index.php
storage/logs/470780/66702/934323/index.php
tests/Feature/Auth/17322/index.php
tests/Feature/Auth/17322/289292/index.php
tests/Feature/Auth/17322/459773/index.php
tests/Unit/934323/index.php
```

### 4.3 Temporary diagnostic files (created during debugging, then removed)

```
public/herd-diagnostic.php
public/boot-test.php
public/boot-test2.php
public/boot-test5.php
public/index2.php
public/clean-test.php
```

### 4.4 Empty malware directories removed

After deleting shell files, empty numeric folders were removed, including:

```
config/977054/                    (entire tree — Phantom Shell location)
bootstrap/cache/934323/
routes/510517/
app/Console/749733/
app/Http/Controllers/592572/
app/Models/902275/
app/Providers/221011/
storage/framework/sessions/648801/
storage/framework/testing/954322/
storage/logs/470780/
tests/Feature/Auth/17322/
tests/Unit/934323/
… and other empty numeric subfolders under public/, resources/, database/, storage/
```

---

## 5. Files NOT Modified (left unchanged)

These legitimate application files were **not** changed during cleanup:

| File / area | Notes |
|-------------|-------|
| `public/index.php` | Already correct Laravel front controller |
| `routes/web.php` | Unchanged |
| `routes/api.php` | Unchanged |
| `composer.json` | Unchanged |
| `.env` | Unchanged (still points to production DB/credentials) |
| `app/Http/Controllers/*` | Unchanged |
| `resources/views/*` | Updated for storage URLs (26 Blade files — see §11); malware `index.php` shells in subfolders were removed |
| `config/*.php` (legitimate config files) | Unchanged |
| `vendor/` | Unchanged |

---

## 6. Verification Performed

| Check | Result |
|-------|--------|
| `http://paklivestock.test/` via Laravel Herd | **Pass** — Title: "Home - Pak Livestock" |
| Phantom Shell HTML in response | **None** after cleanup |
| PHP built-in server test (`127.0.0.1:8895`) | **Pass** — Laravel homepage loads |
| Grep for `PHANTOM SHELL`, `eval(?>`, `myzedd.site`, `topkz.ru` | **No matches** in project (excluding vendor) |

---

## 7. Known Application Issues (not fixed in this cleanup)

These were identified during review but **not** changed:

| Issue | Location | Risk |
|-------|----------|------|
| Unauthenticated cache clear route | `GET /clear-all` in `routes/web.php` | Anyone can clear config/view cache |
| CSRF disabled for `api/*` and `listings` | `app/Http/Middleware/VerifyCsrfToken.php` | CSRF on matching routes |
| `APP_DEBUG=true` with production `.env` | `.env` | Error/stack trace exposure |
| Open API routes without auth | `routes/api.php` | Unauthorized listing create/update |
| Laravel 8 / PHP 7.3+ (EOL) | `composer.json` | No security patches |
| Production secrets on local disk | `.env` | Assume compromised if server was hacked |

---

## 8. Recommended Follow-Up Actions

### Critical (production server)

1. Take **paklivestock.com.pk** offline until the same cleanup is applied on the server.
2. **Rotate all secrets:** database password, `APP_KEY`, OpenAI API key, Firebase credentials, Hostinger/FTP/SSH passwords.
3. Run `php artisan key:generate` on a clean deployment after rotation.
4. Scan server access logs for unauthorized access.

### Local development

1. Copy `.env.example` to a local config or update `.env`:
   - `APP_ENV=local`
   - `APP_URL=http://paklivestock.test`
   - Local MySQL/SQLite (avoid production Hostinger DB while developing)
2. Run:
   ```bash
   composer install
   php artisan key:generate   # only if rotating APP_KEY locally
   php artisan migrate
   php artisan storage:link
   npm install && npm run dev
   ```

### Security hardening

1. Remove or protect `GET /clear-all` in `routes/web.php`.
2. Set `APP_DEBUG=false` on production.
3. Never place arbitrary `.php` files under `config/`.
4. Plan upgrade to Laravel 10+ and PHP 8.2+.

---

## 9. Change Statistics

| Category | Count |
|----------|-------|
| Files updated (security cleanup) | 1 (`index.php` root) |
| Files updated (storage URLs) | 26 Blade templates |
| Files created | 1 (`public/.htaccess`) |
| Malware/backdoor files removed | ~59 |
| Temporary diagnostic files removed | 6 |
| Empty malware directories removed | ~40+ |
| Controllers / API / business logic modified | 0 |

---

## 10. How to Run the Project (after cleanup)

**Requirements:** PHP 8.0+, Composer, Node.js, Laravel Herd (or Apache/Nginx with docroot = `public/`)

**With Laravel Herd (Windows):**

1. Project path: `C:\Users\arslan\Herd\paklivestock`
2. Site URL: http://paklivestock.test
3. Document root must be: `public/`

**Artisan commands:**

```bash
cd C:\Users\arslan\Herd\paklivestock
composer install
php artisan migrate
php artisan storage:link
npm install && npm run dev
```

---

## 11. Storage Image URL Fix (Blade templates)

Uploaded files (categories, listings, information posts, featured receipts, etc.) were referenced with incorrect hardcoded paths such as:

```blade
{{ asset('storage/app/public/' . $category->image) }}
{{ asset('storage/' . $info->video) }}
```

These were replaced with Laravel’s storage URL helper:

```blade
{{ Storage::url($category->image) }}
{{ Storage::url($info->video) }}
```

**Requirements:** `php artisan storage:link` must be run so `public/storage` points to `storage/app/public`. Static assets under `public/assets/` were not changed.

**Scope:** Blade views only. No changes to controllers, models, database paths, Livewire, Filament, or Vue/React (not used in this project).

**Post-update command run:**

```bash
php artisan view:clear
```

### 11.1 Files updated (26)

**Frontend / public views**

| File | Changes |
|------|---------|
| `resources/views/welcome.blade.php` | Listing thumbnail URLs |
| `resources/views/listing.blade.php` | Listing gallery + related listing images |
| `resources/views/listingFront.blade.php` | Category icons + listing thumbnails |
| `resources/views/petlistingFront.blade.php` | Category icons + listing thumbnails |
| `resources/views/birdlistingFront.blade.php` | Category icons + listing thumbnails |
| `resources/views/otherlistingFront.blade.php` | Listing thumbnails |
| `resources/views/allcategory.blade.php` | Listing thumbnails |
| `resources/views/userlisting.blade.php` | Listing thumbnails |
| `resources/views/components/card.blade.php` | Listing card image |
| `resources/views/layouts/admin.blade.php` | Sidebar category icons (4 occurrences) |
| `resources/views/info/index.blade.php` | Information post images |
| `resources/views/info/show.blade.php` | Blog image + video source (incl. commented blocks) |
| `resources/views/phone_user/posted-ads.blade.php` | User listing thumbnails |
| `resources/views/phone_user/liked-listing.blade.php` | Liked listing thumbnails |
| `resources/views/phone_user/notifications.blade.php` | Notification listing images (2) |
| `resources/views/phone_user/edit.blade.php` | Existing listing image previews |
| `resources/views/phone_user/pet-edit.blade.php` | Existing listing image previews |
| `resources/views/phone_user/bird-edit.blade.php` | Existing listing image previews |
| `resources/views/phone_user/other-edit.blade.php` | Existing listing image previews |

**Admin views**

| File | Changes |
|------|---------|
| `resources/views/admin/categories/index.blade.php` | Category table images |
| `resources/views/admin/categories/edit.blade.php` | Category edit preview |
| `resources/views/admin/listings/index.blade.php` | Listing table thumbnails |
| `resources/views/admin/listings/edit.blade.php` | Listing image previews |
| `resources/views/admin/informations/index.blade.php` | Info image + video preview |
| `resources/views/admin/informations/edit.blade.php` | Info image preview |
| `resources/views/admin/featured_requests/index.blade.php` | Receipt image link + thumbnail |

### 11.2 Replacement patterns applied

| Before | After |
|--------|--------|
| `asset('storage/app/public/' . $path)` | `Storage::url($path)` |
| `asset('storage/' . $path)` | `Storage::url($path)` |

---

## 12. Storage Image URL Fix — June 2026 (current approach)

### Problem

- Files live at `storage/app/public/listings/…` but Herd/local uses `public/` as document root, so `asset('storage/app/public/…')` pointed to a path that did not exist on disk under `public/`.
- `Storage::url()` requires `php artisan storage:link` and produces `/storage/listings/…` (not `/storage/app/public/listings/…`), which did not match production URL layout.

### Solution

1. **Blade — dynamic `<img>` only** (26 files):

```blade
<img src="{{ asset('storage/app/public/' . $firstImage) }}">
```

Ternary fallbacks to `asset('/assets/images/listingImage.webp')` unchanged. `<source>`, `<a href>`, comments, and static `/assets/` images were not changed.

2. **Route** — `routes/web.php` (top of file):

```php
Route::get('/storage/app/public/{path}', function (string $path) {
    $path = str_replace(['..', '\\'], '', $path);
    if (! Storage::disk('public')->exists($path)) {
        abort(404);
    }
    return Storage::disk('public')->response($path);
})->where('path', '.*');
```

Serves uploads from `storage/app/public/` without a `public/storage` symlink.

### Production URL pattern

```
https://paklivestock.com.pk/storage/app/public/listings/filename.jpg
```

### Post-deploy commands

```bash
php artisan view:clear
php artisan route:clear
```

### Files updated (26 Blade templates)

Same file list as §11.1 — all dynamic listing, category, information, receipt, and admin preview images.

| Before | After |
|--------|--------|
| `Storage::url($path)` | `asset('storage/app/public/' . $path)` |

---

*Report generated from security cleanup and remediation work performed on this codebase.*
