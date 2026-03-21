# Private inbox RSS (`/feed/inbox/{token}`)

Merges **contact form** messages (stored in `contact_messages`) and **booking** rows into one RSS feed so you can subscribe in a reader or get notifications.

## Setup

1. Generate a long random token (example):

   ```bash
   php -r "echo bin2hex(random_bytes(32)), PHP_EOL;"
   ```

2. Add to `.env`:

   ```env
   SITE_INBOX_FEED_TOKEN=paste_the_hex_here
   ```

3. Run migrations (creates `contact_messages`).

4. Subscribe to:

   `https://your-domain.com/feed/inbox/YOUR_TOKEN`

   There is no `.xml` suffix; the full URL including the token is the secret.

## Behaviour

- Wrong or missing token → **404** (same as a dead link; no hint).
- Response includes `X-Robots-Tag: noindex, nofollow, noarchive`.
- Throttled **120 requests per minute** per IP.
- Newest **100** items total, mixing contacts and bookings by `created_at`.

## Privacy

Anyone with the URL can read message content. Rotate the token in `.env` if it leaks, then update your reader subscription.

## Production URL (`APP_URL`)

On a live host (e.g. **tjshafer.com**), set **`APP_URL=https://tjshafer.com`** (no trailing slash) in the server `.env`. The feed builds `<atom:link rel="self">` and item links from that value when the host is not `localhost`, so **HTTPS and hostname stay correct** even if the app sits behind a proxy that forwards **HTTP** internally. After changing env, run `php artisan config:cache` (or `config:clear`) as you normally do.

Subscribe with the same canonical URL: `https://tjshafer.com/feed/inbox/YOUR_TOKEN`.

## NetNewsWire

- **Production:** use `https://your-domain.com/feed/inbox/TOKEN` with `APP_URL` set to that same origin (see above).
- **Local (Valet):** when `APP_URL` is `http://localhost` (or another local host), the feed uses the **request** host so `https://tjshafer.test/feed/inbox/TOKEN` still matches `rel="self"`.
- **On My Mac:** add the feed under the **On My Mac** account. Local / secret URLs do not sync through iCloud to your iPhone the way iCloud feeds do.
- **iPhone / iPad:** `*.test` (Valet) usually **does not resolve** on the phone — only on the Mac. To read this feed on iOS, use your **production** domain in the URL, or a **tunnel** (ngrok, Cloudflare Tunnel, Tailscale device name, etc.) that points at your Mac.
- **Certificate:** for `https://` on `.test`, run `valet trust` (or trust the cert in Keychain) so the OS trusts the site.
- If a feed still stalls, **delete it in NetNewsWire and add it again** after deploying these fixes.

## Troubleshooting

- **Nothing new after a booking or contact**  
  - Remove the feed in your reader and subscribe again (many apps cache aggressively).  
  - Open the feed URL in a browser — you should see `<item>` entries with titles like `Booking · …` or `Contact · …`.  
  - Confirm the row exists: booking admin at `/admin/booking`, or check `bookings` / `contact_messages` in the database.

- **Duplicate `<link>`**  
  Each item uses a unique URL (`?inbox=booking-123`) so readers do not collapse everything into a single story.

- **Token / 404**  
  After changing `.env`, run `php artisan config:clear` if you use `config:cache`. Avoid stray spaces around `SITE_INBOX_FEED_TOKEN`.

- **Honeypot**  
  If the hidden `website` field on the booking form is filled (some extensions/autofill), the site fakes success but **does not** save a booking — nothing will appear in the feed.
