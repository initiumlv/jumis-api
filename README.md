# Jumis API Integration

A PHP library for integrating with Tildes Jumis ERP system's XML-based API.

## Requirements

- PHP 8.1 or higher
- Laravel 12
- Composer

## Installation

### Basic Installation

```bash
composer require initiumlv/jumis-api
```



## Configuration

### Publishing configuration

If you are using Laravel, you can publish the configuration file:

```bash
php artisan vendor:publish --provider="Initium\Jumis\Api\JumisApiServiceProvider"
```

This will create a `config/jumis.php` file in your config directory.

### Environment Variables

Add the following to your `.env` file.

```env
JUMIS_API_URL=
JUMIS_API_USERNAME=
JUMIS_API_PASSWORD=
JUMIS_API_DATABASE=
JUMIS_API_KEY=
```

### Configuration File

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

### Service Provider

The package automatically registers its service provider in Laravel applications. If you need to register it manually, add the following to your `config/app.php`:

```php
'providers' => [
    // ...
    Initium\Jumis\Api\JumisApiServiceProvider::class,
],
```

## Usage

### Basic setup

```php
use Initium\Jumis\Api\JumisAPIService;
use Initium\Jumis\Api\Filters\FilterEqual;

$api = app(JumisAPIService::class);

$api->setDocumentVersion('TJ5.5.101');
$api->setRequestVersion('TJ7.0.112');
```

### Valid insert

```php

$partners = [
    [
        'PartnerCode' => 'COST1',
        'PartnerName' => 'INITIUM',
        'PartnerAddress' => [
            'AddressStreet' => 'Test',
            'AddressPostalCode' => 'LV-4101',
            'AddressCity' => 'Test',
            'AddressCountryCode' => 'LV'
        ]
    ],
];

$api->insert('Partner', $partners);

// Response

array (
  0 =>
  array (
    'Key' => 'ConvertedImportXML',
    'Value' =>
    array (
      'tjDocument' =>
      array (
        '@attributes' =>
        array (
          'Version' => 'TJ5.5.101',
        ),
      ),
      'tjRequest' =>
      array (
        '@attributes' =>
        array (
          'Name' => 'Partner',
          'Operation' => 'Insert',
          'Version' => 'TJ7.0.112',
          'Structure' => 'Tree',
        ),
        'Partner' =>
        array (
          '@attributes' =>
          array (
            'TagID' => 'P1',
          ),
          'PartnerCode' => 'COST1',
          'PartnerName' => 'INITIUM',
          'PartnerAddress' =>
          array (
            '@attributes' =>
            array (
              'TagID' => 'PA1',
            ),
            'AddressStreet' => 'Test',
            'AddressPostalCode' => 'LV-4101',
            'AddressCity' => 'Test',
            'AddressCountryCode' => 'LV',
          ),
        ),
      ),
    ),
  ),
)
```

### Invalid Insert (Dont contain all required data for successful insert)

```php
$partners = [
    'TEST' => 'XXX'
];

$response = $api->insert('Partner', $partners);
    
// Response
// NOTE:
// In this case no errors are returned just return has array of send data.
// There currently is no way to know if API accepted or rejected malformed request for data insert.
    
array (
  0 =>
  array (
    'Key' => 'ConvertedImportXML',
    'Value' =>
    array (
      'tjDocument' =>
      array (
        '@attributes' =>
        array (
          'Version' => 'TJ5.5.101',
        ),
      ),
      'tjRequest' =>
      array (
        '@attributes' =>
        array (
          'Name' => 'Partner',
          'Operation' => 'Insert',
          'Version' => 'TJ7.0.112',
          'Structure' => 'Tree',
        ),
        'Partner' =>
        array (
          '@attributes' =>
          array (
            'TagID' => 'P1',
          ),
          'TEST' => 'XXX',
        ),
      ),
    ),
  ),
)
```

### Invalid Insert (With invalid relationship by name)

