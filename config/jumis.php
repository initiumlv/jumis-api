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

    'url' => env('JUMIS_API_URL', 'https://vadiba.mansjumis.lv/cloudapi/JumisImportExportService.ImportExportService.svc'),

    'username' => env('JUMIS_API_USERNAME'),
    'password' => env('JUMIS_API_PASSWORD'),
    'database' => env('JUMIS_API_DATABASE'),
    'apikey' => env('JUMIS_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Guzzle Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for the Guzzle requests.
    |
    */
    'guzzle' => [

    ],

    /*
    |--------------------------------------------------------------------------
    | API Versions per Block
    |--------------------------------------------------------------------------
    |
    | You can specify different API request versions for different data blocks.
    | The ApiService can then be adapted to use these versions accordingly.
    |
    */
    'versions' => [
        'Product' => 'TJ5.5.101',
        'Partner' => 'TJ7.0.112',
        'FinancialDoc' => 'TJ7.0.112',
        'StoreDoc' => 'TJ5.5.125',
    ],
];