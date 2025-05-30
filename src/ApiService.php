<?php

namespace Initium\Jumis\Api;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;
use Initium\Jumis\Api\Enums\Operation;
use Initium\Jumis\Api\Enums\Block;
use Initium\Jumis\Api\Filters\Filter;

class ApiService
{
    protected string $username;
    protected string $password;
    protected string $database;
    protected string $apikey;
    protected string $endpoint;
    protected string $documentVersion = 'TJ5.5.101';

    public function __construct()
    {
        $this->username = config('jumis.username');
        $this->password = config('jumis.password');
        $this->database = config('jumis.database');
        $this->apikey   = config('jumis.apikey');
        $this->endpoint = config('jumis.endpoint');
    }

    /**
     * Read data from Jumis API
     *
     * @param Block $block The block to read from
     * @param array $fields Array of fields to read (can be enum cases or strings)
     * @param array $filters Array of filters to apply
     * @param string $structure Response structure type (Tree or Sheet)
     * @param string|null $version API version
     * @param string|null $requestId Optional request identifier
     * @param bool $readAll Whether to read all records (mutually exclusive with filters)
     * @param bool $returnId Whether to return IDs in response
     * @param bool $returnSync Whether to return sync information
     * @return mixed
     */
    public function read(
        Block $block, 
        array $fields = [], 
        array $filters = [], 
        string $structure = 'Tree', 
        ?string $version = null,
        ?string $requestId = null,
        bool $readAll = false,
        bool $returnId = false,
        bool $returnSync = false
    ): mixed {
        $version ??= $this->documentVersion;
        $xml = $this->buildReadRequestXML(
            $block->value, 
            $fields, 
            $filters, 
            $structure, 
            $version,
            $requestId,
            $readAll,
            $returnId,
            $returnSync
        );

        return $this->sendRequest($xml);
    }

    /**
     * Insert data into Jumis API
     *
     * @param Block $block The block to insert into
     * @param string $xmlBody XML body for the request
     * @param string $structure Response structure type
     * @param string|null $version API version
     * @param string|null $requestId Optional request identifier
     * @return mixed
     */
    public function insert(
        Block $block, 
        string $xmlBody, 
        string $structure = 'Tree', 
        ?string $version = null,
        ?string $requestId = null
    ): mixed {
        return $this->modify(
            Operation::Insert, 
            $block->value, 
            $xmlBody, 
            $structure, 
            $version,
            $requestId
        );
    }

    /**
     * Update data in Jumis API
     *
     * @param Block $block The block to update
     * @param string $xmlBody XML body for the request
     * @param string $structure Response structure type
     * @param string|null $version API version
     * @param string|null $requestId Optional request identifier
     * @return mixed
     */
    public function update(
        Block $block, 
        string $xmlBody, 
        string $structure = 'Tree', 
        ?string $version = null,
        ?string $requestId = null
    ): mixed {
        return $this->modify(
            Operation::Update, 
            $block->value, 
            $xmlBody, 
            $structure, 
            $version,
            $requestId
        );
    }

    /**
     * Delete data from Jumis API
     *
     * @param Block $block The block to delete from
     * @param string $xmlBody XML body for the request
     * @param string $structure Response structure type
     * @param string|null $version API version
     * @param string|null $requestId Optional request identifier
     * @return mixed
     */
    public function delete(
        Block $block, 
        string $xmlBody, 
        string $structure = 'Tree', 
        ?string $version = null,
        ?string $requestId = null
    ): mixed {
        return $this->modify(
            Operation::Delete, 
            $block->value, 
            $xmlBody, 
            $structure, 
            $version,
            $requestId
        );
    }

    /**
     * Build a data block XML
     *
     * @param string $element Element name
     * @param array $fields Array of fields (can be enum cases or strings)
     * @param string|null $tagId Optional tag ID
     * @return string
     */
    public function buildDataBlock(string $element, array $fields, string $tagId = null): string
    {
        $fieldXml = collect($fields)->map(function ($value, $key) {
            $fieldName = $key instanceof \BackedEnum ? $key->value : $key;
            return "<$fieldName>$value</$fieldName>";
        })->implode("\n");

        $tagAttribute = $tagId ? " TagID=\"$tagId\"" : '';

        return "<$element$tagAttribute>\n$fieldXml\n</$element>";
    }

    /**
     * Build a nested block XML
     *
     * @param string $parent Parent element name
     * @param string $child Child element name
     * @param array $fields Array of fields (can be enum cases or strings)
     * @param string|null $parentTagId Optional parent tag ID
     * @param string|null $childTagId Optional child tag ID
     * @return string
     */
    public function buildNestedBlock(string $parent, string $child, array $fields, string $parentTagId = null, string $childTagId = null): string
    {
        $childXml = $this->buildDataBlock($child, $fields, $childTagId);
        $tagAttribute = $parentTagId ? " TagID=\"$parentTagId\"" : '';

        return "<$parent$tagAttribute>\n$childXml\n</$parent>";
    }

