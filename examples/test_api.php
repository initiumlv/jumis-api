<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Initium\Jumis\Api\ApiService;
use Initium\Jumis\Api\Filters\FilterEqual;


// Load environment variables
if (file_exists(__DIR__ . '/../.env')) {
    $envFile = file_get_contents(__DIR__ . '/../.env');
    $lines = explode("\n", $envFile);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

// Validate required environment variables
$requiredEnvVars = [
    'JUMIS_API_URL',
    'JUMIS_API_USERNAME',
    'JUMIS_API_PASSWORD',
    'JUMIS_API_DATABASE',
    'JUMIS_API_KEY'
];

foreach ($requiredEnvVars as $var) {
    if (empty($_ENV[$var])) {
        die("Error: Missing required environment variable: $var\n");
    }
}

// Validate API URL format
$apiUrl = $_ENV['JUMIS_API_URL'];
if (!filter_var($apiUrl, FILTER_VALIDATE_URL)) {
    die("Error: Invalid JUMIS_API_URL format\n");
}

// Remove any /import or /export suffix from the URL
$apiUrl = preg_replace('#/(import|export)$#', '', $apiUrl);

// Initialize API service
$api = new ApiService(
    endpoint: $apiUrl,
    username: $_ENV['JUMIS_API_USERNAME'],
    password: $_ENV['JUMIS_API_PASSWORD'],
    database: $_ENV['JUMIS_API_DATABASE'],
    apikey: $_ENV['JUMIS_API_KEY'],
);


// Test Product Read Operations
printSection("Testing Product Read Operations");

$api->setDocumentVersion('TJ5.5.101');

$api->setRequestVersion('TJ7.0.112');


$partnerXml = [
    [
        'PartnerCode' => uniqid(),
        'PartnerName' => uniqid(),
        'PartnerAddress' => [
            'AddressStreet' => 'Test',
            'AddressPostalCode' => 'LV-4101',
            'AddressCity' => 'Test',
            'AddressCountryCode' => 'LV'
        ]
    ],
];

$insertResponse = $api->insert('Partner', $partnerXml);

echo var_export($api->read('Partner',['PartnerName','PartnerCode'],[
        new FilterEqual('PartnerCode', '683a2a80b2ec0')
    ]),true).PHP_EOL;