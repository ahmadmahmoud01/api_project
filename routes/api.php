<?php

use App\Http\Controllers\Api\AdController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\DistrictController;
use App\Http\Controllers\Api\DomainController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\SettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Mime\MessageConverter;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Auth Module
Route::controller(AuthController::class)->group(function() {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});

// Settings module
Route::get('/settings', SettingController::class);

// Cities Module
Route::get('/cities', CityController::class);

// Districts Module
Route::get('/districts/{city_id}', DistrictController::class);
// Route::get('/districts', DistrictController::class); using query parameter

// Domains Module
Route::get('/domains', DomainController::class);

// Message Mdule
Route::post('/message', MessageController::class);

// Ad Module
Route::prefix('ads')->controller(AdController::class)->group(function() {
    //basic
    Route::get('/', 'index');
    Route::get('/latest', 'latest');
    Route::get('/domain/{domain_id}', 'getAdsByDomain');
    Route::get('/search', 'search');

    //User Ads API
    Route::middleware('auth:sanctum')->group(function() {
        Route::post('/store', 'store');
        Route::post('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
        Route::get('/all-ads', 'allAds');
    });
});
