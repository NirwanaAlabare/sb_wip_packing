<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PackingLineReturnController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::controller(LoginController::class)->prefix('login')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/', 'index')->name('login');
        Route::post('/authenticate', 'authenticate');
    });

    Route::post('/unauthenticate', 'unauthenticate')->middleware('auth');
});


Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('index');
    });

    Route::controller(ProductionController::class)->prefix('production-panel')->group(function () {
        Route::get('/{id}', 'index');
        Route::post('/unauthenticate', 'unauthenticate')->middleware('auth');
    });

    Route::controller(ProfileController::class)->prefix('profile')->group(function () {
        // Route::get('/{id}', 'index');
        Route::put('/update/{id}', 'update')->middleware('auth');
    });

    Route::controller(PackingLineReturnController::class)->prefix('packing-line-return')->group(function () {
        Route::get('/waiting', 'waiting')->name('packing-line-return-waiting');
        Route::get('/defect', 'defect')->name('packing-line-return-defect');
        Route::get('/rework', 'rework')->name('packing-line-return-rework');
        Route::get('/reject', 'reject')->name('packing-line-return-reject');
    });
});
