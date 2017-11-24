<?php
namespace App\Http\Controllers;

use App\Services\LookupService;
use Illuminate\Http\Request;

class MapController extends Controller
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
    public function __construct(LookupService $lookupService)
    {
        $this->lookupService = $lookupService;
        $this->middleware('web');
        $this->middleware('ajax',
                [
                        'only' => [
                                'getWhat3WordsAddress'
                        ]
                ]);
    }
    
    public function w3wMap()
    {
        return view('map.npc_map');
    }

    public function getWhat3WordsAddress(Request $request)
    {
        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');
        $w3wAddress = $this->lookupService->getWhat3WordsAddress($latitude, $longitude);
        return $w3wAddress;
    }
}