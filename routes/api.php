<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\Api\ApiFarmController;
use App\Http\Controllers\Api\ApiDataPointController;

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

Route::get('/user', [ApiUserController::class, 'index'])->middleware(['auth:sanctum']);
Route::get('/locations', [ApiFarmController::class, 'index'])->middleware(['auth:sanctum']);
Route::get('/locations/{id}', [ApiFarmController::class, 'getFarm'])->middleware(['auth:sanctum']);
Route::post('/locations/{id}', [ApiDataPointController::class, 'addDataPoint'])->middleware(['auth:sanctum']);
