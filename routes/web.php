<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/postcodeFinder', 'PostcodeFinderController@showPostcodeFinderPage')->name('postcodeFinder');
Route::get('/postcodeReverseLookup', 'PostcodeFinderController@showPostcodeReverseLookupPage')->name('postcodeReverseLookup');
Route::get('/api/states', 'PostcodeFinderController@fetchStates');
Route::get('/api/lgas', 'PostcodeFinderController@fetchLocalGovernmentAreas');
Route::get('/api/rural-postcodes', 'PostcodeFinderController@fetchRuralPostcodes');
Route::get('/api/facility-postcodes', 'PostcodeFinderController@fetchFacilityPostcodes');
Route::get('/api/fetch-urban-towns', 'PostcodeFinderController@fecthUrbanTowns');
Route::get('/api/suggest-urban-postcodes', 'PostcodeFinderController@suggestUrbanPostcodes');
Route::get('/api/reverse-lookup-postcode', 'PostcodeFinderController@reverseLookupPostcode');
