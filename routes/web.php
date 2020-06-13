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
Route::get('/clear-cache', 'CacheController@clear');

Route::get('/', 'HomeController@homePage')->name('home');

Route::get('/postcodeFinder', 'RedirectController@postcodeFinder');
Route::get('/postcodeReverseLookup', 'RedirectController@postcodeReverseLookup');

Route::get('/about', 'AboutController@aboutPage')->name('about');

Route::get('/contact', 'ContactController@contactPage')->name('contact');
Route::post('/api/contact/send', 'MessageController@sendContactMessage');

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
Route::get('/api/search/byPostcode', 'SearchController@searchByPostcode');

Route::get('/map', 'MapController@w3wMap')->name('map');
Route::get('/api/map/w3wAddress', 'MapController@getWhat3WordsAddress');

Route::get('/directory', 'RedirectController@directory')->name('directory');
Route::get('/directory/states', 'DirectoryController@fetchStates')->name('statesDirectory');
Route::get('/directory/states/{stateSlug}/lgas', 'DirectoryController@fetchLocalGovernmentAreas')->name('lgasDirectory');
Route::get('/directory/states/{stateSlug}/lgas/{lgaSlug}/ruralAreas', 'DirectoryController@fetchRuralAreas')->name('ruralAreasDirectory');
Route::get('/directory/states/{stateSlug}/lgas/{lgaSlug}/ruralAreas/{ruralAreaSlug}/villages', 'DirectoryController@fetchVillages')->name('villagesDirectory');
Route::get('/directory/states/{stateSlug}/lgas/{lgaSlug}/facilities', 'DirectoryController@fetchFacilities')->name('facilitiesDirectory');
Route::get('/directory/states/{stateSlug}/urbanTowns', 'DirectoryController@fetchUrbanTowns')->name('urbanTownsDirectory');
Route::get('/directory/states/{stateSlug}/urbanTowns/{urbanTownSlug}/urbanAreas', 'DirectoryController@fetchUrbanAreas')->name('urbanAreasDirectory');
Route::get('/directory/states/{stateSlug}/urbanTowns/{urbanTownSlug}/urbanAreas/{urbanAreaSlug}/streets', 'DirectoryController@fetchStreets')->name('streetsDirectory');

Route::get('/api/token', 'Auth\TokenController@getToken');

