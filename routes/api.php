<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\Farm;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/location', function (Request $request) {
    return Farm::where('user_id', auth()->id())->get();
});

Route::middleware('auth:sanctum')->get('/location/{id}', function (Request $request, $id) {
    $farm = Farm::where([
        'user_id' => auth()->id(),
        'id' => $id
    ])->firstOrFail();

    $farm->datapoints = $farm->dataPoints()->latest('datetime')->paginate(100);

    return $farm;
});
