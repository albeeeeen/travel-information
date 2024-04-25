<?php

return [
    'base_uri_v1' => env('PLACES_API_URL_V1', 'https://api.geoapify.com/v1'),
    'base_uri_v2' => env('VITE_PLACES_API_URL_V2', 'https://api.geoapify.com/v2'),
    'api_key'  => env('VITE_PLACES_API_KEY', 'ec5689068d7047fe949226f63de6955e'),
    'api_limit' => env('VITE_PLACES_API_LIMIT', 100)
];