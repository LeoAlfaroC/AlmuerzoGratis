<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RecipeController;
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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('process-order', [OrderController::class, 'process']);

    Route::post('get-orders', [OrderController::class, 'index']);
    Route::post('get-purchases', [PurchaseController::class, 'index']);
    Route::post('get-recipes', [InventoryController::class, 'index']);
    Route::post('get-inventory', [RecipeController::class, 'index']);
});
