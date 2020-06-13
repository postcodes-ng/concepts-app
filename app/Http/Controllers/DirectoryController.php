<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Services\DirectoryService;

class DirectoryController extends Controller {

    /**
     *
     * @var DirectoryService
     */
    private $directoryService;

    /**
     * Creates a new controller instance.
     *
     * @return void
     */
    public function __construct(DirectoryService $directoryService)
    {
        $this->directoryService = $directoryService;
        $this->middleware('web');
    }

    /**
     * Fetches all the states.
     *
     * @return array
     */
    public function fetchStates() {
        $states = $this->directoryService->getStates(null);

        if (empty($states)) {
            $breadcrumbItems = $this->directoryService->getNoResultBreadcrumbItems();
            $targetEntity = "States";
            $that = "this request.";
            return view('directory.noResults', ['targetEntity' => $targetEntity, 'that' => $that, 'breadcrumbItems' => $breadcrumbItems]);
        }
        return view('directory.states', ['states' => $states]);
    }

    /**
     * Fetches the local govts in a state.
     *
     * @param string $stateSlug
     * @return array
     */
    public function fetchLocalGovernmentAreas($stateSlug) {
        $localGovtAreas = $this->directoryService->getLocalGovernmentAreas($stateSlug);

        if (empty($localGovtAreas)) {
            $breadcrumbItems = $this->directoryService->getNoResultBreadcrumbItems();
            $targetEntity = "Local Government Areas";
            $that = $stateSlug . " State";
            return view('directory.noResults', ['targetEntity' => $targetEntity, 'that' => $that, 'breadcrumbItems' => $breadcrumbItems]);
        }
        $state = $localGovtAreas[0]->stateName;
        $breadcrumbItems = $this->directoryService->getStateBreadcrumbItems($state, $stateSlug);
        // store in session
        session([$stateSlug.'_breadcrumbItems' => $breadcrumbItems]);
        return view('directory.lgas', ['lgas' => $localGovtAreas, 'state' => $state, 'breadcrumbItems' => $breadcrumbItems]);
    }

    /**
     * Fetches the ruralAreas in a given LGA.
     *
     * @param string $stateSlug
     * @param string $lgaSlug
     * @return array
     */
    public function fetchRuralAreas($stateSlug, $lgaSlug) {
        $ruralAreas = $this->directoryService->getRuralAreas($stateSlug, $lgaSlug, null);

        if (empty($ruralAreas)) {
            $breadcrumbItems = $this->directoryService->getNoResultBreadcrumbItems(session($stateSlug . '_breadcrumbItems'));
            $targetEntity = "Rural Areas";
            $that = $lgaSlug . " Local Government Area";
            return view('directory.noResults', ['targetEntity' => $targetEntity, 'that' => $that, 'breadcrumbItems' => $breadcrumbItems]);
        }
        $lga = $ruralAreas[0]->lgaName;
        $breadcrumbItems = $this->directoryService->getLgaBreadcrumbItems($ruralAreas[0]->stateName, $stateSlug, $lga, $lgaSlug);
        // store in session
        session([$lgaSlug.'_breadcrumbItems' => $breadcrumbItems]);
        return view('directory.ruralAreas', ['ruralAreas' => $ruralAreas, 'lga' => $lga, 'breadcrumbItems' => $breadcrumbItems]);
    }

    /**
     * Fetch Rural Villages in a given Rural Area
     * @param string $stateSlug
     * @param string $lgaSlug
     * @param string $ruralAreaSlug
     * @return array
     */
    public function fetchVillages($stateSlug, $lgaSlug, $ruralAreaSlug) {
        $villages = $this->directoryService->getVillages($stateSlug, $lgaSlug, $ruralAreaSlug);

        if (empty($villages)) {
            $breadcrumbItems = $this->directoryService->getNoResultBreadcrumbItems(session($lgaSlug . '_breadcrumbItems'));
            $targetEntity = "Villages";
            $that = $ruralAreaSlug . " Rural Area";
            return view('directory.noResults', ['targetEntity' => $targetEntity, 'that' => $that, 'breadcrumbItems' => $breadcrumbItems]);
        }
        $ruralArea = $villages[0]->ruralAreaName;
        $breadcrumbItems = $this->directoryService->getRuralAreaBreadcrumbItems($villages[0]->stateName, $stateSlug, $villages[0]->lgaName, $lgaSlug, $ruralArea, $ruralAreaSlug);
        return view('directory.villages', ['villages' => $villages, 'ruralArea' => $ruralArea, 'breadcrumbItems' => $breadcrumbItems]);
    }

