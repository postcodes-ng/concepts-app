<?php
namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailBuilder;
use App\Services\MessageService;
use Illuminate\Support\Facades\Log;

class CacheController extends Controller
{
    /**
     * Creates a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    /**
     * Clear Cache.
     *
     */
    public function clear() {
        $exitCode = Artisan::call('cache:clear');
        return redirect('/');
    }

}
