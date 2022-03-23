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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/register", [App\Http\Controllers\UserController::class, 'register']);
Route::post("/login", [App\Http\Controllers\UserController::class, 'login']);
Route::get('/getAuthUser', [App\Http\Controllers\UserController::class, 'getAuthenticatedUser']);
Route::get("/customers", [App\Http\Controllers\CustomersController::class, 'show']);
Route::post("/customers", [App\Http\Controllers\CustomersController::class, 'store']);



Route::group(['middleware' => ['jwt.verify:2, 1, 0']], function(){

    Route::group(['middleware' => ['jwt.verify:2']], function(){
        Route::delete("/customers/{id_customers}", [App\Http\Controllers\CustomersController::class, 'destroy']);
        Route::delete("/product/{id_product}", [App\Http\Controllers\ProductController::class, 'destroy']);
        Route::delete("/petugas/{id_petugas}", [App\Http\Controllers\PetugasController::class, 'destroy']);
        Route::delete("/detail/{id_product}", [App\Http\Controllers\DetailOrdersController::class, 'destroy']);
    });

    Route::group(['middleware' => ['jwt.verify:2,1']], function(){
        Route::post("/product", [App\Http\Controllers\ProductController::class, 'store']);
        Route::post("/order", [App\Http\Controllers\OrdersController::class, 'store']);
        Route::post("/detail", [App\Http\Controllers\DetailOrdersController::class, 'store']);

        Route::put("/customers/{id_customers}", [App\Http\Controllers\CustomersController::class, 'update']);
        Route::put("/product/{id_product}", [App\Http\Controllers\ProductController::class, 'update']);
        Route::put("/petugas/{id_petugas}", [App\Http\Controllers\PetugasController::class, 'update']);
        Route::put("/order/{id_orders}", [App\Http\Controllers\OrdersController::class, 'update']);
        Route::put("/detail/{id_product}", [App\Http\Controllers\DetailOrdersController::class, 'update']);

    });

Route::get("/product", [App\Http\Controllers\ProductController::class, 'show']);

Route::get("/petugas", [App\Http\Controllers\PetugasController::class, 'show']);

Route::get("/order", [App\Http\Controllers\OrdersController::class, 'show']);

Route::get("/detail", [App\Http\Controllers\DetailOrdersController::class, 'show']);
Route::get("/detail/{id_product}", [App\Http\Controllers\DetailOrdersController::class, 'detail']);
});