    /**
     * Fetch Urban Towns in a given State.
     *
     * @param string $stateSlug
     * @return array
     */
    public function fetchUrbanTowns($stateSlug) {
        $urbanTowns = $this->directoryService->getUrbanTowns($stateSlug, null);

        if (empty($urbanTowns)) {
            $breadcrumbItems = $this->directoryService->getNoResultBreadcrumbItems();
            $targetEntity = "Urban Towns";
            $that = $stateSlug . " State";
            return view('directory.noResults', ['targetEntity' => $targetEntity, 'that' => $that, 'breadcrumbItems' => $breadcrumbItems]);
        }
        $state = $urbanTowns[0]->stateName;
        $breadcrumbItems = $this->directoryService->getStateBreadcrumbItems($state, $stateSlug);
        // store in session
        session([$stateSlug.'_breadcrumbItems' => $breadcrumbItems]);
        return view('directory.urbanTowns', ['urbanTowns' => $urbanTowns, 'state' => $state, 'breadcrumbItems' => $breadcrumbItems]);
    }

    /**
     * Fecth Urban Areas in a given Urban Town.
     *
     * @param string $stateSlug
     * @param string $urbanTownSlug
     * @return array
     */
    public function fetchUrbanAreas($stateSlug, $urbanTownSlug) {
        $urbanAreas = $this->directoryService->getUrbanAreas($stateSlug, $urbanTownSlug, null);

        if (empty($urbanAreas)) {
            $breadcrumbItems = $this->directoryService->getNoResultBreadcrumbItems(session($stateSlug . '_breadcrumbItems'));
            $targetEntity = "Urban Areas";
            $that = $urbanTownSlug . " Urban Town";
            return view('directory.noResults', ['targetEntity' => $targetEntity, 'that' => $that, 'breadcrumbItems' => $breadcrumbItems]);
        }
        $urbanTown = $urbanAreas[0]->urbanTownName;
        $breadcrumbItems = $this->directoryService->getUrbanTownBreadcrumbItems($urbanAreas[0]->stateName, $stateSlug, $urbanTown, $urbanTownSlug);
        // store in session
        session([$urbanTownSlug.'_breadcrumbItems' => $breadcrumbItems]);
        return view('directory.urbanAreas', ['urbanAreas' => $urbanAreas, 'urbanTown' => $urbanTown, 'breadcrumbItems' => $breadcrumbItems]);
    }

    /**
     * Fecth Urban Streets in a given Urban Area.
     *
     * @param string $stateSlug
     * @param string $urbanTownSlug
     * @param string $urbanAreaSlug
     * @return array
     */
    public function fetchStreets($stateSlug, $urbanTownSlug, $urbanAreaSlug) {
        $streets = $this->directoryService->getStreets($stateSlug, $urbanTownSlug, $urbanAreaSlug);

        if (empty($streets)) {
            $breadcrumbItems = $this->directoryService->getNoResultBreadcrumbItems(session($urbanTownSlug . '_breadcrumbItems'));
            $targetEntity = "Streets";
            $that = $urbanAreaSlug . " Urban Area";
            return view('directory.noResults', ['targetEntity' => $targetEntity, 'that' => $that, 'breadcrumbItems' => $breadcrumbItems]);
        }
        $urbanArea = $streets[0]->urbanAreaName;
        $breadcrumbItems = $this->directoryService->getUrbanAreaBreadcrumbItems($streets[0]->stateName, $stateSlug, $streets[0]->urbanTownName, $urbanTownSlug, $urbanArea, $urbanAreaSlug);
        return view('directory.streets', ['streets' => $streets, 'urbanArea' => $urbanArea, 'breadcrumbItems' => $breadcrumbItems]);
    }

    /**
     * Fecth Facilities in a given LGA.
     *
     * @param string $stateSlug
     * @param string $lgaSlug
     * @return array
     */
    public function fetchFacilities($stateSlug, $lgaSlug) {
        $facilities = $this->directoryService->getFacilities($stateSlug, $lgaSlug);

        if (empty($facilities)) {
            $breadcrumbItems = $this->directoryService->getNoResultBreadcrumbItems(session($stateSlug . '_breadcrumbItems'));
            $targetEntity = "Facilities";
            $that = $lgaSlug . " Local Government Area";
            return view('directory.noResults', ['targetEntity' => $targetEntity, 'that' => $that, 'breadcrumbItems' => $breadcrumbItems]);
        }
        $lga = $facilities[0]->lgaName;
        $breadcrumbItems = $this->directoryService->getLgaBreadcrumbItems($facilities[0]->stateName, $stateSlug, $lga, $lgaSlug);
        return view('directory.facilities', ['facilities' => $facilities, 'lga' => $lga, 'breadcrumbItems' => $breadcrumbItems]);
    }

}
