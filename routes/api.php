<?php

use Illuminate\Http\Request;
use App\Model\Food;

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
Route::get('/findSomeFood/{food}', function($food){
    return Food::where('food', 'like', "%$food%")->with('addresses')->with('images')->get();
});
