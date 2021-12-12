<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\FarmController;

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
Route::post('/location/add', [FarmController::class, 'addFarm'])->middleware(['auth']);
Route::post('/location/removeall', [FarmController::class, 'removeAllFarms'])->middleware(['auth']);

require __DIR__.'/auth.php';
