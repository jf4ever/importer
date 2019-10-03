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

/** Авкокомплит для живого поиска */
Route::get('s_autocomplete', 'SearchController@sAutocomplete')->name('s_autocomplete');

/** роуты товарной группы */
Route::get('/', 'ItemsController@items')->name('items');
Route::get('/items/{id}', 'ItemsController@item')->name('item');

/** роуты группы импорта */
Route::get('/imports', 'ImportController@index')->name('importIndex');
Route::post('/importstart', 'ImportController@importStart')->name('importStart');
