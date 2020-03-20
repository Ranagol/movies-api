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

Route::resource('movies','MovieController');

/*
D:\API\movies-api>php artisan route:list
+--------+-----------+-------------------------+----------------+----------------------------------------------+--------------+
| Domain | Method    | URI                     | Name           | Action                                       | Middleware   |
+--------+-----------+-------------------------+----------------+----------------------------------------------+--------------+
|        | GET|HEAD  | /                       |                | Closure                                      | web          |
|        | GET|HEAD  | api/movies              | movies.index   | App\Http\Controllers\MovieController@index   | api          |
|        | POST      | api/movies              | movies.store   | App\Http\Controllers\MovieController@store   | api          |
|        | GET|HEAD  | api/movies/create       | movies.create  | App\Http\Controllers\MovieController@create  | api          |
|        | GET|HEAD  | api/movies/{movie}      | movies.show    | App\Http\Controllers\MovieController@show    | api          |
|        | PUT|PATCH | api/movies/{movie}      | movies.update  | App\Http\Controllers\MovieController@update  | api          |
|        | DELETE    | api/movies/{movie}      | movies.destroy | App\Http\Controllers\MovieController@destroy | api          |
|        | GET|HEAD  | api/movies/{movie}/edit | movies.edit    | App\Http\Controllers\MovieController@edit    | api          |
|        | GET|HEAD  | api/user                |                | Closure                                      | api,auth:api |
+--------+-----------+-------------------------+----------------+----------------------------------------------+--------------+
*/
