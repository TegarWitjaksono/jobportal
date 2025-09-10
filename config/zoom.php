<?php

return [
    // Server-to-Server OAuth credentials from Zoom Marketplace
    'account_id' => env('ZOOM_ACCOUNT_ID'),
    'client_id' => env('ZOOM_CLIENT_ID'),
    'client_secret' => env('ZOOM_CLIENT_SECRET'),

    // Default host user (email or userId) to create meetings under
    'default_host' => env('ZOOM_DEFAULT_HOST'),

    // Default meeting settings
    'default' => [
        'duration' => env('ZOOM_DEFAULT_DURATION', 60), // minutes
        'timezone' => env('ZOOM_TIMEZONE', config('app.timezone', 'UTC')),
        'waiting_room' => env('ZOOM_WAITING_ROOM', true),
        'join_before_host' => env('ZOOM_JOIN_BEFORE_HOST', false),
    ],
];

