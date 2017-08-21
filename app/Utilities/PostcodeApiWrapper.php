<?php
namespace App\Utilities;

use App\Utilities\HttpClient;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;

class PostcodeApiWrapper
{
    /**
     * @var string
     */
    private $baseUri;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var HttpClient
     */
    private $httpClient;

    public function __construct()
    {
        $this->baseUri = env("POSTCODE_API_BASE_URL");
        $this->apiKey = env("NPC_API_KEY");
        $this->httpClient = new HttpClient($this->baseUri);
    }

    /**
     * Retrieves Nigerian State/s.
     */
    public function getStates($stateCode = null)
    {
        $endpoint = 'geography/states';
        $params = [];

        if (!empty($stateCode)) {
            $params['stateCode'] = $stateCode;
        }

        $response = $this->sendRequest($endpoint, $params);

        if (!array_key_exists('error', $response)) {
            return $response['content'];
        }

        return $response;
    }

    /**
     * Retrieves Nigerian LocalGovernmentArea/s for a State.
     */
    public function getLocalGovernmentAreas($stateCode, $lga = null)
    {
        $endpoint = 'geography/states/'. $stateCode . '/lgas';
        $params = [];

        if (!empty($lga)) {
            $params['localGovtAreaName'] = $lga;
        }

        $response = $this->sendRequest($endpoint, $params);

        if (!array_key_exists('error', $response)) {
            return $response['content'];
        }

        return $response;
    }

    /**
     * Retrieves Nigerian Postcodes for Facilities in a State.
     */
    public function getFacilityPostcodes($stateCode, $lga = null, $facilityName = null)
    {
        $endpoint = 'postcodes/facility-postcodes';
        $params = [];

        $params['stateCode'] = $stateCode;

        if (!empty($facilityName)) {
            $params['facilityName'] = $facilityName;
        }

        if (!empty($lga)) {
            $params['localGovtAreaName'] = $lga;
        }

        $response = $this->sendRequest($endpoint, $params);

        if (!array_key_exists('error', $response)) {
            return $response['content'];
        }

        return $response;
    }

    /**
     * Retrieves Nigerian Postcodes for Rural Areas in a State.
     */
    public function getRuralPostcodes($stateCode, $lga = null, $district = null, $town = null)
    {
        $endpoint = 'postcodes/rural-postcodes';
        $params = [];

        $params['stateCode'] = $stateCode;

        if (!empty($town)) {
            $params['town'] = $town;
        }

        if (!empty($district)) {
            $params['district'] = $district;
        }

        if (!empty($lga)) {
            $params['localGovtAreaName'] = $lga;
        }

        $response = $this->sendRequest($endpoint, $params);

        if (!array_key_exists('error', $response)) {
            return $response['content'];
        }

        return $response;
    }

    /**
     * Retrieves Nigerian Postcodes for Urban Areas in a State.
     */
    public function getUrbanPostcodes($stateCode, $town = null, $area = null, $street = null)
    {
        $endpoint = 'postcodes/urban-postcodes';
        $params = [];

        $params['stateCode'] = $stateCode;

        if (!empty($town)) {
            $params['town'] = $town;
        }

        if (!empty($area)) {
            $params['area'] = $area;
        }

        if (!empty($street)) {
            $params['street'] = $street;
        }

        $response = $this->sendRequest($endpoint, $params);

        if (!array_key_exists('error', $response)) {
            return $response['content'];
        }

        return $response;
    }

    public function searchUrbanPostcodes($stateCode, $town, $hint) {
        $endpoint = 'postcodes/urban-postcodes/search';
        $params = [];

        $params['stateCode'] = $stateCode;
        $params['town'] = $town;
        $params['hint'] = $hint;

        $response = $this->sendRequest($endpoint, $params);

        if (!array_key_exists('error', $response)) {
            return $response['content'];
        }

        return $response;
    }

    public function reverseLookup($postcode) {
        $endpoint = 'postcodes/reverse-lookup';
        $params = [];

        $params['postcode'] = $postcode;

        $response = $this->sendRequest($endpoint, $params);

        return $response;
    }

    /**
     *
     * @param string $endpoint
     * @param array|string|resource $params
     * @param string $method
     * @param array $headerOptions
     * @param boolean $isJsonData
     * @return array
     */
    private function sendRequest($endpoint, $params, $method = 'GET', array $headerOptions = [],
            $isJsonData = false, $isMultipart = false)
    {
        $headerOptions [Config::get('constants.postcode_apiKey_header_name')] = $this->apiKey;
        $clientOptions = [ ];
        $clientOptions ['headers'] = $headerOptions;

        $responseArray = [ ];

        try {
            Log::info('REQUEST: ' . $endpoint);

            $cacheKey = $this->getCacheKey($endpoint, $params);
            $responseArray = $this->retrieveFromCache($cacheKey);

            if ($responseArray == null) {
                $response = $this->httpClient->makeRequest($endpoint, $params, $method, $clientOptions,
                        $isJsonData, $isMultipart);

                Log::info('RESPONSE: ' . $response->getBody());

                $responseArray = $this->convertToAssociativeArray($response->getBody()) ['response'];
                $this->storeInCache($cacheKey, $responseArray);
            }
        } catch ( ClientException $ex ) {
            $response = $this->convertToAssociativeArray(
                    $ex->getResponse()
                        ->getBody());

            if (array_key_exists('response', $response)) {
                $responseArray ['error'] = $response ['response']['messageDetails'];
                if (empty($responseArray ['error']) || empty($responseArray ['error'][0])) {
                $responseArray ['error'] = $response ['response']['message'];
                }
            } else if (array_key_exists('message', $response)) {
                $responseArray ['error'] = $response ['message'];
            } else {
                $responseArray ['error'] = $response;
            }
            Log::error('ERROR: ' . $ex->getMessage());
        } catch ( ServerException $ex ) {
            $responseArray ['error'] = 'Internal Server Error In Postcode API Server: ' . $ex->getMessage();
            Log::error('ERROR: ' . $ex->getMessage());
        } catch ( RequestException $ex ) {
            $responseArray ['error'] = 'Error Recieved From Postcode API Request: ' . $ex->getMessage();
            Log::error('ERROR: ' . $ex->getMessage());
        }

        return $responseArray;
    }

    /**
     * Decodes a json object.
     *
     * @param string $string The string to decode.
     *
     * @return associative array.
     * @throws \Exception Response is not a valid JSON string.
     */
    public function convertToAssociativeArray($string)
    {
        $responseArray = json_decode($string, true);

        return $responseArray;
    }

    /**
     * Build the cacheKey.
     */
    private function getCacheKey($endpoint, $params) {
        $cacheKey = $endpoint;

        foreach ($params as $key => $value) {
            $key = str_replace(' ', '', strtolower($key));
            $value = str_replace(' ', '', strtolower($value));
            $keyValue = $key . '_' . $value;
            $cacheKey = $cacheKey . '|' . $keyValue;
        }

        return $cacheKey;
    }

    private function retrieveFromCache($cacheKey) {
        $value = null;
        if (Cache::has($cacheKey)) {
            $value = Cache::get($cacheKey);
            Log::info('CACHE HIT: ' . $cacheKey);
        } else {
            Log::info('CACHE MISS: ' . $cacheKey);
        }

        return $value;
    }

    private function storeInCache($cacheKey, $item) {
        $expirationInMinutes = Config::get('app.cache_ttl');
        Cache::put($cacheKey, $item, $expirationInMinutes);
    }
}
