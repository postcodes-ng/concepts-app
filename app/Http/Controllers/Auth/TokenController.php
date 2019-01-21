<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Helpers\AjaxHelper;
use Illuminate\Support\Facades\Log;

class TokenController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('ajax');
    }

    /**
     * Fetches all the states.
     *
     * @return array
     */
    public function getToken() {
        $response = [];
        $token = AjaxHelper::generateAPIJWT();
        Log::info('TOKEN: ' . $token);

        $response['apiToken'] = strval($token);
        return $response;
    }
}
