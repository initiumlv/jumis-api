# Jumis API Integration

A PHP library for integrating with Tildes Jumis ERP system's XML-based API.

## Requirements

- PHP 8.1 or higher
- Laravel 10.x 
- Composer

## Installation

### Basic Installation

```bash
composer require initiumlv/jumis-api
```

### Laravel Integration (Optional)

If you are using Laravel, you can publish the configuration file:

```bash
php artisan vendor:publish --provider="Initium\Jumis\Api\JumisApiServiceProvider"
```

This will create a `config/jumis.php` file in your config directory.

## Configuration

### Environment Variables

Add the following to your `.env` file. For standalone usage, you'll need to load these variables manually (e.g., using a library like `vlucas/phpdotenv`).

```env
JUMIS_API_URL=
JUMIS_API_USERNAME=
JUMIS_API_PASSWORD=
JUMIS_API_DATABASE=
JUMIS_API_KEY=
```

### Configuration File (Laravel)

The published configuration file (`config/jumis.php`) for Laravel allows you to set your API credentials and other settings. It typically looks like this, based on the provided `config/jumis.php`:

```php
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
```

Make sure your `.env` file has the corresponding `JUMIS_API_URL`, `JUMIS_API_USERNAME`, `JUMIS_API_PASSWORD`, `JUMIS_API_DATABASE`, and `JUMIS_API_KEY` variables.
The `versions` in the config file provide defaults if the `ApiService` is set up to use them and they are not overridden elsewhere (e.g., by direct calls to `setDocumentVersion` or `setRequestVersion` in `ApiService`).

### Service Provider

The package automatically registers its service provider in Laravel applications. If you need to register it manually, add the following to your `config/app.php`:

```php
'providers' => [
    // ...
    Initium\Jumis\Api\JumisApiServiceProvider::class,
],
```

### Facade (Optional)

If you want to use the facade, add it to your `config/app.php`:

```php
'aliases' => [
    // ...
    'JumisApi' => Initium\Jumis\Api\Facades\JumisApi::class,
],
```

## Usage

### Using Facade (Laravel)

```php
use Initium\Jumis\Api\Facades\JumisApi;

$response = JumisApi::read(
    'Product',
    ['ProductCode', 'ProductName'],
    //[new FilterEqual('ProductCode', 'PROD001')]
);
```


## Filter Types

The library provides several filter types for querying data:

### FilterEqual
Exact match filter:
```php
new FilterEqual('ProductCode', 'PROD001')
```

### FilterLike
SQL LIKE pattern matching:
```php
new FilterLike('ProductName', 'Test%')
```

### FilterBetween
Range filter:
```php
new FilterBetween('DocDate', '2024-01-01', '2024-12-31')
```

### FilterLessThan
Less than comparison:
```php
new FilterLessThan('Price', 100)
```

### FilterGreaterThan
Greater than comparison:
```php
new FilterGreaterThan('Quantity', 0)
```


## Error Handling

The API methods (`read`, `insert`) in `ApiService.php` will return a parsed array from the XML response.
If `parseXmlResponse` encounters an empty or invalid raw string before attempting to parse XML, it may return `null`.
If XML parsing itself fails, Exception is thrown.
Network issues or other Guzzle client errors can also throw exceptions. Always wrap API calls in try-catch blocks.

```php
try {
    $response = $api->read('Product', ['ProductCode']);

} catch (\GuzzleHttp\Exception\GuzzleException $e) { // Catch Guzzle HTTP errors
    echo "HTTP Request Error: " . $e->getMessage() . "\n";
} catch (\Exception $e) { // Catch any other general errors
    echo "An unexpected error occurred: " . $e->getMessage() . "\n";
}
```
