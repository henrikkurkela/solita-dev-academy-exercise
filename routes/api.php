<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\Api\ApiFarmController;

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
Route::get('/location', [ApiFarmController::class, 'index'])->middleware(['auth:sanctum']);
Route::get('/location/{id}', [ApiFarmController::class, 'getFarm'])->middleware(['auth:sanctum']);
