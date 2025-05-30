<?php

use Initium\Jumis\Api\ApiService;
use Initium\Jumis\Api\Enums\Block;
use Initium\Jumis\Api\Filters\FilterEqual;
use Initium\Jumis\Api\Filters\FilterLike;

// Initialize API service
$api = new ApiService();

// Example 1: Insert a new partner
try {
    // Build partner data
    $partnerXml = $api->buildDataBlock(
        'Partner',
        [
            'PartnerCode' => 'CUST001',
            'PartnerName' => 'Test Customer',
            'PartnerType' => 'Customer',
            'VATNumber' => 'LV12345678901',
            'Address' => 'Test Street 1',
            'City' => 'Riga',
            'Country' => 'Latvia',
            'Phone' => '+371 20000000',
            'Email' => 'test@example.com'
        ],
        'P1'  // Partner tag ID
    );

    // Insert the partner
    $insertResponse = $api->insert(
        Block::Partner,
        $partnerXml,
        'Tree',
        null,
        'Partner_Insert_1'
    );

    if ($insertResponse === null) {
        echo "Failed to insert partner\n";
        exit(1);
    }

    // Extract the new partner ID from response
    $partnerId = (string)$insertResponse->Partner->PartnerID;
    echo "Successfully inserted partner with ID: $partnerId\n";

    // Example 2: Read the inserted partner
    $readResponse = $api->read(
        Block::Partner,
        ['PartnerCode', 'PartnerName', 'PartnerType', 'VATNumber', 'Address', 'City', 'Country', 'Phone', 'Email'],
        [new FilterEqual('PartnerID', $partnerId)],
        'Tree',
        null,
        'Partner_Read_1',
        false,
        true,  // Return IDs
        true   // Return sync info
    );

    if ($readResponse === null) {
        echo "Failed to read partner\n";
        exit(1);
    }

    // Display partner details
    $partner = $readResponse->Partner;
    echo "\nPartner Details:\n";
    echo "Code: " . (string)$partner->PartnerCode . "\n";
    echo "Name: " . (string)$partner->PartnerName . "\n";
    echo "Type: " . (string)$partner->PartnerType . "\n";
    echo "VAT: " . (string)$partner->VATNumber . "\n";
    echo "Address: " . (string)$partner->Address . "\n";
    echo "City: " . (string)$partner->City . "\n";
    echo "Country: " . (string)$partner->Country . "\n";
    echo "Phone: " . (string)$partner->Phone . "\n";
    echo "Email: " . (string)$partner->Email . "\n";

    // Example 3: Search for partners using LIKE filter
    $searchResponse = $api->read(
        Block::Partner,
        ['PartnerCode', 'PartnerName', 'PartnerType'],
        [new FilterLike('PartnerName', 'Test%')],
        'Sheet',
        null,
        'Partner_Search_1'
    );

    if ($searchResponse === null) {
        echo "Failed to search partners\n";
        exit(1);
    }

    echo "\nSearch Results:\n";
    foreach ($searchResponse->Partner as $partner) {
        echo "Code: " . (string)$partner->PartnerCode . ", Name: " . (string)$partner->PartnerName . ", Type: " . (string)$partner->PartnerType . "\n";
    }

    // Example 4: Delete the partner
    $deleteXml = $api->buildDataBlock('Partner', ['PartnerID' => $partnerId], 'P1');
    $deleteResponse = $api->delete(
        Block::Partner,
        $deleteXml,
        'Tree',
        null,
        'Partner_Delete_1'
    );

    if ($deleteResponse === null) {
        echo "Failed to delete partner\n";
        exit(1);
    }

    echo "\nSuccessfully deleted partner\n";

} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
} 