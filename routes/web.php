<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\FarmController;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return redirect('dashboard');
});

Route::get('/dashboard', [Controller::class, 'dashboard'])->middleware(['auth'])->name('dashboard');

Route::post('/upload', [UploadController::class, 'upload'])->middleware(['auth']);

Route::post('/locations', [FarmController::class, 'addFarm'])->middleware(['auth']);
Route::get('/locations/{id}', [FarmController::class, 'getFarm'])->middleware(['auth']);
Route::get('/locations/{id}/datapoints', [FarmController::class, 'getFarmTable'])->middleware(['auth']);
Route::delete('/locations/{id}/datapoints/{number}', [FarmController::class, 'removeFarmDataPoint'])->middleware(['auth']);
Route::delete('/locations/{id}/datapoints', [FarmController::class, 'removeFarmDataPoints'])->middleware(['auth']);
Route::delete('/locations/{id}', [FarmController::class, 'removeFarm'])->middleware(['auth']);

Route::get('/tokens', [UserController::class, 'getTokens'])->middleware(['auth']);
Route::delete('/tokens/{id}', [UserController::class, 'revokeToken'])->middleware(['auth']);
Route::post('/tokens/create', [UserController::class, 'createToken'])->middleware(['auth']);
Route::post('/tokens/revokeall', [UserController::class, 'revokeAllTokens'])->middleware(['auth']);

require __DIR__ . '/auth.php';
