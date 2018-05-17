<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// List Categories
Route::get('categories', 'CategoryController@index');

// List single Category
Route::get('category/{id}', 'CategoryController@show');

Route::post('autocomplete', 'CategoryController@autocomplete');

// Create new Category
Route::post('category', 'CategoryController@store');

// Update Category
Route::put('category', 'CategoryController@store');

// Delete Category
Route::delete('category/{id}', 'CategoryController@destroy');
