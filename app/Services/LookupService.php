<?php
namespace App\Services;

use App\Utilities\PostcodeApiWrapper;
use App\Utilities\W3WApiWrapper;

class LookupService
{
    /**
     * @var PostcodeApiWrapper
     */
    private $postcodeApiWrapper;

    /**
     * @var W3WApiWrapper
     */
    private $w3wApiWrapper;

    public function __construct(PostcodeApiWrapper $postcodeApiWrapper, W3WApiWrapper $w3wApiWrapper)
    {
        $this->postcodeApiWrapper = $postcodeApiWrapper;

        $this->w3wApiWrapper = $w3wApiWrapper;
    }

    public function getStates()
    {
        $emptyResponse = [];

        $statesResponse = $this->postcodeApiWrapper->getStates();

        if (array_key_exists('error', $statesResponse)) {
            return $emptyResponse;
        }

        return $statesResponse;
    }

    public function getLocalGovernmentAreasByState($stateCode)
    {
        $emptyResponse = [];

        $response = $this->postcodeApiWrapper->getLocalGovernmentAreas($stateCode);

        if (array_key_exists('error', $response)) {
            return $emptyResponse;
        }

        return $response;
    }

    public function getFacilities($lgaId, $facilityId)
    {
        $emptyResponse = [];

        $response = $this->postcodeApiWrapper->getFacilities($lgaId, $facilityId);

        if (array_key_exists('error', $response)) {
            return $emptyResponse;
        }

        return $response;
    }

    public function getRuralAreas($lgaId, $ruralAreaId)
    {
        $emptyResponse = [];

        $response = $this->postcodeApiWrapper->getRuralAreas($lgaId, $ruralAreaId);

        if (array_key_exists('error', $response)) {
            return $emptyResponse;
        }

        return $response;
    }

    public function getRuralVillages($ruralAreaId, $ruralVillageId)
    {
        $emptyResponse = [];

        $response = $this->postcodeApiWrapper->getRuralVillages($ruralAreaId, $ruralVillageId);

        if (array_key_exists('error', $response)) {
            return $emptyResponse;
        }

        return $response;
    }

    public function getUrbanTowns($stateCode, $urbanTownId)
    {
        $emptyResponse = [];

        $response = $this->postcodeApiWrapper->getUrbanTowns($stateCode, $urbanTownId);

        if (array_key_exists('error', $response)) {
            return $emptyResponse;
        }

        return $response;
    }

    public function getUrbanAreas($urbanTownId, $urbanAreaId)
    {
        $emptyResponse = [];

        $response = $this->postcodeApiWrapper->getUrbanAreas($urbanTownId, $urbanAreaId);

        if (array_key_exists('error', $response)) {
            return $emptyResponse;
        }

        return $response;
    }

    public function getUrbanStreets($urbanAreaId, $urbanStreetId)
    {
        $emptyResponse = [];

        $response = $this->postcodeApiWrapper->getUrbanStreets($urbanAreaId, $urbanStreetId);

        if (array_key_exists('error', $response)) {
            return $emptyResponse;
        }

        return $response;
    }

    public function getWhat3WordsAddress($lat, $lng)
    {
        $emptyResponse = [];
        
        $response = $this->w3wApiWrapper->reverseGeocode($lat, $lng);

        if (array_key_exists('error', $response)) {
            return $emptyResponse;
        }

        return ['w3wAddress' => $response['words'] ];
    }

}
