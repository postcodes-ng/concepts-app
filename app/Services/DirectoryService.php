<?php
namespace App\Services;

use App\Utilities\PostcodeApiWrapper;
use App\Mappers\FacilityMapper;
use App\Mappers\LGAMapper;
use App\Mappers\RuralAreaMapper;
use App\Mappers\StreetMapper;
use App\Mappers\StateMapper;
use App\Mappers\UrbanAreaMapper;
use App\Mappers\UrbanTownMapper;
use App\Mappers\VillageMapper;
use App\Models\BreadcrumbItem;

class DirectoryService
{
    /**
     * @var PostcodeApiWrapper
     */
    private $postcodeApiWrapper;

    /**
     * @var FacilityMapper
     */
    private $facilityMapper;

    /**
     * @var LGAMapper
     */
    private $lgaMapper;

    /**
     * @var RuralAreaMapper
     */
    private $ruralAreaMapper;

    /**
     * @var StreetMapper
     */
    private $streetMapper;

    /**
     * @var StateMapper
     */
    private $stateMapper;

    /**
     * @var UrbanAreaMapper
     */
    private $urbanAreaMapper;

    /**
     * @var UrbanTownMapper
     */
    private $urbanTownMapper;

    /**
     * @var VillageMapper
     */
    private $villageMapper;

    public function __construct(
        PostcodeApiWrapper $postcodeApiWrapper,
        FacilityMapper $facilityMapper,
        LGAMapper $lgaMapper,
        RuralAreaMapper $ruralAreaMapper,
        StateMapper $stateMapper,
        StreetMapper $streetMapper,
        UrbanAreaMapper $urbanAreaMapper,
        UrbanTownMapper $urbanTownMapper,
        VillageMapper $villageMapper)
    {
        $this->postcodeApiWrapper = $postcodeApiWrapper;
        $this->facilityMapper = $facilityMapper;
        $this->lgaMapper = $lgaMapper;
        $this->ruralAreaMapper = $ruralAreaMapper;
        $this->stateMapper = $stateMapper;
        $this->streetMapper = $streetMapper;
        $this->urbanAreaMapper = $urbanAreaMapper;
        $this->urbanTownMapper = $urbanTownMapper;
        $this->villageMapper = $villageMapper;
    }

    public function getStates($stateSlug = null)
    {
        $emptyResponse = [];

        $statesResponse = $this->postcodeApiWrapper->getStatesDirectory($stateSlug);

        if (array_key_exists('error', $statesResponse)) {
            return $emptyResponse;
        }

        return $this->stateMapper->map($statesResponse);
    }

    public function getLocalGovernmentAreas($stateSlug, $lgaSlug = null)
    {
        $emptyResponse = [];

        $response = $this->postcodeApiWrapper->getLocalGovernmentAreasDirectory($stateSlug, $lgaSlug);

        if (array_key_exists('error', $response)) {
            return $emptyResponse;
        }

        return $this->lgaMapper->map($response);
    }

    public function getFacilities($stateSlug, $lgaSlug)
    {
        $emptyResponse = [];

        $response = $this->postcodeApiWrapper->getFacilitiesDirectory($stateSlug, $lgaSlug);

        if (array_key_exists('error', $response)) {
            return $emptyResponse;
        }

        return $this->facilityMapper->map($response);
    }

    public function getRuralAreas($stateSlug, $lgaSlug, $ruralAreaSlug = null)
    {
        $emptyResponse = [];

        $response = $this->postcodeApiWrapper->getRuralAreasDirectory($stateSlug, $lgaSlug, $ruralAreaSlug);

        if (array_key_exists('error', $response)) {
            return $emptyResponse;
        }

        return $this->ruralAreaMapper->map($response);
    }

    public function getVillages($stateSlug, $lgaSlug, $ruralAreaSlug)
    {
        $emptyResponse = [];

        $response = $this->postcodeApiWrapper->getVillagesDirectory($stateSlug, $lgaSlug, $ruralAreaSlug);

        if (array_key_exists('error', $response)) {
            return $emptyResponse;
        }

        return $this->villageMapper->map($response);
    }

    public function getUrbanTowns($stateSlug, $urbanTownSlug = null)
    {
        $emptyResponse = [];

        $response = $this->postcodeApiWrapper->getUrbanTownsDirectory($stateSlug, $urbanTownSlug);

        if (array_key_exists('error', $response)) {
            return $emptyResponse;
        }

        return $this->urbanTownMapper->map($response);
    }

    public function getUrbanAreas($stateSlug, $urbanTownSlug, $urbanAreaSlug = null)
    {
        $emptyResponse = [];

        $response = $this->postcodeApiWrapper->getUrbanAreasDirectory($stateSlug, $urbanTownSlug, $urbanAreaSlug);

        if (array_key_exists('error', $response)) {
            return $emptyResponse;
        }

        return $this->urbanAreaMapper->map($response);
    }

    public function getStreets($stateSlug, $urbanTownSlug, $urbanAreaSlug)
    {
        $emptyResponse = [];

        $response = $this->postcodeApiWrapper->getStreetsDirectory($stateSlug, $urbanTownSlug, $urbanAreaSlug);

        if (array_key_exists('error', $response)) {
            return $emptyResponse;
        }

        return $this->streetMapper->map($response);
    }

    public function getStateBreadcrumbItems($stateName, $stateSlug) {
        $breadcrumbItems = [];

        $firstItem = new BreadcrumbItem();
        $firstItem->displayName = 'Directory';
        $firstItem->link = route('statesDirectory');

        $secondItem = new BreadcrumbItem();
        $secondItem->displayName = $stateName;
        $secondItem->link = route('lgasDirectory', ['stateSlug' => $stateSlug]);

        $breadcrumbItems[0] = $firstItem;
        $breadcrumbItems[1] = $secondItem;

        return $breadcrumbItems;
    }

