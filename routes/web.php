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
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return redirect('/');
});

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/postcodeFinder', 'PostcodeFinderController@showPostcodeFinderPage')->name('postcodeFinder');
Route::get('/postcodeReverseLookup', 'PostcodeFinderController@showPostcodeReverseLookupPage')->name('postcodeReverseLookup');
Route::get('/api/lookup/states', 'PostcodeFinderController@fetchStates');
Route::get('/api/lookup/lgas', 'PostcodeFinderController@fetchLocalGovernmentAreas');

Route::get('/api/rural-postcodes', 'PostcodeFinderController@fetchRuralPostcodes');
Route::get('/api/facility-postcodes', 'PostcodeFinderController@fetchFacilityPostcodes');
Route::get('/api/fetch-urban-towns', 'PostcodeFinderController@fecthUrbanTowns');
Route::get('/api/suggest-urban-postcodes', 'PostcodeFinderController@suggestUrbanPostcodes');
Route::get('/api/reverse-lookup-postcode', 'PostcodeFinderController@reverseLookupPostcode');

Route::get('/api/lookup/facilities', 'PostcodeFinderController@fetchFacilities');
Route::get('/api/lookup/ruralAreas', 'PostcodeFinderController@fetchRuralAreas');
Route::get('/api/lookup/ruralVillages', 'PostcodeFinderController@fetchRuralVillages');
Route::get('/api/lookup/urbanTowns', 'PostcodeFinderController@fetchUrbanTowns');
Route::get('/api/lookup/urbanAreas', 'PostcodeFinderController@fetchUrbanAreas');
Route::get('/api/lookup/urbanStreets', 'PostcodeFinderController@fetchUrbanStreets');
