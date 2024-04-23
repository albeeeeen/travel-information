<?php

return [
    'base_uri' => env('WEATHER_API_BASE_URI', 'https://api.openweathermap.org/data/2.5'),
    'api_key'  => env('WEATHER_API_KEY', 'df514bd357beb5236ee922eb238cd240'),
    'units'    => env('WEATHER_API_UNITS', 'metric')
];