    public function getLgaBreadcrumbItems($stateName, $stateSlug, $lgaName, $lgaSlug) {
        $breadcrumbItems = [];

        $firstItem = new BreadcrumbItem();
        $firstItem->displayName = 'Directory';
        $firstItem->link = route('statesDirectory');

        $secondItem = new BreadcrumbItem();
        $secondItem->displayName = $stateName;
        $secondItem->link = route('lgasDirectory', ['stateSlug' => $stateSlug]);

        $thirdItem = new BreadcrumbItem();
        $thirdItem->displayName = $lgaName;
        $thirdItem->link = route('ruralAreasDirectory', ['stateSlug' => $stateSlug, 'lgaSlug' => $lgaSlug]);

        $breadcrumbItems[0] = $firstItem;
        $breadcrumbItems[1] = $secondItem;
        $breadcrumbItems[2] = $thirdItem;

        return $breadcrumbItems;
    }

    public function getRuralAreaBreadcrumbItems($stateName, $stateSlug, $lgaName, $lgaSlug, $ruralAreaName, $ruralAreaSlug) {
        $breadcrumbItems = [];

        $firstItem = new BreadcrumbItem();
        $firstItem->displayName = 'Directory';
        $firstItem->link = route('statesDirectory');

        $secondItem = new BreadcrumbItem();
        $secondItem->displayName = $stateName;
        $secondItem->link = route('lgasDirectory', ['stateSlug' => $stateSlug]);

        $thirdItem = new BreadcrumbItem();
        $thirdItem->displayName = $lgaName;
        $thirdItem->link = route('ruralAreasDirectory', ['stateSlug' => $stateSlug, 'lgaSlug' => $lgaSlug]);

        $fourthItem = new BreadcrumbItem();
        $fourthItem->displayName = $ruralAreaName;
        $fourthItem->link = route('villagesDirectory', ['stateSlug' => $stateSlug, 'lgaSlug' => $lgaSlug, 'ruralAreaSlug' => $ruralAreaSlug]);

        $breadcrumbItems[0] = $firstItem;
        $breadcrumbItems[1] = $secondItem;
        $breadcrumbItems[2] = $thirdItem;
        $breadcrumbItems[3] = $fourthItem;

        return $breadcrumbItems;
    }

    public function getUrbanTownBreadcrumbItems($stateName, $stateSlug, $urbanTownName, $urbanTownSlug) {
        $breadcrumbItems = [];

        $firstItem = new BreadcrumbItem();
        $firstItem->displayName = 'Directory';
        $firstItem->link = route('statesDirectory');

        $secondItem = new BreadcrumbItem();
        $secondItem->displayName = $stateName;
        $secondItem->link = route('urbanTownsDirectory', ['stateSlug' => $stateSlug]);

        $thirdItem = new BreadcrumbItem();
        $thirdItem->displayName = $urbanTownName;
        $thirdItem->link = route('urbanAreasDirectory', ['stateSlug' => $stateSlug, 'urbanTownSlug' => $urbanTownSlug]);

        $breadcrumbItems[0] = $firstItem;
        $breadcrumbItems[1] = $secondItem;
        $breadcrumbItems[2] = $thirdItem;

        return $breadcrumbItems;
    }

    public function getUrbanAreaBreadcrumbItems($stateName, $stateSlug, $urbanTownName, $urbanTownSlug, $urbanAreaName, $urbanAreaSlug) {
        $breadcrumbItems = [];

        $firstItem = new BreadcrumbItem();
        $firstItem->displayName = 'Directory';
        $firstItem->link = route('statesDirectory');
        $firstItem->type = 'root';

        $secondItem = new BreadcrumbItem();
        $secondItem->displayName = $stateName;
        $secondItem->link = route('urbanTownsDirectory', ['stateSlug' => $stateSlug]);

        $thirdItem = new BreadcrumbItem();
        $thirdItem->displayName = $urbanTownName;
        $thirdItem->link = route('urbanAreasDirectory', ['stateSlug' => $stateSlug, 'urbanTownSlug' => $urbanTownSlug]);

        $fourthItem = new BreadcrumbItem();
        $fourthItem->displayName = $urbanAreaName;
        $fourthItem->link = route('streetsDirectory', ['stateSlug' => $stateSlug, 'urbanTownSlug' => $urbanTownSlug, 'urbanAreaSlug' => $urbanAreaSlug]);

        $breadcrumbItems[0] = $firstItem;
        $breadcrumbItems[1] = $secondItem;
        $breadcrumbItems[2] = $thirdItem;
        $breadcrumbItems[3] = $fourthItem;

        return $breadcrumbItems;
    }

    public function getNoResultBreadcrumbItems($cachedBreadcrumbItems = null) {

        if (empty($cachedBreadcrumbItems)) {
            $cachedBreadcrumbItems = [];

            $firstItem = new BreadcrumbItem();
            $firstItem->displayName = 'Directory';
            $firstItem->link = route('statesDirectory');

            $cachedBreadcrumbItems[0] = $firstItem;
        }
        
        $nextItem = new BreadcrumbItem();
        $nextItem->displayName = "No Result";
        $nextItem->link = null;
        $nextItem->type = 'noResult';

        $cachedBreadcrumbItems[] = $nextItem;

        return $cachedBreadcrumbItems;
    }

}
