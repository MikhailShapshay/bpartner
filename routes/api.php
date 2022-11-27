<?php

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Controllers\Api\v1\AuthController;
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
/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::prefix('v1')->group(function (){
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/categorys', [ApiController::class, 'categorys']);
    Route::post('/product', [ApiController::class, 'getProductBySlug']);
    Route::post('/get-product-by-filters', [ApiController::class, 'getProducts']);

    Route::group(['middleware' => 'auth:sanctum'], function (){
        Route::get('/user', [AuthController::class, 'user']);
    });
});


