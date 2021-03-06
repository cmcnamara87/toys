<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'ClustersController@index');
Route::resource('clusters', 'ClustersController');

Route::get('bargain-bin', function () {
    // items ending in 1hr < $20
    $items = \App\Item::where('end_time', '<=', \Carbon\Carbon::now()->addHours(1))
        ->where('end_time', '>', \Carbon\Carbon::now())
        ->where('currency_value', '<', 20)
        ->orderBy('end_time', 'asc')
        ->get();

    return view('toys.bargain-bin', compact('items'));
});
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
