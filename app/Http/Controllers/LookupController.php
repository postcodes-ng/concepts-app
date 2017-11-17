<?php
namespace App\Http\Controllers;

use App\Services\PostcodeFinderService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Services\LookupService;

class LookupController extends Controller
{
    /**
     *
     * @var PostcodeFinderService
     */
    private $postcodeFinderService;

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
    public function __construct(PostcodeFinderService $postcodeFinderService, LookupService $lookupService)
    {
        $this->postcodeFinderService = $postcodeFinderService;
        $this->lookupService = $lookupService;
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
                                'fetchFacilities',
                                'fetchRuralPostcodes',
                                'fecthUrbanTowns',
                                'suggestUrbanPostcodes',
                                'fetchFacilityPostcodes',
                                'reverseLookupPostcode'
                        ]
                ]);
    }

    /**
     * Show Postcode Finder Page.
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function showPostcodeFinderPage()
    {
        return view('lookup.finder_page');
    }

    /**
     * Fetches all the states.
     *
     * @return array
     */
    public function fetchStates() {
        $states = $this->lookupService->getStates();
        return $states;
    }

    /**
     * Fetches the local govts in a state.
     *
     * @param Request $request
     * @return array
     */
    public function fetchLocalGovernmentAreas(Request $request) {
        $stateCode = $request->get('stateCode');
        $localGovtAreas = $this->lookupService->getLocalGovernmentAreasByState($stateCode);
        return $localGovtAreas;
    }

    /**
     * Fetches the ruralAreas in a given LGA.
     *
     * @param Request $request
     * @return array
     */
    public function fetchRuralAreas(Request $request) {
        $lgaId = $request->get('lgaId');
        $ruralAreaId = $request->get('ruralAreaId');
        $ruralAreas = $this->lookupService->getRuralAreas($lgaId, $ruralAreaId);
        return  $ruralAreas;
    }

    /**
     * Fetch Rural Villages in a given Rural Area
     * @param Request $request
     * @return array
     */
    public function fetchRuralVillages(Request $request) {
        $ruralAreaId = $request->get('ruralAreaId');
        $ruralVillageId = $request->get('ruralVillageId');
        $ruralVillages = $this->lookupService->getRuralVillages($ruralAreaId, $ruralVillageId);
        return  $ruralVillages;
    }

    /**
     * Fetch Urban Towns in a given State.
     *
     * @param Request $request
     * @return array
     */
    public function fetchUrbanTowns(Request $request) {
        $stateCode = $request->get('stateCode');
        $urbanTownId = $request->get('urbanTownId');
        $urbanTowns = $this->lookupService->getUrbanTowns($stateCode, $urbanTownId);
        return  $urbanTowns;
    }

    /**
     * Fecth Urban Areas in a given Urban Town.
     *
     * @param Request $request
     * @return array
     */
    public function fetchUrbanAreas(Request $request) {
        $urbanTownId = $request->get('urbanTownId');
        $urbanAreaId = $request->get('urbanAreaId');
        $urbanAreas = $this->lookupService->getUrbanAreas($urbanTownId, $urbanAreaId);
        return  $urbanAreas;
    }

    /**
     * Fecth Urban Streets in a given Urban Area.
     *
     * @param Request $request
     * @return array
     */
    public function fetchUrbanStreets(Request $request) {
        $urbanAreaId = $request->get('urbanAreaId');
        $urbanStreetId = $request->get('urbanStreetId');
        $urbanStreets = $this->lookupService->getUrbanStreets($urbanAreaId, $urbanStreetId);
        return  $urbanStreets;
    }

    /**
     * Fecth Facilities in a given LGA.
     *
     * @param Request $request
     * @return array
     */
    public function fetchFacilities(Request $request) {
        $lgaId = $request->get('lgaId');
        $facilityId = $request->get('facilityId');
        $facilities = $this->lookupService->getFacilities($lgaId, $facilityId);
        return  $facilities;
    }

    /**
     * Fetches the rural postcodes.
     *
     * @param Request $request
     * @return array
     */
    public function fetchRuralPostcodes(Request $request) {
        $stateCode = $request->get('stateCode');
        $localGovtArea = $request->get('lga');
        $ruralPostcodes = $this->postcodeFinderService->getRuralPostcodes($stateCode, $localGovtArea);
        return  $ruralPostcodes;
    }

    /**
     * Fetches Urban Towns in a given State.
     *
     * @param Request $request
     * @return array
     */
    public function fecthUrbanTowns(Request $request) {
        $stateCode = $request->get('stateCode');

        $urbanTowns = $this->postcodeFinderService->fetchUrbanTowns($stateCode);
        return $urbanTowns;
    }

    /**
     * Provides suggestions rural postcode based on hint provided.
     *
     * @param Request $request
     * @return array
     */
    public function suggestUrbanPostcodes(Request $request) {
        $stateCode = $request->get('stateCode');
        $town = $request->get('town');
        $hint = $request->get('hint');

        $urbanPostcodes = $this->postcodeFinderService->suggestUrbanPostcodes($stateCode, $town, $hint);

        return $urbanPostcodes;
    }

    /**
     * Fetches the facility postcodes.
     *
     * @param Request $request
     * @return array
     */
    public function fetchFacilityPostcodes(Request $request) {
        $stateCode = $request->get('stateCode');
        $localGovtArea = $request->get('lga');
        $facilityPostcodes = $this->postcodeFinderService->getFacilityPostcodes($stateCode, $localGovtArea);
        return  $facilityPostcodes;
    }

    /**
     * Reverse lookup postcode.
     *
     * @param Request $request
     * @return array
     */
    public function reverseLookupPostcode(Request $request) {
        $postCode = $request->get('postCode');
        $response = $this->postcodeFinderService->reverseLookupPostcode($postCode);
        return  $response;
    }
}
