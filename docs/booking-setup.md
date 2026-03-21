# First-party booking (`/booking`)

Bookings are stored in the `bookings` table. Available slots are computed from `config/booking.php` (timezone, slot length, horizon, minimum notice, weekly windows) minus overlapping non-cancelled rows.

## Mail & calendar invite

Successful submissions email `SITE_CONTACT_EMAIL` via your configured mailer (`MAIL_*` in `.env`). The message includes a **`booking-request.ics`** attachment (iCalendar) so you can add the slot to your calendar in one tap. In local dev, `MAIL_MAILER=log` is typical.

## Admin (`/admin/booking`)

Uses Laravel **session auth**: users with `is_admin = true` on the `users` table can sign in with **email + password** (bcrypt). There is no shared `.env` password.

### First-time setup

After migrating, create (or promote) an admin:

```bash
php artisan booking:create-admin you@example.com "Your Name"
```

Run `php artisan migrate` first so the `is_admin` column exists.

Until at least one admin user exists, **`/admin/booking/login`** returns **404** (the dashboard redirects guests to that URL, which then 404s — so the UI stays hidden).

- **`/admin/booking/login`** — sign in (optional “remember this device”).
- **`/admin/booking`** — list requests; **Confirm** or **Cancel**.

Sign out from the admin index. Use **HTTPS** in production.

Non-admin users cannot access the dashboard (`403`) and cannot complete sign-in on that form.

## Tuning

| Env / config | Meaning |
|--------------|---------|
| `BOOKING_TIMEZONE` | IANA zone used for windows and labels (default `America/Phoenix`) |
| `BOOKING_SLOT_MINUTES` | Slot length (default 30) |
| `BOOKING_HORIZON_DAYS` | How far ahead to show slots |
| `BOOKING_MIN_NOTICE_HOURS` | Earliest bookable time from “now” |
| `windows` in `config/booking.php` | Per-day ranges; `days` uses ISO weekday 1 = Monday … 7 = Sunday |

After changing windows or slot length, run `php artisan config:clear` if config is cached in production.

## Database

```bash
php artisan migrate
```

## Production notes

- **SQLite**: `lockForUpdate()` in the booking transaction may behave differently than on MySQL/PostgreSQL; for high concurrency, prefer a server database.
- **Spam**: The form includes the same honeypot field (`website`) as contact; POST is throttled (`10,1`).
