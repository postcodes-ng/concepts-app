<?php
namespace App\Http\Controllers;


class AboutController extends Controller
{
    /**
     * View about page.
     *
     */
    public function about() {
        return view('about.about');
    }

}
