# GitHub block on the home page

The hero pulls public profile data from `GET https://api.github.com/users/{username}` (followers, avatar, bio, etc.), cached for one hour.

## Without a token

Works out of the box with `SITE_GITHUB_USERNAME`. Unauthenticated requests are limited to **60 requests per hour per IP** by GitHub.

## With a token (recommended if traffic grows)

1. Create a [fine-grained personal access token](https://github.com/settings/tokens?type=beta) with **read-only** access, or a classic PAT with no scopes (public read-only is enough for `users/{login}`).
2. Add to `.env`:

```env
SITE_GITHUB_TOKEN=ghp_...
```

3. Authenticated calls use a **5,000/hour** quota. The app sends `Authorization: Bearer …` and uses a separate cache key when a token is set, so you can turn it on or off without stale mixed data.

Never commit the token; keep it only in `.env` and your host’s secrets.
