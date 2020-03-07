<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/', 'MatchesController@index');
Route::post('/play_all', 'MatchesController@playAllMatches');
Route::post('/play_round', 'MatchesController@playRoundMatches');
Route::post('/reset_all', 'MatchesController@resetAll');
Route::get('/round_matches', 'MatchesController@RoundMatches');