```php
$partners = [
    [
        'PartnerCode' => uniqid('PHP_VALID_'),
        'PartnerName' => 'Test Partner ' . date('Y-m-d H:i:s'),
        'PartnerType' => 'Čipsis', // Not Valid
        'PartnerRegistrationNo' => '12345678901',
        'PartnerAddress' => [
            'AddressStreet' => 'Test Street 123',
            'AddressPostalCode' => 'LV-1001',
            'AddressCity' => 'Riga',
            'AddressCountryCode' => 'LV'
        ]
    ],
];

$response = $api->insert('Partner', $partners);

//Response (Will return multiple items if it has errors)

 array (
    0 =>
        array (
            'Key' => 'ConvertedImportXML',
            'Value' =>
                array (
                    'tjDocument' =>
                        array (
                            '@attributes' =>
                                array (
                                    'Version' => 'TJ5.5.101',
                                ),
                        ),
                    'tjRequest' =>
                        array (
                            '@attributes' =>
                                array (
                                    'Name' => 'Partner',
                                    'Operation' => 'Insert',
                                    'Version' => 'TJ7.0.112',
                                    'Structure' => 'Tree',
                                    'RequestID' => 'InsertReq_1748985344',
                                ),
                            'Partner' =>
                                array (
                                    '@attributes' =>
                                        array (
                                            'TagID' => 'P1',
                                        ),
                                    'PartnerCode' => 'PHP_VALID_683f66004bb54',
                                    'PartnerName' => 'Test Partner 2025-06-03 21:15:44',
                                    'PartnerType' => 'Čipsis',
                                    'xx' => 'x',
                                    'PartnerRegistrationNo' => '12345678901',
                                    'PartnerAddress' =>
                                        array (
                                            '@attributes' =>
                                                array (
                                                    'TagID' => 'PA1',
                                                ),
                                            'AddressStreet' => 'Test Street 123',
                                            'AddressPostalCode' => 'LV-1001',
                                            'AddressCity' => 'Riga',
                                            'AddressCountryCode' => 'LV',
                                        ),
                                ),
                        ),
                ),
        ),
    1 => // Errors start here
        array (
            'Key' => 'P1',
            'Value' => 'Čipsis',
        ),
)

```


#### Read

```php

$api->read('Partner',['PartnerName','PartnerCode'],[
    new FilterEqual('PartnerName', 'Noliktava (galvenā)')
]);

// Response
array (
  'tjDocument' =>
  array (
    '@attributes' =>
    array (
      'Version' => 'TJ5.5.101',
    ),
  ),
  'tjResponse' =>
  array (
    '@attributes' =>
    array (
      'Name' => 'Partner',
      'Operation' => 'Read',
      'Version' => 'TJ7.0.112',
      'Structure' => 'Tree',
    ),
    'Partner' =>
    array (
      0 =>
      array (
        'PartnerName' => 'Noliktava (galvenā)',
      ),
    ),
  ),
)
```

## Filter Types

The library provides several filter types for querying data:

### FilterEqual
```php
new FilterEqual('ProductCode', 'PROD001')
```
### FilterLike
```php
new FilterLike('ProductName', 'Test%')
```

### FilterBetween
```php
new FilterBetween('DocDate', '2024-01-01', '2024-12-31')
```

### FilterLessThan
```php
new FilterLessThan('Price', 100)
```

### FilterGreaterThan
```php
new FilterGreaterThan('Quantity', 0)
```

## Example with error handling
Always wrap API calls with try-catch blocks to handle HTTP errors or XML parsing issues.
If response from API encounters an empty or invalid raw string before attempting to parse XML, it will return empty `array`.

```php
try {
    $response = $api->insert('Partner', ['PartnerCode' => 'Test']);
    
    if (isset($response['status'])) {
        // wrong username, password or database provided
        return;
    }

    // Has errors in fields or connection
    if(count($response > 1)) {

       // Iterate over all returned errors
       for ($i = 1; $i < count($response); $i++) {
            echo $response[$i]['Key'] .' = ' $response[$i]['Value'] . PHP_EOL;
       }
       
       return;
    }
    
    if (!isset($response[0]['Value']) && !is_array($response[0]['Value'])) {
        // Unexpected response
        return;
    }
    
    
    print_r($response);
    
    //
    // Read Inserted data
    //
    
    $response = $api->read('Partner', ['PartnerCode'],[
        new \Initium\Jumis\Api\Filters\FilterEqual('PartnerCode','Test')
    ]);
    
    if (isset($response['status'])) {
        // wrong username, password or database provided
        return;
    }
        
    if (empty($response)) {
        // No data returned.
        return;
    }
    
    print_r($response);
    
    
    //
    // Read data and sort
    //
    
    $fields = [
        'PartnerCode', // Basic Field
        ['name' => 'PartnerName','sort' => 'Asc', 'sortLevel' => 1]
        'PartnerAddress' => [ // Selecting related data
            'AddressCity',
        ] 
    ]
    
    $response = $api->read('Partner', ,[
        new \Initium\Jumis\Api\Filters\FilterEqual('PartnerCode','Test')
    ]);
    
    if (isset($response['status'])) {
        // wrong username, password or database provided
        return;
    }
        
    if (empty($response)) {
        // No data returned.
        return;
    }
    
    print_r($response);
} 
catch (\Initium\Jumis\Api\JumisException $e) { 
    // Incorrect structures, fields, filters, flags, etc.
}
catch (\GuzzleHttp\Exception\GuzzleException $e) { 
   // General Guzzle Exception
   // Wrong Jumis API key provided
} catch (\Exception $e) { 
    // General Exception
}
```

## Documentation

https://atbalsts.mansjumis.lv/hc/lv/articles/6482469051922-Jumis-REST-API-specifik%C4%81cija


## MIT License

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or significant portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS," WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.