<?php

use Initium\Jumis\Api\ApiService;
use Initium\Jumis\Api\Enums\Block;
use Initium\Jumis\Api\Filters\FilterEqual;
use Initium\Jumis\Api\Filters\FilterLike;

// Initialize API service
$api = new ApiService();

// Example 1: Insert a new product with prices
try {
    // Build product data
    $productXml = $api->buildNestedBlock(
        'Product',
        'ProductPrice',
        [
            'ProductCode' => 'TEST001',
            'ProductName' => 'Test Product',
            'ProductBarCode' => '123456789',
            'ProductUnit' => 'PCS',
            'PriceTypeName' => 'Retail price',
            'PriceCurrency' => 'EUR',
            'Price' => 19.99
        ],
        'P1',  // Product tag ID
        'PP1'  // Price tag ID
    );

    // Insert the product
    $insertResponse = $api->insert(
        Block::Product,
        $productXml,
        'Tree',
        null,
        'Product_Insert_1'
    );

    if ($insertResponse === null) {
        echo "Failed to insert product\n";
        exit(1);
    }

    // Extract the new product ID from response
    $productId = (string)$insertResponse->Product->ProductID;
    echo "Successfully inserted product with ID: $productId\n";

    // Example 2: Read the inserted product
    $readResponse = $api->read(
        Block::Product,
        ['ProductCode', 'ProductName', 'ProductBarCode', 'ProductUnit'],
        [new FilterEqual('ProductID', $productId)],
        'Tree',
        null,
        'Product_Read_1',
        false,
        true,  // Return IDs
        true   // Return sync info
    );

    if ($readResponse === null) {
        echo "Failed to read product\n";
        exit(1);
    }

    // Display product details
    $product = $readResponse->Product;
    echo "\nProduct Details:\n";
    echo "Code: " . (string)$product->ProductCode . "\n";
    echo "Name: " . (string)$product->ProductName . "\n";
    echo "Barcode: " . (string)$product->ProductBarCode . "\n";
    echo "Unit: " . (string)$product->ProductUnit . "\n";

    // Example 3: Search for products using LIKE filter
    $searchResponse = $api->read(
        Block::Product,
        ['ProductCode', 'ProductName'],
        [new FilterLike('ProductName', 'Test%')],
        'Sheet',
        null,
        'Product_Search_1'
    );

    if ($searchResponse === null) {
        echo "Failed to search products\n";
        exit(1);
    }

    echo "\nSearch Results:\n";
    foreach ($searchResponse->Product as $product) {
        echo "Code: " . (string)$product->ProductCode . ", Name: " . (string)$product->ProductName . "\n";
    }

    // Example 4: Delete the product
    $deleteXml = $api->buildDataBlock('Product', ['ProductID' => $productId], 'P1');
    $deleteResponse = $api->delete(
        Block::Product,
        $deleteXml,
        'Tree',
        null,
        'Product_Delete_1'
    );

    if ($deleteResponse === null) {
        echo "Failed to delete product\n";
        exit(1);
    }

    echo "\nSuccessfully deleted product\n";

} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
} 