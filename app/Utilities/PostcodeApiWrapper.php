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

    /**
     * @var CommonFunctions
     */
    private $commonFunctions;

    public function __construct(CommonFunctions $commonFunctions)
    {
        $this->baseUri = env("POSTCODE_API_BASE_URL");
        $this->apiKey = env("NPC_API_KEY");
        $this->httpClient = new HttpClient($this->baseUri);
        $this->commonFunctions = $commonFunctions;
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

    public function getStatesDirectory($stateSlug = null)
    {
        $endpoint = 'directory/states';
        $params = [];

        if (!empty($stateSlug)) {
            $params['stateSlug'] = $stateSlug;
        }

        $response = $this->sendRequest($endpoint, $params);

        if (!array_key_exists('error', $response)) {
            return $response['content'];
        }

        return $response;
    }

    /**
     * Retrieves Nigerian LocalGovernmentArea/s for a State.
     *
     * @param string $stateCode
     * @param integer $lgaId
     * @return mixed
     */
    public function getLocalGovernmentAreas($stateCode, $lgaId = null)
    {
        $endpoint = 'geography/lgas';
        $params = [];
        $params['stateCode'] = $stateCode;

        if (!empty($lgaId)) {
            $params['lgaId'] = $lgaId;
        }

        $response = $this->sendRequest($endpoint, $params);

        if (!array_key_exists('error', $response)) {
            return $response['content'];
        }

        return $response;
    }

    public function getLocalGovernmentAreasDirectory($stateSlug, $lgaSlug = null)
    {
        $endpoint = 'directory/states/' . $stateSlug . '/lgas';
        $params = [];

        if (!empty($lgaSlug)) {
            $params['lgaSlug'] = $lgaSlug;
        }

        $response = $this->sendRequest($endpoint, $params);

        if (!array_key_exists('error', $response)) {
            return $response['content'];
        }

        return $response;
    }

    /**
     * Retrieves Post Office Facilities for a given LGA.
     *
     * @param integer $lgaId
     * @param integer $facilityId
     * @return mixed
     */
    public function getFacilities($lgaId, $facilityId = null)
    {
        $endpoint = 'geography/facilities';
        $params = [];

        $params['lgaId'] = $lgaId;

        if (!empty($facilityId)) {
            $params['postOfficeFacilityId'] = $facilityId;
        }

        $response = $this->sendRequest($endpoint, $params);

        if (!array_key_exists('error', $response)) {
            return $response['content'];
        }

        return $response;
    }

    public function getFacilitiesDirectory($stateSlug, $lgaSlug)
    {
        $endpoint = 'directory/states/' . $stateSlug . '/lgas/' . $lgaSlug . '/facilities';
        $params = [];

        $response = $this->sendRequest($endpoint, $params);

        if (!array_key_exists('error', $response)) {
            return $response['content'];
        }

        return $response;
    }

    /**
     * Retrieves the Rural Areas in a given LGA.
     *
     * @param integer $lgaId
     * @param integer $ruralAreaId
     * @return mixed
     */
    public function getRuralAreas($lgaId, $ruralAreaId = null)
    {
        $endpoint = 'geography/ruralAreas';
        $params = [];

        $params['lgaId'] = $lgaId;

        if (!empty($ruralAreaId)) {
            $params['ruralAreaId'] = $ruralAreaId;
        }

        $response = $this->sendRequest($endpoint, $params);

        if (!array_key_exists('error', $response)) {
            return $response['content'];
        }

        return $response;
    }

    public function getRuralAreasDirectory($stateSlug, $lgaSlug, $ruralAreaSlug = null)
    {
        $endpoint = 'directory/states/' . $stateSlug . '/lgas/' . $lgaSlug . '/ruralAreas';
        $params = [];

        if (!empty($ruralAreaSlug)) {
            $params['ruralAreaSlug'] = $ruralAreaSlug;
        }

        $response = $this->sendRequest($endpoint, $params);

        if (!array_key_exists('error', $response)) {
            return $response['content'];
        }

        return $response;
    }

    /**
     * Retrieves the Rural Villages in a given Rural Area.
     *
     * @param integer $ruralAreadId
     * @param integer $ruralVillageId
     * @return mixed
     */
    public function getRuralVillages($ruralAreaId, $ruralVillageId = null)
    {
        $endpoint = 'geography/ruralVillages';
        $params = [];

        $params['ruralAreaId'] = $ruralAreaId;

        if (!empty($ruralVillageId)) {
            $params['ruralVillageId'] = $ruralVillageId;
        }

        $response = $this->sendRequest($endpoint, $params);

        if (!array_key_exists('error', $response)) {
            return $response['content'];
        }

        return $response;
    }

    public function getVillagesDirectory($stateSlug, $lgaSlug, $ruralAreaSlug)
    {
        $endpoint = 'directory/states/' . $stateSlug . '/lgas/' . $lgaSlug . '/ruralAreas/' . $ruralAreaSlug . '/villages';
        $params = [];

        $response = $this->sendRequest($endpoint, $params);

        if (!array_key_exists('error', $response)) {
            return $response['content'];
        }

        return $response;
    }

    /**
     * Retrieves the Urban Towns in a given State.
     *
     * @param string $stateCode
     * @param integer $urbanTownId
     * @return mixed
     */
    public function getUrbanTowns($stateCode, $urbanTownId = null)
    {
        $endpoint = 'geography/urbanTowns';
        $params = [];

        $params['stateCode'] = $stateCode;

        if (!empty($urbanTownId)) {
            $params['urbanTownId'] = $urbanTownId;
        }

        $response = $this->sendRequest($endpoint, $params);

        if (!array_key_exists('error', $response)) {
            return $response['content'];
        }

        return $response;
    }

    public function getUrbanTownsDirectory($stateSlug, $urbanTownSlug = null)
    {
        $endpoint = 'directory/states/'. $stateSlug . '/urbanTowns';
        $params = [];

        if (!empty($urbanTownSlug)) {
            $params['urbanTownSlug'] = $urbanTownSlug;
        }

        $response = $this->sendRequest($endpoint, $params);

        if (!array_key_exists('error', $response)) {
            return $response['content'];
        }

        return $response;
    }

    /**
     * Retrieves the Urban Areas in a given Urban Town.
     *
     * @param integer $urbanTownId
     * @param integer $urbanAreaId
     * @return mixed
     */
    public function getUrbanAreas($urbanTownId, $urbanAreaId = null)
    {
        $endpoint = 'geography/urbanAreas';
        $params = [];

        $params['urbanTownId'] = $urbanTownId;

        if (!empty($urbanAreaId)) {
            $params['urbanAreaId'] = $urbanAreaId;
        }

        $response = $this->sendRequest($endpoint, $params);

        if (!array_key_exists('error', $response)) {
            return $response['content'];
        }

        return $response;
    }

    public function getUrbanAreasDirectory($stateSlug, $urbanTownSlug, $urbanAreaSlug = null)
    {
        $endpoint = 'directory/states/'. $stateSlug . '/urbanTowns/' . $urbanTownSlug . '/urbanAreas';
        $params = [];

        if (!empty($urbanAreaSlug)) {
            $params['urbanAreaSlug'] = $urbanAreaSlug;
        }

        $response = $this->sendRequest($endpoint, $params);

        if (!array_key_exists('error', $response)) {
            return $response['content'];
        }

        return $response;
    }

    /**
     * Retrieves the Urban Streets in a given Urban Area.
     *
     * @param integer $urbanAreaId
     * @param integer $urbanStreetId
     * @return mixed
     */
    public function getUrbanStreets($urbanAreaId, $urbanStreetId = null)
    {
        $endpoint = 'geography/urbanStreets';
        $params = [];

        $params['urbanAreaId'] = $urbanAreaId;

        if (!empty($urbanStreetId)) {
            $params['urbanStreetId'] = $urbanStreetId;
        }

        $response = $this->sendRequest($endpoint, $params);

        if (!array_key_exists('error', $response)) {
            return $response['content'];
        }

        return $response;
    }

    public function getStreetsDirectory($stateSlug, $urbanTownSlug, $urbanAreaSlug)
    {
        $endpoint = 'directory/states/'. $stateSlug . '/urbanTowns/' . $urbanTownSlug . '/urbanAreas/' . $urbanAreaSlug . '/streets';
        $params = [];
        
        $response = $this->sendRequest($endpoint, $params);

        if (!array_key_exists('error', $response)) {
            return $response['content'];
        }

        return $response;
    }

    /**
     * Search by postcode.
     *
     * @param string $postcode
     * @return mixed
     */
    public function searchByPostcode($postcode)
    {
        $endpoint = 'search/bypostcode';
        $params = [];

        $params['postcode'] = $postcode;

        $response = $this->sendRequest($endpoint, $params);

        if (!array_key_exists('error', $response)) {
            return $response['content'];
        }

        return $response;
    }

    /**
     * Search by full or partial Street name.
     *
     * @param string $streetNameHint
     * @return mixed
     */
    public function searchByStreetName($streetNameHint)
    {
        $endpoint = 'search/byStreet';
        $params = [];

        $params['streetNameHint'] = $streetNameHint;

        $response = $this->sendRequest($endpoint, $params);

        if (!array_key_exists('error', $response)) {
            return $response['content'];
        }

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

            $cacheKey = $this->commonFunctions->getCacheKey($endpoint, $params);
            $responseArray = $this->commonFunctions->retrieveFromCache($cacheKey);

            if ($responseArray == null) {
                $response = $this->httpClient->makeRequest($endpoint, $params, $method, $clientOptions,
                        $isJsonData, $isMultipart);

                Log::info('RESPONSE: ' . $response->getBody());

                $responseArray = $this->commonFunctions->convertToAssociativeArray($response->getBody()) ['response'];
                $this->commonFunctions->storeInCache($cacheKey, $responseArray);
            }
        } catch ( ClientException $ex ) {
            $response = $this->commonFunctions->convertToAssociativeArray(
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

}
