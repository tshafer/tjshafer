# First-party booking (`/booking`)

Bookings are stored in the `bookings` table. Available slots are computed from `config/booking.php` (timezone, slot length, horizon, minimum notice, weekly windows) minus overlapping non-cancelled rows.

## Mail

Successful submissions email `SITE_CONTACT_EMAIL` via your configured mailer (`MAIL_*` in `.env`). In local dev, `MAIL_MAILER=log` is typical.

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
