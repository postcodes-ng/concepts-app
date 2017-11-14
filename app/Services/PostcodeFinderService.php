<?php
namespace App\Services;

use App\Utilities\PostcodeApiWrapper;
use App\Utilities\CommonFunctions;

class PostcodeFinderService
{
    /**
     * @var PostcodeApiWrapper
     */
    private $postcodeApiWrapper;

    /**
     * @var CommonFunctions
     */
    private $commonFunctions;

    public function __construct(PostcodeApiWrapper $postcodeApiWrapper, CommonFunctions $commonFunctions)
    {
        $this->postcodeApiWrapper = $postcodeApiWrapper;
        $this->commonFunctions = $commonFunctions;
    }

    public function getStates()
    {
        $states = [];

        $statesResponse = $this->postcodeApiWrapper->getStates();

        if (array_key_exists('error', $statesResponse)) {
            return $states;
        }

        return $statesResponse;
    }

    public function getLocalGovernmentAreasByState($stateCode)
    {
        $localGovtAreas = [];

        $response = $this->postcodeApiWrapper->getLocalGovernmentAreas($stateCode);

        if (array_key_exists('error', $response)) {
            return $localGovtAreas;
        }

        return $response;
    }

    public function getFacilityPostcodes($stateCode, $localGovtArea)
    {
        $postcodes = [];

        $response = $this->postcodeApiWrapper->getFacilityPostcodes($stateCode, $localGovtArea);

        if (array_key_exists('error', $response)) {
            return $postcodes;
        }

        return $response;
    }

    public function getRuralPostcodes($stateCode, $localGovtArea)
    {
        $postcodes = [];

        $response = $this->postcodeApiWrapper->getRuralPostcodes($stateCode, $localGovtArea);

        if (array_key_exists('error', $response)) {
            return $postcodes;
        }

        return $response;
    }

    public function getUrbanPostcodes($stateCode, $town, $area)
    {
        $postcodes = [];

        $response = $this->postcodeApiWrapper->getUrbanPostcodes($stateCode, $town, $area);

        if (array_key_exists('error', $response)) {
            return $postcodes;
        }

        return $response;
    }

    public function fetchUrbanTowns($stateCode) {
        $urbanResponse = $this->postcodeApiWrapper->getUrbanPostcodes($stateCode);

        $result = [];
        $responseArray = [];

        if (array_key_exists('error', $urbanResponse)) {
            return $responseArray;
        }

        foreach ($urbanResponse as $data) {
            $town = $data['urbanTownName'];
            if (empty($result[$town])) {
                $result[$town] = 'hit';
                $response = [];
                $response['urbanTownName'] = $town;
                $response['stateCode'] = $data['stateCode'];
                $responseArray[] = $response;
            }
        }

        return $responseArray;
    }

    public function suggestUrbanPostcodes($stateCode, $town, $hint) {
        $urbanResponse = $this->postcodeApiWrapper->searchUrbanPostcodes($stateCode, $town, $hint);

        $responseArray = [];

        if (array_key_exists('error', $urbanResponse)) {
            return $responseArray;
        }

        foreach ($urbanResponse as $data) {
            if (empty($data['urbanStreetName'])
                    || $data['urbanStreetName'] == ' ') {
                continue;
            }
            $data['urbanStreetName'] = $this->cleanupStreetName($data['urbanStreetName']);
            $data['urbanAreaName'] = $this->cleanupAreaName($data['urbanAreaName']);
            $responseArray[] = $data;
        }

        return $responseArray;
    }

    public function reverseLookupPostcode($postcode) {
        $reverseLookupResponse = $this->postcodeApiWrapper->reverseLookup($postcode);

        if (array_key_exists('error', $reverseLookupResponse)) {
            if ($reverseLookupResponse['error'] == 'Not Found') {
                $reverseLookupResponse['error'] = 'No record of this Postcode was found!';
            }
        }

        return $reverseLookupResponse;
    }

    private function cleanupStreetName($street) {
        $street = trim($street);

        if ($this->commonFunctions->endsWith($street, ' ST.')) {
            $street = str_ireplace(' ST.', ' Street', $street);
        } else if ($this->commonFunctions->endsWith($street, ' Rd.')) {
            $street = str_ireplace(' Rd.', ' Road', $street);
        }

        return $street;
    }

    private function cleanupAreaName($area) {
        $area = trim($area);

        $area = $area . ' AREA';

        return $area;
    }

}
