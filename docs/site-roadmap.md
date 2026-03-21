# Personal site — shipped features

These ten areas are **implemented** on tjshafer.com (starter content — customize JSON/Markdown and env).

| # | Feature | Where it lives |
|---|---------|----------------|
| 1 | **Projects / case studies** | `/projects` · `content/projects.json` · tag filter `?tag=` |
| 2 | **Writing + RSS** | `/writing`, `/writing/{slug}` · `content/posts/*.md` · `/feed.xml` |
| 3 | **Uses** | `/uses` · edit `resources/views/pages/uses.blade.php` |
| 4 | **Speaking & media** | *Disabled for now* — uncomment `routes/web.php` + `nav` `$more` entry · `content/speaking.json` |
| 5 | **Colophon** | `/colophon` |
| 6 | **Contact form + honeypot** | `/contact` POST · hidden `website` field · `throttle:8,1` · mails `SITE_CONTACT_EMAIL` |
| 7 | **Booking** | `/booking` · first-party slots + `bookings` table · see `docs/booking-setup.md` |
| 8 | **Résumé + JSON Resume** | `/resume` · `public/resume.json` · optional `public/resume.pdf` |
| 9 | **Now page** | `/now` · `content/now.md` |
| 10 | **Social proof** | Home “Out there” · GitHub API (`SITE_GITHUB_USERNAME`, optional `SITE_GITHUB_TOKEN`, cached 1h) · `docs/github-setup.md` · `content/social.json` (`testimonials`, `trusted_by`) |

### Env (`/.env`)

```
SITE_CONTACT_EMAIL=tj@tjshafer.com
SITE_GITHUB_USERNAME=tomshafer
# Optional: SITE_GITHUB_TOKEN=
# Booking: BOOKING_* (see docs/booking-setup.md)
```

### Logo

Circular Tom Shafer badge: `public/images/tom-shafer-logo.png` — used in header, footer, home hero, contact, Spotify setup, favicon.
