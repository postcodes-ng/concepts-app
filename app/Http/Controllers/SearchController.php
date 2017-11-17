<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Services\SearchService;

class SearchController extends Controller
{
    /**
     *
     * @var SearchService
     */
    private $searchService;

    /**
     * Creates a new controller instance.
     *
     * @return void
     */
    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
        $this->middleware('web');
        $this->middleware('ajax',
        [
                'only' => [
                        'searchByPostcode'
                ]
        ]);

    }

    /**
     * Show Postcode Search Page.
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function showPostcodeSearchPage()
    {
        return view('search.postcode_search_page');
    }

    /**
     * Search by postcode.
     *
     * @param Request $request
     * @return array
     */
    public function searchByPostcode(Request $request) {
        $postCode = $request->get('postCode');
        $response = $this->searchService->postcodeSearch($postCode);;
        return  $response;
    }

}