<?php

use App\Http\Controllers\Api\FrasesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PassportAuthController;
use App\Http\Controllers\Api\PublicacionesController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('getall-frases', [FrasesController::class, 'index']);
    Route::get('getall-comments', [PublicacionesController::class, 'index']);
    Route::post('create-frases', [FrasesController::class, 'create']);
    Route::post('activate-frase', [FrasesController::class, 'activate']);
    Route::post('reject-frase', [FrasesController::class, 'reject']);
    Route::post('add-comment', [PublicacionesController::class, 'create']);
});