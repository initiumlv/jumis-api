# Jumis API Integration

A PHP library for integrating with Tildes Jumis ERP system's XML-based API.

## Installation

```bash
composer require initium/jumis-api
```

## Configuration

Create a `.env` file in your project root with the following settings:

```env
JUMIS_API_URL=https://your-jumis-instance.com/api
JUMIS_API_USERNAME=your_username
JUMIS_API_PASSWORD=your_password
JUMIS_API_VERSION=TJ5.5.101
```

## Basic Usage

```php
use Initium\Jumis\Api\ApiService;

$api = new ApiService();

// Read data
$response = $api->read(
    Block::Product,
    ['ProductCode', 'ProductName', 'Price'],
    [new FilterEqual('ProductCode', 'PROD001')]
);

// Insert data
$response = $api->insert(
    Block::Product,
    $xmlData,
    'Tree'
);

// Update data
$response = $api->update(
    Block::Product,
    $xmlData,
    'Tree'
);

// Delete data
$response = $api->delete(
    Block::Product,
    $xmlData,
    'Tree'
);
```

## Available Blocks

The API supports the following data blocks:

- `Block::Product` - Products
- `Block::Partner` - Business partners (customers/suppliers)
- `Block::StoreDoc` - Store documents (purchases/sales)
- `Block::FinancialDoc` - Financial documents (invoices/payments)
- `Block::Warehouse` - Warehouses
- `Block::Currency` - Currencies
- `Block::VATRate` - VAT rates
- `Block::AccountingSchema` - Accounting schemas

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

### FilterTree
Tree-based filtering with optional child inclusion:
```php
new FilterTree('CategoryID', 1, true) // true to include children
```

### FilterDimension
Dimension-based filtering:
```php
new FilterDimension('DimensionID', 'CostCenter', 'CC001', true)
```

## XML Building

### Simple Data Block
```php
$xml = $api->buildDataBlock(
    'Product',
    [
        'ProductCode' => 'PROD001',
        'ProductName' => 'Test Product',
        'Price' => 19.99
    ],
    'P1'  // Tag ID
);
```

### Nested Data Block
```php
$xml = $api->buildNestedBlock(
    'StoreDoc',
    'StoreDocLine',
    [
        // Document header
        'DocType' => 'Purchase',
        'DocNumber' => 'PO-001',
        // Document line
        'ProductCode' => 'PROD001',
        'Quantity' => 10
    ],
    'SD1',  // Document tag ID
    'SDL1'  // Line tag ID
);
```

## Document Statuses

The library provides a `DocumentStatus` enum for handling document statuses in a type-safe way:

```php
use Initium\Jumis\Api\Enums\DocumentStatus;

// Get status label
$label = DocumentStatus::APPROVED->label();  // Returns "Apstiprināts"

// Get status description
$description = DocumentStatus::APPROVED->description();  // Returns "Document has been approved"

// Compare statuses
if ($documentStatus === DocumentStatus::APPROVED) {
    // Document is approved
}
```

### Available Statuses
- `DocumentStatus::STARTED` (1) - Iesākts (Started)
- `DocumentStatus::ENTERED` (2) - Ievadīts (Entered)
- `DocumentStatus::APPROVED` (5) - Apstiprināts (Approved)
- `DocumentStatus::POSTED` (6) - Kontēts (Posted)

## Examples

### Partner Operations
```php
// Create partner
$partnerXml = $api->buildDataBlock(
    'Partner',
    [
        'PartnerCode' => 'CUST001',
        'PartnerName' => 'Test Customer',
        'PartnerType' => 'Customer',
        'VATNumber' => 'LV12345678901'
    ],
    'P1'
);

$response = $api->insert(Block::Partner, $partnerXml, 'Tree');
```

### Store Document Operations
```php
use Initium\Jumis\Api\Enums\DocumentStatus;

// Create store document
$storeDocXml = $api->buildNestedBlock(
    'StoreDoc',
    'StoreDocLine',
    [
        'DocType' => 'Purchase',
        'DocNumber' => 'PO-001',
        'DocDate' => date('Y-m-d'),
        'ProductCode' => 'PROD001',
        'Quantity' => 10
    ],
    'SD1',
    'SDL1'
);

$response = $api->insert(Block::StoreDoc, $storeDocXml, 'Tree');

// Update document status to approved
$updateXml = $api->buildDataBlock(
    'StoreDoc',
    [
        'StoreDocID' => $docId,
        'DocStatus' => DocumentStatus::APPROVED->value  // Using enum value
    ],
    'SD1'
);

$response = $api->update(Block::StoreDoc, $updateXml, 'Tree');

// Check document status
$docResponse = $api->read(
    Block::StoreDoc,
    ['DocStatus'],
    [new FilterEqual('StoreDocID', $docId)]
);

if ($docResponse && $docResponse['DocStatus'] === DocumentStatus::APPROVED->value) {
    echo "Document is " . DocumentStatus::APPROVED->label();
}
```

### Financial Document Operations
```php
// Create financial document
$financialDocXml = $api->buildNestedBlock(
    'FinancialDoc',
    'FinancialDocLine',
    [
        'DocType' => 'Invoice',
        'DocNumber' => 'INV-001',
        'DocDate' => date('Y-m-d'),
        'AccountingSchemaFieldName' => 'Sales',
        'LineAmount' => 199.90
    ],
    'FD1',
    'FDL1'
);

$response = $api->insert(Block::FinancialDoc, $financialDocXml, 'Tree');
```

## Error Handling

The API methods return `null` on failure. Always check the response:

```php
$response = $api->read(Block::Product, ['ProductCode'], []);
if ($response === null) {
    // Handle error
}
```

## Request Options

All API methods support the following optional parameters:

- `structureType` - 'Tree' or 'Sheet' (default: 'Tree')
- `requestId` - Custom request identifier
- `readAll` - Whether to read all records (default: false)
- `returnId` - Whether to return IDs in response (default: false)
- `returnSync` - Whether to return sync information (default: false)

Example:
```php
$response = $api->read(
    Block::Product,
    ['ProductCode'],
    [],
    'Tree',
    null,
    'CustomRequestID',
    true,  // readAll
    true,  // returnId
    true   // returnSync
);
```

## Best Practices

1. Always use proper error handling
2. Use meaningful request IDs for tracking
3. Use appropriate filter types for queries
4. Include only necessary fields in read operations
5. Use Tree structure for hierarchical data
6. Use Sheet structure for flat data lists
7. Verify document status changes
8. Keep tag IDs unique within a request

## Contributing

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct and the process for submitting pull requests.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.