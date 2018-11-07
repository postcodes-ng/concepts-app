<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Services\LookupService;
use App\Services\DirectoryService;

class LookupController extends Controller
{
    /**
     *
     * @var LookupService
     */
    private $lookupService;

    /**
     * Creates a new controller instance.
     *
     * @return void
     */
    public function __construct(LookupService $lookupService, DirectoryService $directoryService)
    {
        $this->lookupService = $lookupService;
        $this->directoryService = $directoryService;
        $this->middleware('web');
        $this->middleware('ajax',
                [
                        'only' => [
                                'fetchStates',
                                'fetchLocalGovernmentAreas',
                                'fetchRuralAreas',
                                'fetchRuralVillages',
                                'fetchUrbanTowns',
                                'fetchUrbanAreas',
                                'fetchUrbanStreets',
                                'fetchFacilities'
                        ]
                ]);
    }

    /**
     * Show Postcode Lookup Page.
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function showPostcodeLookupPage()
    {
        return view('lookup.finder_page');
    }

    /**
     * Fetches all the states.
     *
     * @return array
     */
    public function fetchStates() {
        $states = $this->directoryService->getStates();
        return $states;
    }

    /**
     * Fetches the local govts in a state.
     *
     * @param Request $request
     * @return array
     */
    public function fetchLocalGovernmentAreas(Request $request) {
        $stateSlug = $request->get('stateSlug');
        $localGovtAreas = $this->directoryService->getLocalGovernmentAreas($stateSlug);
        return $localGovtAreas;
    }

    /**
     * Fetches the ruralAreas in a given LGA.
     *
     * @param Request $request
     * @return array
     */
    public function fetchRuralAreas(Request $request) {
        $stateSlug = $request->get('stateSlug');
        $lgaSlug = $request->get('lgaSlug');
        $ruralAreaSlug = $request->get('ruralAreaSlug');
        $ruralAreas = $this->directoryService->getRuralAreas($stateSlug, $lgaSlug, $ruralAreaSlug);
        return  $ruralAreas;
    }

    /**
     * Fetch Rural Villages in a given Rural Area
     * @param Request $request
     * @return array
     */
    public function fetchRuralVillages(Request $request) {
        $stateSlug = $request->get('stateSlug');
        $lgaSlug = $request->get('lgaSlug');
        $ruralAreaSlug = $request->get('ruralAreaSlug');
        //$ruralVillageId = $request->get('ruralVillageId');
        $ruralVillages = $this->directoryService->getVillages($stateSlug, $lgaSlug, $ruralAreaSlug);
        return  $ruralVillages;
    }

    /**
     * Fetch Urban Towns in a given State.
     *
     * @param Request $request
     * @return array
     */
    public function fetchUrbanTowns(Request $request) {
        $stateSlug = $request->get('stateSlug');
        $urbanTownSlug = $request->get('urbanTownSlug');
        $urbanTowns = $this->directoryService->getUrbanTowns($stateSlug, $urbanTownSlug);
        return  $urbanTowns;
    }

    /**
     * Fecth Urban Areas in a given Urban Town.
     *
     * @param Request $request
     * @return array
     */
    public function fetchUrbanAreas(Request $request) {
        $stateSlug = $request->get('stateSlug');
        $urbanTownSlug = $request->get('urbanTownSlug');
        $urbanAreaSlug = $request->get('urbanAreaSlug');
        $urbanAreas = $this->directoryService->getUrbanAreas($stateSlug, $urbanTownSlug, $urbanAreaSlug);
        return  $urbanAreas;
    }

    /**
     * Fecth Urban Streets in a given Urban Area.
     *
     * @param Request $request
     * @return array
     */
    public function fetchUrbanStreets(Request $request) {
        $stateSlug = $request->get('stateSlug');
        $urbanTownSlug = $request->get('urbanTownSlug');
        $urbanAreaSlug = $request->get('urbanAreaSlug');
        //$urbanStreetId = $request->get('urbanStreetId');
        $urbanStreets = $this->directoryService->getStreets($stateSlug, $urbanTownSlug, $urbanAreaSlug);
        return  $urbanStreets;
    }

    /**
     * Fecth Facilities in a given LGA.
     *
     * @param Request $request
     * @return array
     */
    public function fetchFacilities(Request $request) {
        $stateSlug = $request->get('stateSlug');
        $lgaSlug = $request->get('lgaSlug');
        //$facilityId = $request->get('facilityId');
        $facilities = $this->directoryService->getFacilities($stateSlug, $lgaSlug);
        return  $facilities;
    }
}
