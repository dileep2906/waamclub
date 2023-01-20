<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Web\AuthController;


use App\Http\Controllers\Api\Web\VendorController;
use App\Http\Controllers\Api\Web\AppModuleController;
use App\Http\Controllers\Api\Web\FranchiseController;

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

/*
|--------------------------------------------------------------------------
| CONTENTAINS ROUTES 
|--------------------------------------------------------------------------
|   LOGIN
|   
|   MIDDLEWARE->sanctum
|               LOGOUT|               
|               APP_MODULES
|               JOBS CATEGORY
|               JOBS 
|               SKILLS 
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::post('register', [AuthController::class, 'createUser']);

// PROTECTED ROUTES

Route::middleware(['auth:sanctum'])->group(function () {

    // Route::apiResource('franchise', FranchiseController::class);
    // Route::apiResource('vender', VenderController::class);

    // /**** FRANCHISE  *****/
    Route::get('/franchise', [FranchiseController::class, 'index']);
    Route::get('/franchise/{franchise}', [FranchiseController::class, 'show']);
    Route::post('/franchise', [FranchiseController::class, 'store'])->name('franchise');
    Route::post('/franchise/{franchise}', [FranchiseController::class, 'update']);
    Route::delete('/franchise/{franchise}', [FranchiseController::class, 'destroy']);

    /**** VENDOR  *****/
    Route::get('/vendor', [VendorController::class, 'index']);
    Route::get('/vendor/{vendor}', [VendorController::class, 'show']);
    Route::post('/vendor', [VendorController::class, 'store']);
    Route::post('/vendor/{vendor}', [VendorController::class, 'update']);
    Route::delete('/vendor/{vendor}', [VendorController::class, 'destroy']);

   
});

Route::get('/test', function (Request $request) {
    return "WebApi";
});

