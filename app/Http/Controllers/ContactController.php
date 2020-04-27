<?php
namespace App\Http\Controllers;


class ContactController extends Controller
{
    /**
     * View contact page.
     *
     */
    public function contact() {
        return view('contact.contact');
    }

}