    /**
     * Build read request XML
     *
     * @param string $blockName Block name
     * @param array $fields Array of fields (can be enum cases or strings)
     * @param array $filters Array of filters
     * @param string $structure Response structure type
     * @param string $version API version
     * @param string|null $requestId Optional request identifier
     * @param bool $readAll Whether to read all records
     * @param bool $returnId Whether to return IDs
     * @param bool $returnSync Whether to return sync info
     * @return string
     */
    protected function buildReadRequestXML(
        string $blockName, 
        array $fields, 
        array $filters = [], 
        string $structure = 'Tree', 
        string $version = 'TJ5.5.101',
        ?string $requestId = null,
        bool $readAll = false,
        bool $returnId = false,
        bool $returnSync = false
    ): string {
        $fieldXml = collect($fields)->map(function ($field) {
            $fieldName = $field instanceof \BackedEnum ? $field->value : $field;
            return "<Field Name=\"$fieldName\"/>";
        })->implode("\n");

        $filterXml = collect($filters)->map(function ($filter) {
            if ($filter instanceof Filter) {
                $filter = $filter->toArray();
            }
            $attrs = collect($filter)->map(fn($v, $k) => "$k=\"$v\"")->implode(' ');
            return "<Filter $attrs />";
        })->implode("\n");

        // Build tjData attributes
        $dataAttrs = [];
        if ($readAll) {
            $dataAttrs[] = 'Read="All"';
        }
        if ($returnId) {
            $dataAttrs[] = 'ReturnID="1"';
        }
        if ($returnSync) {
            $dataAttrs[] = 'ReturnSync="1"';
        }
        $dataAttrsStr = !empty($dataAttrs) ? ' ' . implode(' ', $dataAttrs) : '';

        // Build request attributes
        $requestAttrs = [
            "Name=\"$blockName\"",
            "Operation=\"Read\"",
            "Version=\"$version\"",
            "Structure=\"$structure\""
        ];
        if ($requestId) {
            $requestAttrs[] = "RequestID=\"$requestId\"";
        }
        $requestAttrsStr = implode(' ', $requestAttrs);

        return <<<XML
<?xml version="1.0" ?>
<dataroot>
  <tjDocument Version="$version"/>
  <tjRequest $requestAttrsStr>
    <tjData$dataAttrsStr>
      $filterXml
    </tjData>
    <tjFields>
      $fieldXml
    </tjFields>
  </tjRequest>
</dataroot>
XML;
    }

    /**
     * Send request to Jumis API
     *
     * @param string $xml XML request body
     * @return mixed
     */
    protected function sendRequest(string $xml): mixed
    {
        $payload = [
            'username'   => $this->username,
            'password'   => $this->password,
            'database'   => $this->database,
            'apikey'     => $this->apikey,
            'XMLrequest' => $xml,
        ];

        try {
            $response = Http::post($this->endpoint, $payload);

            if (!$response->successful()) {
                Log::error('Jumis API error', ['status' => $response->status(), 'body' => $response->body()]);
                return null;
            }

            $xml = new SimpleXMLElement($response->body());

            // Check for errors
            if (isset($xml->tjError)) {
                $error = $xml->tjError;
                Log::error('Jumis API error', [
                    'id' => (string)$error['ID'],
                    'description' => (string)$error['Description'],
                    'comment' => (string)$error['Comment'] ?? null,
                    'commentId' => (string)$error['CommentID'] ?? null
                ]);
                return null;
            }

            return $xml;
        } catch (\Throwable $e) {
            Log::error('Jumis API connection failed', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Modify data in Jumis API (insert/update/delete)
     *
     * @param Operation $operation Operation type
     * @param string $blockName Block name
     * @param string $xmlBody XML body
     * @param string $structure Response structure type
     * @param string|null $version API version
     * @param string|null $requestId Optional request identifier
     * @return mixed
     */
    protected function modify(
        Operation $operation, 
        string $blockName, 
        string $xmlBody, 
        string $structure, 
        ?string $version,
        ?string $requestId = null
    ): mixed {
        $version ??= $this->documentVersion;

        // Build request attributes
        $requestAttrs = [
            "Name=\"$blockName\"",
            "Operation=\"{$operation->value}\"",
            "Version=\"$version\"",
            "Structure=\"$structure\""
        ];
        if ($requestId) {
            $requestAttrs[] = "RequestID=\"$requestId\"";
        }
        $requestAttrsStr = implode(' ', $requestAttrs);

        $xml = <<<XML
<?xml version="1.0" ?>
<dataroot>
  <tjDocument Version="$version"/>
  <tjRequest $requestAttrsStr>
    $xmlBody
  </tjRequest>
</dataroot>
XML;

        return $this->sendRequest($xml);
    }

    /**
     * Build a financial document line XML with accounting schema field
     *
     * @param array $fields Array of fields (can be enum cases or strings)
     * @param string $accountingSchemaFieldName Accounting schema field name
     * @param string|null $tagId Optional tag ID
     * @return string
     */
    public function buildFinancialDocLine(array $fields, string $accountingSchemaFieldName, string $tagId = null): string
    {
        $fields['AccountingSchemaFieldName'] = $accountingSchemaFieldName;
        return $this->buildDataBlock('FinancialDocLine', $fields, $tagId);
    }

    /**
     * Insert financial document with accounting schema
     *
     * @param string $xmlBody XML body for the request
     * @param string $sourceAppName Source application name
     * @param string $sourceAppVersion Source application version
     * @param string|null $accountingSchemaName Accounting schema name
     * @param int|null $accountingSchemaId Accounting schema ID
     * @param string $structure Response structure type
     * @param string|null $version API version
     * @return mixed
     */
    public function insertFinancialDoc(string $xmlBody, string $sourceAppName, string $sourceAppVersion, ?string $accountingSchemaName = null, ?int $accountingSchemaId = null, string $structure = 'Tree', ?string $version = null): mixed
    {
        $version ??= 'TJ5.5.120';
        return $this->modify(Operation::Insert, 'FinancialDoc', $xmlBody, $structure, $version, null, $sourceAppName, $sourceAppVersion, $accountingSchemaName, $accountingSchemaId);
    }
} 