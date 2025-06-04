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
    | Document Version
    |--------------------------------------------------------------------------
    |
    | Default document version
    |
    */
    'document_version' => 'TJ5.5.101',
];