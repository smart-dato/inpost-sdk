<?php

// config for Smartdato/InPost
return [
    'client_id' => env('INPOST_CLIENT_ID', ''),
    'client_secret' => env('INPOST_CLIENT_SECRET', ''),
    'organization_id' => env('INPOST_ORGANIZATION_ID', ''),
    'token_url' => env('INPOST_TOKEN_URL', 'https://api.inpost-group.com/oauth2/token'),
    'pickups_token_url' => env('INPOST_PICKUPS_TOKEN_URL', 'https://account.inpost-group.com/oauth2/token'),
    'base_urls' => [
        'shipping' => env('INPOST_SHIPPING_URL', 'https://api.inpost-group.com/shipping/v2'),
        'points' => env('INPOST_POINTS_URL', 'https://api.inpost-group.com/location/v1'),
        'tracking' => env('INPOST_TRACKING_URL', 'https://api.inpost-group.com/tracking/v1'),
        'returns' => env('INPOST_RETURNS_URL', 'https://api.inpost-group.com/returns/v1'),
        'pickups' => env('INPOST_PICKUPS_URL', 'https://api.inpost.pl/pickups/v1'),
    ],
];
