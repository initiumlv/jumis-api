<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Initium\Jumis\Api\ApiService;
use Initium\Jumis\Api\Enums\Block;
use Initium\Jumis\Api\Enums\DocumentStatus;
use Initium\Jumis\Api\Filters\FilterEqual;
use Initium\Jumis\Api\Filters\FilterBetween;

// Initialize API service
$api = new ApiService();

// Example 1: Insert a new financial document
try {
    // Build financial document with lines
    $financialDocXml = $api->buildNestedBlock(
        'FinancialDoc',
        'FinancialDocLine',
        [
            // Document header
            'DocType' => 'Invoice',
            'DocNumber' => 'INV-001',
            'DocDate' => date('Y-m-d'),
            'DocStatus' => DocumentStatus::STARTED->value,
            'PartnerCode' => 'CUST001',
            'CurrencyCode' => 'EUR',
            'AccountingSchemaName' => 'Default',
            'AccountingSchemaID' => 1,
            
            // Document line
            'AccountingSchemaFieldName' => 'Sales',
            'LineAmount' => 199.90,
            'VATRate' => 21,
            'VATAmount' => 41.98,
            'Description' => 'Product sale'
        ],
        'FD1',  // Financial document tag ID
        'FDL1'  // Financial document line tag ID
    );

    // Insert the financial document
    $insertResponse = $api->insert(
        Block::FinancialDoc,
        $financialDocXml,
        'Tree',
        null,
        'FinancialDoc_Insert_1'
    );

    if ($insertResponse === null) {
        echo "Failed to insert financial document\n";
        exit(1);
    }

    // Extract the new document ID from response
    $docId = (string)$insertResponse->FinancialDoc->FinancialDocID;
    echo "Successfully inserted financial document with ID: $docId\n";

    // Example 2: Read the inserted document
    $readResponse = $api->read(
        Block::FinancialDoc,
        [
            'DocType', 'DocNumber', 'DocDate', 'PartnerCode',
            'CurrencyCode', 'DocStatus', 'TotalAmount', 'VATAmount',
            'AccountingSchemaName', 'AccountingSchemaID'
        ],
        [new FilterEqual('FinancialDocID', $docId)],
        'Tree',
        null,
        'FinancialDoc_Read_1',
        false,
        true,  // Return IDs
        true   // Return sync info
    );

    if ($readResponse === null) {
        echo "Failed to read financial document\n";
        exit(1);
    }

    // Display document details
    $doc = $readResponse->FinancialDoc;
    echo "\nFinancial Document Details:\n";
    echo "Type: " . (string)$doc->DocType . "\n";
    echo "Number: " . (string)$doc->DocNumber . "\n";
    echo "Date: " . (string)$doc->DocDate . "\n";
    echo "Partner: " . (string)$doc->PartnerCode . "\n";
    echo "Currency: " . (string)$doc->CurrencyCode . "\n";
    echo "Status: " . DocumentStatus::from($doc->DocStatus)->label() . "\n";
    echo "Total Amount: " . (string)$doc->TotalAmount . "\n";
    echo "VAT Amount: " . (string)$doc->VATAmount . "\n";
    echo "Accounting Schema: " . (string)$doc->AccountingSchemaName . "\n";
    echo "Schema ID: " . (string)$doc->AccountingSchemaID . "\n";

    // Example 3: Search for documents in date range
    $searchResponse = $api->read(
        Block::FinancialDoc,
        ['DocType', 'DocNumber', 'DocDate', 'PartnerCode', 'TotalAmount'],
        [
            new FilterBetween('DocDate', date('Y-m-d', strtotime('-7 days')), date('Y-m-d')),
            new FilterEqual('DocType', 'Invoice')
        ],
        'Sheet',
        null,
        'FinancialDoc_Search_1'
    );

    if ($searchResponse === null) {
        echo "Failed to search financial documents\n";
        exit(1);
    }

    echo "\nSearch Results:\n";
    foreach ($searchResponse->FinancialDoc as $doc) {
        echo "Type: " . (string)$doc->DocType . 
             ", Number: " . (string)$doc->DocNumber . 
             ", Date: " . (string)$doc->DocDate . 
             ", Partner: " . (string)$doc->PartnerCode . 
             ", Amount: " . (string)$doc->TotalAmount . "\n";
    }

    // Example 4: Delete the document
    $deleteXml = $api->buildDataBlock('FinancialDoc', ['FinancialDocID' => $docId], 'FD1');
    $deleteResponse = $api->delete(
        Block::FinancialDoc,
        $deleteXml,
        'Tree',
        null,
        'FinancialDoc_Delete_1'
    );

    if ($deleteResponse === null) {
        echo "Failed to delete financial document\n";
        exit(1);
    }

    echo "\nSuccessfully deleted financial document\n";

} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
} 