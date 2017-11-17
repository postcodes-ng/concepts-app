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

Route::get('/postcodeFinder', function() {
    return redirect('/lookup');
});
Route::get('/postcodeReverseLookup', function() {
    return redirect('/search/postcode');
});
Route::get('/lookup', 'LookupController@showPostcodeFinderPage')->name('lookup');
Route::get('/api/lookup/states', 'LookupController@fetchStates');
Route::get('/api/lookup/lgas', 'LookupController@fetchLocalGovernmentAreas');

Route::get('/api/rural-postcodes', 'LookupController@fetchRuralPostcodes');
Route::get('/api/facility-postcodes', 'LookupController@fetchFacilityPostcodes');
Route::get('/api/fetch-urban-towns', 'LookupController@fecthUrbanTowns');
Route::get('/api/suggest-urban-postcodes', 'LookupController@suggestUrbanPostcodes');
Route::get('/api/reverse-lookup-postcode', 'LookupController@reverseLookupPostcode');

Route::get('/api/lookup/facilities', 'LookupController@fetchFacilities');
Route::get('/api/lookup/ruralAreas', 'LookupController@fetchRuralAreas');
Route::get('/api/lookup/ruralVillages', 'LookupController@fetchRuralVillages');
Route::get('/api/lookup/urbanTowns', 'LookupController@fetchUrbanTowns');
Route::get('/api/lookup/urbanAreas', 'LookupController@fetchUrbanAreas');
Route::get('/api/lookup/urbanStreets', 'LookupController@fetchUrbanStreets');

Route::get('/search/postcode', 'SearchController@showPostcodeSearchPage')->name('postcodeSearch');
Route::get('/api/search/byPostcode', 'SearchController@searchPostcode');


