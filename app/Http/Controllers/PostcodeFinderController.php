<?php
namespace App\Http\Controllers;

use App\Services\PostcodeFinderService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Log;

class PostcodeFinderController extends Controller
{
    /**
     *
     * @var PostcodeFinderService
     */
    private $postcodeFinderService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PostcodeFinderService $postcodeFinderService)
    {
        $this->postcodeFinderService = $postcodeFinderService;
        $this->middleware('web');
        $this->middleware('ajax',
                [
                        'only' => [
                                'fetchStates',
                                'fetchLocalGovernmentAreas',
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
        return view('postcodeFinder.finder_page');
    }

    /**
     * Show Postcode Finder Page.
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function showPostcodeReverseLookupPage()
    {
        return view('postcodeReverseLookup.reverse_lookup_page');
    }

    /**
     * Fetches all the states.
     *
     * @return array
     */
    public function fetchStates() {
        $states = $this->postcodeFinderService->getStates();
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
        $localGovtAreas = $this->postcodeFinderService->getLocalGovernmentAreasByState($stateCode);
        return $localGovtAreas;
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
