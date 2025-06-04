<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Initium\Jumis\Api\Filters\FilterEqual;
use Initium\Jumis\Api\JumisAPIService;

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

$apiUrl = $_ENV['JUMIS_API_URL'];
if (!filter_var($apiUrl, FILTER_VALIDATE_URL)) {
    die("Error: Invalid JUMIS_API_URL format\n");
}

$apiUrl = preg_replace('#/(import|export)$#', '', $apiUrl);

$api = new JumisAPIService(
    endpoint: $apiUrl,
    username: $_ENV['JUMIS_API_USERNAME'],
    password: $_ENV['JUMIS_API_PASSWORD'],
    database: $_ENV['JUMIS_API_DATABASE'],
    apikey: $_ENV['JUMIS_API_KEY'],
    documentVersion: 'TJ5.5.101',guzzleOptions: []
);

$partnerXml = [
    [
        'PartnerCode' => uniqid('PHP_VALID_'),
        'PartnerName' => 'Test Partner ' . date('Y-m-d H:i:s'),
        'PartnerType' => 'Čipsis',
        'PartnerRegistrationNo' => '12345678901',
        'PartnerAddress' => [
            'AddressStreet' => 'Test Street 123',
            'AddressPostalCode' => 'LV-1001',
            'AddressCity' => 'Riga',
            'AddressCountryCode' => 'LV'
        ]
    ],
];

echo "Attempting to insert partner data...\n";

try {

    $partners =  [
        'TEST' => 'XXX'
    ];

    //$response = $api->insert('Partner', $partners);
    $response= $api->read('Partner',['PartnerName','PartnerCode']);
    echo "-------------------------------------\n";
    echo "RAW API RESPONSE:\n";
    echo "-------------------------------------\n";
    echo print_r($response,true) . "\n";
    echo "-------------------------------------\n";
}
catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}
