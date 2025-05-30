<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Jumis API Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for the Jumis API integration.
    |
    */

    // API URL (required)
    'url' => env('JUMIS_API_URL', 'https://api.jumis.lv'),

    // API Credentials (required)
    'username' => env('JUMIS_API_USERNAME'),
    'password' => env('JUMIS_API_PASSWORD'),

    // API Version (required)
    'version' => env('JUMIS_API_VERSION', '1.0'),

    // Default Structure Type (optional)
    'structure_type' => env('JUMIS_STRUCTURE_TYPE', 'Tree'),

    // Request Timeout in seconds (optional)
    'timeout' => env('JUMIS_TIMEOUT', 30),

    // Retry Configuration (optional)
    'retry_attempts' => env('JUMIS_RETRY_ATTEMPTS', 3),
    'retry_delay' => env('JUMIS_RETRY_DELAY', 1000), // milliseconds
]; 