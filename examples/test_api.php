<?php

use Initium\Jumis\Api\JumisAPIService;
use Initium\Jumis\Api\Filters\FilterEqual;

$params = [];
$api = new JumisAPIService($params['url'], $params['username'], $params['password'], $params['database'], $params['apikey']);


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

$response = $api->read('Partner',['PartnerName','PartnerCode'],[
    new FilterEqual('PartnerCode', '683a2a80b2ec0')
]);