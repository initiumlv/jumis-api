<?php

namespace Initium\Jumis\Api;

use GuzzleHttp\Client;

use GuzzleHttp\Exception\GuzzleException;
use Initium\Jumis\Api\Components\XML;


class JumisAPIService
{
    protected string $username;
    protected string $password;
    protected string $database;
    protected string $apikey;
    protected string $baseEndpoint;
    protected string $documentVersion = 'TJ5.5.101';
    protected string $requestVersion = 'TJ5.5.101';

    protected Client $client;

    public static function make(): JumisAPIService
    {
        return new static(config('jumis.url'), config('jumis.username'), config('jumis.password'), config('jumis.database'), config('jumis.apikey'), config('jumis.guzzle'));
    }

    /**
     * ApiService constructor.
     *
     * @param string $endpoint The base API endpoint URL.
     * @param string $username The API username.
     * @param string $password The API password.
     * @param string $database The API database name (optional).
     * @param string $apikey The API key (optional).
     * @param array $guzzleOptions Additional options for the Guzzle HTTP client (optional).
     */
    public function __construct(string $endpoint, string $username, string $password, string $database = '', string $apikey = '', array $guzzleOptions = [])
    {
        $this->baseEndpoint = rtrim($endpoint, '/');
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->apikey = $apikey;
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
        $fields = XML::prepareFields($fields);
        $filters = XML::prepareFilters($filters);

        if (empty($filters)) {
            $flags['Read'] = 'All';
        }

        if (!empty($flags)) {// Flags: ReturnID = 1,ReturnSync = 1, Read = All
            $flags = XML::prepareAttributes($flags);
        } else {
            $flags = '';
        }

        $attributes = [
            'Name' => $dataBlock,
            'Operation' => 'Read',
            'Version' => $this->requestVersion,
            'Structure' => 'Tree'
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
        $attributes = [
            'Name' => $dataBlock,
            'Operation' => 'Insert',
            'Version' => $this->requestVersion,
            'Structure' => 'Tree',

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

        return $this->parseResponse($response->getBody()->getContents(), $operation);

    }

    /**
     * Parses the raw response string from the API.
     *
     * @param string $raw The raw response string.
     * @return array The parsed data, always as an array.
     */
    protected function parseResponse(string $raw, string $operation): array
    {


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