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
Route::post('/login', 'ApiController@login');
Route::post('/newpesan', 'ApiController@newpesan');
Route::post('/balas', 'ApiController@balas');
Route::post('/pesan_all', 'ApiController@get_pesan');