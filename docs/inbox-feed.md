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
