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

];
