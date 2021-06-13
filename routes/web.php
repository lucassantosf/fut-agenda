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

Route::group(['prefix'=>'/dashboard','middleware'=>'auth'], function() {

    Route::get('/', function () {
        return redirect()->route('player.index');
    })->name('dashboard');

	Route::resource('match', MatchController::class);
    Route::post('match-sort-team', [MatchController::class,'sort_teams'])->name('sort_teams');
    Route::post('match-show', [MatchController::class,'show'])->name('match.show.table');
	Route::resource('player', PlayerController::class);
});
 
  
require __DIR__.'/auth.php';
 
Route::get('/{any?}', function () {
    return redirect('/login');
});