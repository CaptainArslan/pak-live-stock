# Pak Livestock

Laravel 8 marketplace for buying and selling livestock, pets, birds, and related listings in Pakistan.

| Environment | URL |
|-------------|-----|
| Production | https://paklivestock.com.pk |
| Local (Herd) | http://paklivestock.test |
| Local (`artisan serve`) | http://127.0.0.1:8000 |

---

## Tech stack

- **PHP** 7.3+ / 8.x
- **Laravel** 8.x
- **MySQL**
- **Firebase** — phone OTP registration (`kreait/firebase-php`)
- **Laravel Sanctum** — API auth
- **Blade** — server-rendered UI (no Livewire / Vue SPA)

---

## Local setup

```bash
# Clone
git clone git@github.com:CaptainArslan/pak-live-stock.git
cd pak-live-stock

# Dependencies
composer install

# Environment
cp .env.example .env   # or copy your existing .env
php artisan key:generate

# Database — import your dump, then:
php artisan migrate    # if needed

# Clear caches
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### `.env` (important)

```env
APP_URL=http://paklivestock.test    # use your real local or production URL

DB_CONNECTION=mysql
DB_DATABASE=pak_live_stock
DB_USERNAME=root
DB_PASSWORD=
```

Firebase client config lives in `firebase/firebase.json` (gitignored). See `config/firebase.php`.

---

## Uploaded images & storage

### How it works

Uploads are saved to the Laravel **`public` disk**:

```
storage/app/public/
├── listings/              ← web listing images
├── uploads/listings/      ← API/mobile listing images
├── categories/
├── uploads/info_images/
├── uploads/info_videos/
└── receipts/
```

The database stores **relative paths** only, e.g. `listings/abc123.jpg` in `listings.images` (JSON array).

### Displaying images in Blade

All dynamic `<img>` tags use:

```blade
<img src="{{ asset('storage/app/public/' . $imagePath) }}">
```

With fallbacks where needed:

```blade
<img src="{{ $firstImage ? asset('storage/app/public/' . $firstImage) : asset('/assets/images/listingImage.webp') }}">
```

**26 Blade templates** were updated to this pattern (see `PROJECT-CLEANUP-REPORT.md` §12).

### Serving files without `storage:link`

A route in `routes/web.php` serves files from `storage/app/public` when the URL is `/storage/app/public/...`:

```php
Route::get('/storage/app/public/{path}', function (string $path) {
    // returns file from storage/app/public/{path}
})->where('path', '.*');
```

This is required on **local Herd** (document root = `public/`) where files outside `public/` are not directly web-accessible.

On **production**, if the full project lives in `public_html`, Apache may serve `/storage/app/public/...` directly from disk. The route still works as a fallback.

`php artisan storage:link` is **optional** with this setup.

### Production image URL

```
https://paklivestock.com.pk/storage/app/public/listings/filename.jpg
```

---

## File uploads (where uploads happen)

| Feature | Controller | Input field | Storage folder |
|---------|------------|-------------|----------------|
| Web listings | `Admin\ListingController` | `images[]` | `listings/` |
| API listings | `Api\ListController`, `Api\ListingApiController` | `images[]` | `uploads/listings/` |
| Categories | `Admin\CategoryController` | `image` | `categories/` |
| Information | `Admin\InformationController` | `image`, `video_upload` | `uploads/info_images/`, `uploads/info_videos/` |
| Featured receipt | `FeaturedRequestController` | `receipt_image` | `receipts/` |

**Note:** Web and API listing uploads use different folders (`listings/` vs `uploads/listings/`). Both work with the same display URL pattern as long as the DB path matches the file on disk.

---

## Useful commands

```bash
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan cache:clear
composer dump-autoload -o
```

After deploying Blade or route changes:

```bash
php artisan view:clear
php artisan route:clear
```

---

## Security & maintenance

| Document | Purpose |
|----------|---------|
| [PROJECT-CLEANUP-REPORT.md](PROJECT-CLEANUP-REPORT.md) | Malware cleanup, webshell removal, image URL fixes |
| [GIT-SECRETS-REMOVAL-GUIDE.md](GIT-SECRETS-REMOVAL-GUIDE.md) | Removing leaked Firebase keys from Git history |

### Security reminders

- **Rotate Firebase keys** if they were ever committed to Git.
- **`/clear-all`** route in `web.php` clears config/view cache publicly — restrict or remove on production.
- Do not commit `.env` or `firebase/firebase.json`.
- Scan `storage/` and `config/` for unexpected `index.php` files after any server compromise.

---

## Known issues / follow-ups

- `POST /api/update_listing/{id}/images` → `ListController::updateListingImages` — route exists, method missing.
- `POST /api/listings` → `ListingApiController::store` — route exists, method missing.
- Web listings save to `listings/`; API saves to `uploads/listings/` — consider unifying.
- Set `APP_URL` correctly per environment so `asset()` generates the right domain.

---

## Repository

**GitHub:** [CaptainArslan/pak-live-stock](https://github.com/CaptainArslan/pak-live-stock)

---

## License

Laravel framework is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).
