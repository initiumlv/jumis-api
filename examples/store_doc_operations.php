<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Initium\Jumis\Api\ApiService;
use Initium\Jumis\Api\Enums\Block;
use Initium\Jumis\Api\Enums\DocumentStatus;
use Initium\Jumis\Api\Filters\FilterEqual;
use Initium\Jumis\Api\Filters\FilterBetween;

// Initialize API service
$api = new ApiService();

// Example 1: Insert a new store document
try {
    // Build store document with lines
    $storeDocXml = $api->buildNestedBlock(
        'StoreDoc',
        'StoreDocLine',
        [
            // Document header
            'DocType' => 'Purchase',
            'DocNumber' => 'PO-001',
            'DocDate' => date('Y-m-d'),
            'DocStatus' => DocumentStatus::STARTED->value,
            'PartnerCode' => 'SUPP001',
            'WarehouseCode' => 'WH001',
            'CurrencyCode' => 'EUR',
            
            // Document line
            'ProductCode' => 'PROD001',
            'Quantity' => 10,
            'UnitPrice' => 19.99,
            'LineAmount' => 199.90,
            'VATRate' => 21,
            'VATAmount' => 41.98
        ],
        'SD1',  // Store document tag ID
        'SDL1'  // Store document line tag ID
    );

    // Insert the store document
    $insertResponse = $api->insert(
        Block::StoreDoc,
        $storeDocXml,
        'Tree',
        null,
        'StoreDoc_Insert_1'
    );

    if ($insertResponse === null) {
        echo "Failed to insert store document\n";
        exit(1);
    }

    // Extract the new document ID from response
    $docId = (string)$insertResponse->StoreDoc->StoreDocID;
    echo "Successfully inserted store document with ID: $docId\n";

    // Example 2: Read the inserted document
    $readResponse = $api->read(
        Block::StoreDoc,
        [
            'DocType', 'DocNumber', 'DocDate', 'PartnerCode', 'WarehouseCode',
            'CurrencyCode', 'DocStatus', 'TotalAmount', 'VATAmount'
        ],
        [new FilterEqual('StoreDocID', $docId)],
        'Tree',
        null,
        'StoreDoc_Read_1',
        false,
        true,  // Return IDs
        true   // Return sync info
    );

    if ($readResponse === null) {
        echo "Failed to read store document\n";
        exit(1);
    }

    // Display document details
    $doc = $readResponse->StoreDoc;
    echo "\nStore Document Details:\n";
    echo "Type: " . (string)$doc->DocType . "\n";
    echo "Number: " . (string)$doc->DocNumber . "\n";
    echo "Date: " . (string)$doc->DocDate . "\n";
    echo "Partner: " . (string)$doc->PartnerCode . "\n";
    echo "Warehouse: " . (string)$doc->WarehouseCode . "\n";
    echo "Currency: " . (string)$doc->CurrencyCode . "\n";
    echo "Status: " . DocumentStatus::from($doc->DocStatus)->label() . "\n";
    echo "Total Amount: " . (string)$doc->TotalAmount . "\n";
    echo "VAT Amount: " . (string)$doc->VATAmount . "\n";

    // Example 3: Update document status to approved
    $updateXml = $api->buildDataBlock(
        'StoreDoc',
        [
            'StoreDocID' => $docId,
            'DocStatus' => DocumentStatus::APPROVED->value
        ],
        'SD1'
    );

    $updateResponse = $api->update(
        Block::StoreDoc,
        $updateXml,
        'Tree',
        null,
        'StoreDoc_Update_1'
    );

    if ($updateResponse === null) {
        echo "Failed to update store document status\n";
        exit(1);
    }

    echo "\nSuccessfully updated document status to approved\n";

    // Verify the status change
    $verifyResponse = $api->read(
        Block::StoreDoc,
        ['DocStatus'],
        [new FilterEqual('StoreDocID', $docId)],
        'Tree',
        null,
        'StoreDoc_Verify_1'
    );

    if ($verifyResponse === null) {
        echo "Failed to verify document status\n";
        exit(1);
    }

    $currentStatus = DocumentStatus::from($verifyResponse->StoreDoc->DocStatus);
    echo "Current document status: " . $currentStatus->label() . "\n";

    // Example 4: Search for documents in date range
    $searchResponse = $api->read(
        Block::StoreDoc,
        ['DocType', 'DocNumber', 'DocDate', 'PartnerCode', 'TotalAmount'],
        [
            new FilterBetween('DocDate', date('Y-m-d', strtotime('-7 days')), date('Y-m-d')),
            new FilterEqual('DocType', 'Purchase')
        ],
        'Sheet',
        null,
        'StoreDoc_Search_1'
    );

    if ($searchResponse === null) {
        echo "Failed to search store documents\n";
        exit(1);
    }

    echo "\nSearch Results:\n";
    foreach ($searchResponse->StoreDoc as $doc) {
        echo "Type: " . (string)$doc->DocType . 
             ", Number: " . (string)$doc->DocNumber . 
             ", Date: " . (string)$doc->DocDate . 
             ", Partner: " . (string)$doc->PartnerCode . 
             ", Amount: " . (string)$doc->TotalAmount . "\n";
    }

    // Example 5: Delete the document
    $deleteXml = $api->buildDataBlock('StoreDoc', ['StoreDocID' => $docId], 'SD1');
    $deleteResponse = $api->delete(
        Block::StoreDoc,
        $deleteXml,
        'Tree',
        null,
        'StoreDoc_Delete_1'
    );

    if ($deleteResponse === null) {
        echo "Failed to delete store document\n";
        exit(1);
    }

    echo "\nSuccessfully deleted store document\n";

} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
} 