<?php
namespace App\Utilities;

use App\Utilities\HttpClient;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use App\Utilities\CommonFunctions;

class W3WApiWrapper
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

    /**
     * @var CommonFunctions
     */
    private $commonFunctions;
    

    public function __construct(CommonFunctions $commonFunctions)
    {
        $this->baseUri = env("W3W_API_BASE_URL");
        $this->apiKey = env("W3W_API_KEY");
        $this->httpClient = new HttpClient($this->baseUri);
        $this->commonFunctions = $commonFunctions;
    }

    // Reverse geocodes coordinates, expressed as latitude and longitude to a 3 word address.
    public function reverseGeocode($lat, $lng)
    {
        $endpoint = 'reverse';
        $params = [];

        $params['coords'] = $lat . ',' . $lng;

        $response = $this->sendRequest($endpoint, $params);

        return $response;
    }

    private function sendRequest($endpoint, $params, $method = 'GET', array $headerOptions = [],
    $isJsonData = false, $isMultipart = false)
    {
        $headerOptions [Config::get('constants.w3w_apiKey_header_name')] = $this->apiKey;
        $clientOptions = [ ];
        $clientOptions ['headers'] = $headerOptions;

        $responseArray = [ ];

        try {
            Log::info('REQUEST: ' . $endpoint);

            $cacheKey = $this->commonFunctions->getCacheKey($endpoint, $params);
            $responseArray = $this->commonFunctions->retrieveFromCache($cacheKey);

            if ($responseArray == null) {
                $response = $this->httpClient->makeRequest($endpoint, $params, $method, $clientOptions,
                        $isJsonData, $isMultipart);

                Log::info('RESPONSE: ' . $response->getBody());

                $responseArray = $this->commonFunctions->convertToAssociativeArray($response->getBody());

                $responseStatus = $responseArray['status'];

                if (array_key_exists('message', $responseStatus) && array_key_exists('code', $responseStatus)) {
                    $responseArray ['error'] = $responseStatus ['message'];
                } else {
                    $this->commonFunctions->storeInCache($cacheKey, $responseArray);
                }
            }
        } catch ( ClientException $ex ) {
            $response = $this->commonFunctions->convertToAssociativeArray(
                    $ex->getResponse()
                        ->getBody());

            if (array_key_exists('message', $response)) {
                $responseArray ['error'] = $response ['message'];
                
            } else {
                $responseArray ['error'] = $response;
            }
            Log::error('ERROR: ' . $ex->getMessage());
        } catch ( ServerException $ex ) {
            $responseArray ['error'] = 'Internal Server Error In W3W API Server: ' . $ex->getMessage();
            Log::error('ERROR: ' . $ex->getMessage());
        } catch ( RequestException $ex ) {
            $responseArray ['error'] = 'Error Recieved From W3W API Request: ' . $ex->getMessage();
            Log::error('ERROR: ' . $ex->getMessage());
        }

        return $responseArray;
    }

}