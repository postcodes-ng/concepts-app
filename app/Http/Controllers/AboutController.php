<?php
namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailBuilder;
use App\Services\MessageService;
use Illuminate\Support\Facades\Log;

class AboutController extends Controller
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
     * View About Us Page.
     *
     */
    public function aboutPage() {
        return view('about.about');
    }

}
