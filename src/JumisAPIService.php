<?php

namespace Initium\Jumis\Api;

use GuzzleHttp\Client;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Str;
use Initium\Jumis\Api\Components\XML;


class JumisAPIService
{

    protected string $baseEndpoint;
    protected ?string $requestVersion = null;

    protected string $structure = 'Tree';

    protected Client $client;

    protected static array $requestVersions = [
        'Product' => 'TJ5.5.101',
        'Partner' => 'TJ7.0.112',
        'FinancialDoc' => 'TJ7.0.112',
        'StoreDoc' => 'TJ5.5.125',
    ];

    public static function make(): JumisAPIService
    {
        return new static(config('jumis.url'),
            config('jumis.username'),
            config('jumis.password'),
            config('jumis.database'),
            config('jumis.apikey'),
            config('jumis.document_version'),
            config('jumis.guzzle'));
    }

    public static function addVersion(string $dataBlock, string $version): void
    {
        self::$requestVersions[$dataBlock] = $version;
    }


    public function __construct(string           $endpoint, protected string $username, protected string $password,
                                protected string $database, protected string $apikey, protected string $documentVersion,
                                array            $guzzleOptions = [])
    {
        $this->baseEndpoint = rtrim($endpoint, '/');

        $this->client = new Client($guzzleOptions);
    }

    /**
     * Sets the document version for API requests.
     *
     * @param string $version The document version string.
     * @return void
     */
    public function setDocumentVersion(string $version): void
    {
        $this->documentVersion = $version;
    }

    /**
     * Sets the request version for API requests.
     *
     * @param string $version The request version string.
     * @return void
     */
    public function setRequestVersion(string $version): void
    {
        $this->requestVersion = $version;
    }

    public function setStructure(string $structure): void
    {
        if (!in_array($structure, ['Tree', 'Sheet'])) {
            throw new JumisException('Invalid request structure has been set!');
        }

        $this->structure = $structure;
    }

    /**
     * Constructs the full API endpoint URL for a given operation.
     *
     * @param string $operation The API operation (e.g., 'Read', 'Insert').
     * @return string The full API endpoint URL.
     */
    protected function getEndpoint(string $operation): string
    {
        return $this->baseEndpoint . '/' . ($operation === 'Read' ? 'export' : 'import');
    }

    /**
     * Sends a 'Read' operation request to the API.
     *
     * @param string $dataBlock The name of the datablock to read from (e.g., 'Product', 'Partner').
     * @param array $fields An array of field definitions. Each definition can be:
     *                      - A string: Field name (e.g., 'ProductName').
     *                      - An array for sorting: ['name' => 'ProductCode', 'sort' => 'Asc', 'sortLevel' => 1].
     *                          'sort' can be 'Asc' or 'Desc'. 'sortLevel' must be a positive integer starting from 1.
     *                      - An associative array for grouped fields: ['GroupName' => [
     *                            'SimpleFieldInGroup',
     *                            ['name' => 'SortableFieldInGroup', 'sort' => 'Desc', 'sortLevel' => 1]
     *                        ]].
     * @param array $filters An array of filters to apply to the query.
     * @param string|null $requestId An optional request ID.
     * @param array $flags An array of flags for the read operation. Possible flags include:
     *                     ReturnID, ReturnSync, Read => All.
     * @return mixed The parsed XML response from the API as an array, or null on failure before parsing.
     * @throws \Exception|GuzzleException If there is an error parsing the XML response.
     */
    public function read(string $dataBlock, array $fields = [], array $filters = [], ?string $requestId = null, array $flags = []): mixed
    {
        if (empty($dataBlock)) {
            throw new JumisException('You must provide a data block to read from API!');
        }

        if (empty($fields)) {
            throw new JumisException('You must provide a fields array to read from API!');
        }

        $allowedFlags = ['Read', 'ReturnID', 'ReturnSync'];
        $unknownFlags = array_diff(array_keys($flags), $allowedFlags);

        if (!empty($unknownFlags)) {
            throw new JumisException('Unknown flags provided: ' . implode(', ', $unknownFlags));
        }

        /*
         * Check if a specific request version is set, if not attempt to load
         * default values from a configuration file
         */
        if ($this->requestVersion == null) {
            $this->requestVersion = self::$requestVersions[$dataBlock] ?? null;
        }

        /*
         * If the default value from a configuration file cannot be loaded, throws an exception
         * request value must be set for each request
         */
        if ($this->requestVersion === null) {
            throw new JumisException('Jumis API Request version is not set!');
        }

        $fields = XML::prepareFields($fields);
        $filters = XML::prepareFilters($filters);

        /*
         * When no filters are passed flag Read all always must be set
         */
        if (empty($filters)) {
            $flags['Read'] = 'All';
        }

        $flags = XML::prepareAttributes($flags);

        $attributes = [
            'Name' => $dataBlock,
            'Operation' => 'Read',
            'Version' => $this->requestVersion,
            'Structure' => $this->structure,
        ];

        if ($requestId) {
            $attributes['RequestID'] = $requestId;
        }

        $attributes = XML::prepareAttributes($attributes);
        $version = $this->documentVersion;

        $response = <<<XML
<?xml version="1.0" ?>
<dataroot>
<tjDocument Version="$version"/>
<tjRequest $attributes>
<tjData $flags>
$filters
</tjData>
<tjFields>
$fields
</tjFields>
</tjRequest>
</dataroot>
XML;

        return $this->sendRequest($response, 'Read');
    }

