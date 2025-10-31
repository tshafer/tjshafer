# Spotify Integration Setup

To enable the "Currently Playing" feature on your site, you'll need to set up Spotify API credentials.

## Steps to Get Spotify Credentials

1. **Create a Spotify App:**
   - Go to https://developer.spotify.com/dashboard
   - Log in with your Spotify account
   - Click "Create an app"
   - Fill in the app details:
     - App name: "tjshafer.com" (or any name you prefer)
     - App description: "Personal website integration"
     - Redirect URI: **Important!** Use your site URL. For local dev: `http://localhost:8000/spotify/callback`
     - For production: `https://tjshafer.com/spotify/callback`
   - Click "Save"

2. **Get Your Client ID and Client Secret:**
   - After creating the app, you'll see your `Client ID`
   - Click "Show client secret" or "Reveal" to see your `Client Secret`
   - Copy both values

3. **Add Client ID and Secret to .env:**
   Add these lines to your `.env` file:
   ```
   SPOTIFY_CLIENT_ID=your_client_id_here
   SPOTIFY_CLIENT_SECRET=your_client_secret_here
   ```

4. **Get Refresh Token Automatically:**
   - Make sure your app is running (`php artisan serve`)
   - Visit: `http://localhost:8000/spotify/auth` (or `https://tjshafer.com/spotify/auth` in production)
   - You'll be redirected to Spotify to authorize the app
   - Click "Agree" to authorize
   - You'll be redirected back with your refresh token displayed
   - Copy the refresh token

5. **Add Refresh Token to .env:**
   Add this line to your `.env` file:
   ```
   SPOTIFY_REFRESH_TOKEN=your_refresh_token_here
   ```

6. **Done!** Your Spotify integration should now be working.

## Features

Once configured, your music section will display:
- **Currently Playing** - Real-time track with artwork (updates every 30 seconds)
- **Top Artists** - Your favorite artists with time range filters (4 weeks, 6 months, all time)
- **Top Tracks** - Your most played tracks with time range filters
- **Recently Played** - Last 20 tracks you listened to with timestamps
- **Playlists** - Your Spotify playlists in a beautiful grid layout

All sections load automatically when you visit the page, and the currently playing widget updates every 30 seconds.

## Notes

- The refresh token allows the app to access your Spotify account without requiring you to log in each time
- Make sure your `.env` file is not committed to version control (it should be in `.gitignore`)
- If the widget doesn't appear, check the browser console for any error messages
