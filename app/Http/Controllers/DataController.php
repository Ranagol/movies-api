<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
/*
route '/open' is not protected by jwt, and it can be accessed without token
Route::get('open', 'DataController@open');

route '/close' is protected by jwt, can not be accessed without token
Route::get('closed', 'DataController@closed');
*/
class DataController extends Controller
{
    public function open() 
    {
        $data = "This data is open and can be accessed without the client being authenticated";
        return response()->json(compact('data'),200);

    }

    public function closed() 
    {
        $data = "Only authorized users can see this";
        return response()->json(compact('data'),200);
    }
}
