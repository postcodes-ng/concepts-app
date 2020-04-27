<?php
namespace App\Http\Controllers;


class RedirectController extends Controller
{
    /**
     * Clear cache and redirect to home page.
     *
     */
    public function clearCacheAndRedirect() {
        $exitCode = Artisan::call('cache:clear');
        return redirect('/');
    }
    
    /**
     * Redirect /postcodeFinder url to /lookup.
     *
     */
    public function postcodeFinder() {
        return redirect('/lookup');
    }

    /**
     * Redirect /postcodeReverseLookup url to /lookup.
     *
     */
    public function postcodeReverseLookup() {
        return redirect('/search/postcode');
    }

}
