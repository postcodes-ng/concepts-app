<?php
namespace App\Http\Controllers;


class HomeController extends Controller
{
    /**
     * View home page.
     *
     */
    public function home() {
        return view('welcome');
    }

}