    /**
     * Sends an 'Insert' operation request to the API.
     *
     * @param string $dataBlock The name of the table to insert into.
     * @param array $fields An array of fields and their values to insert.
     * @param string|null $requestId An optional request ID.
     * @return mixed The parsed XML response from the API as an array, or null on failure before parsing.
     * @throws \Exception|GuzzleException If there is an error parsing the XML response.
     */
    public function insert(string $dataBlock, array $fields, ?string $requestId = null): mixed
    {
        if (empty($dataBlock)) {
            throw new JumisException('You must provide a data block to insert to API!');
        }

        if (empty($fields)) {
            throw new JumisException('You must provide a fields array to insert to API!');
        }


        /*
         * Check if a specific request version is set, if not attempt to load
         * default values from a configuration file
         */
        if ($this->requestVersion == null) {
            $this->requestVersion = self::$requestVersions[$dataBlock] ?? null;
        }

        /*
         * If the default value from a configuration file cannot be loaded, throws an exception
         * request value must be set for each request
         */
        if ($this->requestVersion === null) {
            throw new JumisException('Jumis API Request version is not set!');
        }


        $attributes = [
            'Name' => $dataBlock,
            'Operation' => 'Insert',
            'Version' => $this->requestVersion,
            'Structure' => $this->structure,

        ];

        if ($requestId) {
            $attributes['RequestID'] = $requestId;
        }

        $attributes = XML::prepareAttributes($attributes);
        $response = XML::buildXmlElements($fields, $dataBlock);

        $xml = <<<XML
<?xml version="1.0" ?>
<dataroot>
<tjDocument Version="{$this->documentVersion}"/>
<tjRequest $attributes>
$response
</tjRequest>
</dataroot>
XML;
        return $this->sendRequest($xml, 'Insert');
    }

    /**
     * Sends an XML request to the specified API operation endpoint.
     *
     * @param string $xml The XML request string.
     * @param string $operation The API operation (e.g., 'Read', 'Insert').
     * @return mixed The parsed XML response from the API as an array, or null on failure before parsing.
     * @throws GuzzleException If the HTTP request fails.
     * @throws \Exception If there is an error parsing the XML response.
     */
    protected function sendRequest(string $xml, string $operation): mixed
    {
        $endpoint = $this->getEndpoint($operation);

        $requestData = [
            'username' => $this->username,
            'password' => $this->password,
            'database' => $this->database,
            'apikey' => $this->apikey,
            'XMLrequest' => $xml
        ];

        $response = $this->client->post($endpoint, [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => $requestData,
        ]);

        return $this->parseResponse($response, $operation);

    }

    /**
     * Parses the raw response string from the API.
     *
     * @param string $raw The raw response string.
     * @return array The parsed data, always as an array.
     */
    protected function parseResponse($response, string $operation): array
    {
        $raw = $response->getBody()->getContents();

        if (Str::contains($raw, 'Neizdevās pieslēgties!')) {
            return [
                'status' => 'error',
                'message' => 'Failed to authenticate'
            ];
        }
        if (Str::contains($raw, 'nav datub')) {
            return [
                'status' => 'error',
                'error' => 'Failed to select database'
            ];
        }

        if (empty($raw)) {
            return [];
        }

        $result = json_decode($raw, true);


        if ($operation === 'Read') {

            libxml_use_internal_errors(true);
            $xmlElement = simplexml_load_string($result);
            libxml_clear_errors();

            if ($xmlElement !== false) {

                $parsedArray = json_decode(json_encode($xmlElement), true);

                if (is_array($parsedArray)) {
                    $result = $parsedArray;
                }
            }
        } else {
            if (json_last_error() !== JSON_ERROR_NONE || !is_array($result)) {
                return [];
            }

            if (isset($result[0]['Value']) && is_array($result[0]) && is_string($result[0]['Value'])) {

                libxml_use_internal_errors(true);
                $xmlElement = simplexml_load_string($result[0]['Value']);
                libxml_clear_errors();

                if ($xmlElement !== false) {

                    $parsedArray = json_decode(json_encode($xmlElement), true);

                    if (is_array($parsedArray)) {
                        $result[0]['Value'] = $parsedArray;
                    }

                }
            }

        }
        return $result;
    }
}