# tjshafer.com

Personal site for **Tom Shafer** / **Shafer LLC** — projects, writing, contact, first-party booking, Spotify stats, and a JSON résumé. Built as a small Laravel app with a custom Blade + Tailwind front end.

## Stack

- **PHP** 8.5 · **Laravel** 13  
- **Blade**, **Tailwind CSS** 4, **Vite** 7  
- **SQLite** by default (see `.env` for MySQL/Postgres)  
- **PHPUnit** for tests · **Laravel Pint** for PHP style  

## Local setup

```bash
composer run setup
```

Or step by step:

```bash
cp .env.example .env
php artisan key:generate
touch database/database.sqlite   # if using sqlite
php artisan migrate
npm install && npm run build
php artisan serve
```

Day to day:

```bash
composer run dev    # serve + queue + pail + Vite (see composer.json)
```

Configure `SITE_CONTACT_EMAIL`, `SITE_GITHUB_USERNAME`, and optional `SITE_GITHUB_TOKEN` in `.env`. See **[`docs/github-setup.md`](docs/github-setup.md)** for the GitHub block on the home page.

## What lives where

| Area | Location |
|------|-----------|
| Projects | `content/projects.json` · `/projects` |
| Writing + RSS | `content/posts/*.md` · `/writing` · `/feed.xml` |
| Now | `content/now.md` · `/now` |
| Uses | `resources/views/pages/uses.blade.php` |
| Résumé | `public/resume.json` · `/resume` |
| Social / testimonials | `content/social.json` |
| Booking | `/booking` · `config/booking.php` · **[`docs/booking-setup.md`](docs/booking-setup.md)** |
| Booking admin | `/admin/booking` · create an admin: `php artisan booking:create-admin email@example.com "Name"` |
| Spotify | `/music` · **[`SPOTIFY_SETUP.md`](SPOTIFY_SETUP.md)** |

Feature checklist and env notes: **[`docs/site-roadmap.md`](docs/site-roadmap.md)**.

## Commands

```bash
composer test          # PHPUnit
./vendor/bin/pint      # format PHP
npm run build          # production assets
```

## Security

This repo is a personal site, not the Laravel framework. For vulnerabilities in **this project**, contact the site owner. For Laravel itself, see the [Laravel security policy](https://github.com/laravel/framework/security/policy).

## License

MIT. Laravel components remain under their respective licenses.
