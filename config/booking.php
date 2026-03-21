<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Display & generation timezone (Arizona has no DST — still use IANA name)
    |--------------------------------------------------------------------------
    */
    'timezone' => env('BOOKING_TIMEZONE', 'America/Phoenix'),

    'slot_minutes' => (int) env('BOOKING_SLOT_MINUTES', 30),

    'horizon_days' => (int) env('BOOKING_HORIZON_DAYS', 14),

    /*
    |--------------------------------------------------------------------------
    | Minimum lead time before the first bookable slot
    |--------------------------------------------------------------------------
    */
    'min_notice_hours' => (int) env('BOOKING_MIN_NOTICE_HOURS', 4),

    /*
    |--------------------------------------------------------------------------
    | Weekly windows: ISO weekday 1 = Monday … 7 = Sunday
    |--------------------------------------------------------------------------
    */
    'windows' => [
        ['days' => [1, 2, 3, 4, 5], 'start' => '09:00', 'end' => '12:00'],
        ['days' => [1, 2, 3, 4, 5], 'start' => '13:00', 'end' => '17:00'],
    ],

];
