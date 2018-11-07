<?php
namespace App\Services;

use App\Utilities\PostcodeApiWrapper;
use App\Utilities\W3WApiWrapper;
use App\Mappers\FacilityMapper;
use App\Mappers\LGAMapper;
use App\Mappers\RuralAreaMapper;
use App\Mappers\StreetMapper;
use App\Mappers\StateMapper;
use App\Mappers\UrbanAreaMapper;
use App\Mappers\UrbanTownMapper;
use App\Mappers\VillageMapper;

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

    public function __construct(
        PostcodeApiWrapper $postcodeApiWrapper,
        W3WApiWrapper $w3wApiWrapper)
    {
        $this->postcodeApiWrapper = $postcodeApiWrapper;

        $this->w3wApiWrapper = $w3wApiWrapper;
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
