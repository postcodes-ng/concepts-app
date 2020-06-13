<?php
namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailBuilder;
use App\Services\MessageService;
use Illuminate\Support\Facades\Log;

class RedirectController extends Controller
{
    /**
     * Creates a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('web');
    }

    /**
     * Redirect the postcodeReverseLookup route.
     *
     */
    public function postcodeReverseLookup() {
        return redirect('/search/postcode');
    }

    /**
     * Redirect the postcodeFinder route.
     *
     */
    public function postcodeFinder() {
        return redirect('/lookup');
    }

    /**
     * Redirect the directory route.
     *
     */
    public function directory() {
        return redirect('/directory/states');
    }

}
