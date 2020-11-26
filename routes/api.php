<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Get all roles
Route::get('/role_list', 'RoleController@role_list');

//Get role details
Route::get('/role_list/{id}', 'RoleController@show');

//Create role
Route::post('/role_store', 'RoleController@store');

//Update role
Route::put('/role_store', 'RoleController@store');

//Delete role
Route::delete('/role_delete/{id}', 'RoleController@destroy');

//Get all users
Route::get('/user_list', 'UserController@user_list');