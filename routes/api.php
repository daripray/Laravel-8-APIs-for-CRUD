<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PetaniController;
use App\Http\Controllers\API\KelompokTaniController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('/kelompok_tani', KelompokTaniController::class);
// Route::post('/kelompok_tani/{id}',[KelompokTaniController::class, 'update']);

Route::resource('/petani', PetaniController::class);
// Route::post('/petani/{id}',[PetaniController::class, 'update']);


// Route::get('/kelompok_tanis', [KelompokTaniController::class, 'index']);
// Route::get('/kelompok_tani/{id}', [KelompokTaniController::class, 'show']);
// Route::post('/kelompok_tani/create', [KelompokTaniController::class, 'store']);
Route::post('/kelompok_tani/{id}',[KelompokTaniController::class, 'update']);

// Route::get('/petanis', [PetaniController::class, 'index']);
// Route::get('/petani/{id}', [PetaniController::class, 'show']);
// Route::post('/petani', [PetaniController::class, 'store']);
// Route::post('/petani/{id}',[PetaniController::class, 'update']);

// Route::get('/petanis', function () {
//     return App\Models\Petani::all();
// });
// Route::get('/petani/{id}', function ($id) {
//     return App\Models\Petani::fidn($id);
// });
