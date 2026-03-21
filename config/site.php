<?php

return [

    'contact_email' => env('SITE_CONTACT_EMAIL', 'tj@tjshafer.com'),

    'github_username' => env('SITE_GITHUB_USERNAME', 'tomshafer'),

    /*
    | Optional fine-grained token (classic PAT or fine-grained with read:user).
    | Raises GitHub API limit from 60/hr to 5,000/hr — useful if traffic grows.
    */
    'github_token' => env('SITE_GITHUB_TOKEN'),

    'app_url' => env('APP_URL', 'http://localhost'),

    /*
    | Secret path segment for /feed/inbox/{token} — contacts + bookings as RSS.
    | Generate: php -r "echo bin2hex(random_bytes(32));"
    */
    'inbox_feed_token' => env('SITE_INBOX_FEED_TOKEN'),

];
