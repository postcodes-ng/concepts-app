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
Route::get('/lookup', 'LookupController@showPostcodeLookupPage')->name('lookup');
Route::get('/api/lookup/states', 'LookupController@fetchStates');
Route::get('/api/lookup/lgas', 'LookupController@fetchLocalGovernmentAreas');

Route::get('/api/lookup/facilities', 'LookupController@fetchFacilities');
Route::get('/api/lookup/ruralAreas', 'LookupController@fetchRuralAreas');
Route::get('/api/lookup/ruralVillages', 'LookupController@fetchRuralVillages');
Route::get('/api/lookup/urbanTowns', 'LookupController@fetchUrbanTowns');
Route::get('/api/lookup/urbanAreas', 'LookupController@fetchUrbanAreas');
Route::get('/api/lookup/urbanStreets', 'LookupController@fetchUrbanStreets');

Route::get('/search/postcode', 'SearchController@showPostcodeSearchPage')->name('postcodeSearch');
Route::get('/api/search/byPostcode', 'SearchController@searchPostcode');


