<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\PlayerController;
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

Route::group(['prefix'=>'dashboard','middleware'=>'auth'], function() {

    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

	Route::resource('match', MatchController::class);
	Route::resource('player', PlayerController::class);


});
 
  
require __DIR__.'/auth.php';
 
Route::get('/{any?}', function () {
    return redirect('/login');
});