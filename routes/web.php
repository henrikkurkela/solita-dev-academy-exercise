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

Route::post('/location', [FarmController::class, 'addFarm'])->middleware(['auth']);
Route::get('/location/{id}', [FarmController::class, 'getFarm'])->middleware(['auth']);
Route::get('/location/{id}/datapoints', [FarmController::class, 'getFarmTable'])->middleware(['auth']);
Route::delete('/location/{id}', [FarmController::class, 'removeFarm'])->middleware(['auth']);

Route::post('/token/create', [UserController::class, 'createToken'])->middleware(['auth']);
Route::post('/token/revokeall', [UserController::class, 'revokeAllTokens'])->middleware(['auth']);

/*
|--------------------------------------------------------------------------
| Dev Test Routes
|--------------------------------------------------------------------------
|
| These routes should be removed before production.
|
*/

Route::post('/location/removeall', [FarmController::class, 'removeAllFarms'])->middleware(['auth']);

require __DIR__.'/auth.php';
