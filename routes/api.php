<?php

use App\Http\Controllers\Auth\LoginController;
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


Route::group(['middleware' => 'api'], function () {


    // auth routes
    Route::prefix('/auth')->namespace('Auth')->group(function () {
        Route::post('login', [LoginController::class, 'login'])->name('auth_login');

        // authenticated routes
        Route::group(['middleware' => 'auth'], function () {
            Route::post('logout', [LoginController::class, 'logout'])->name('auth_logout');
        });
    });

    // user routes
    Route::prefix('/users')->namespace('User')->group(function () {
        // authenticated routes
        Route::group(['middleware' => 'auth'], function () {
            Route::get('/', [UserController::class, 'index'])->name('users_list');
            // Route::post('/', [UserController::class, 'store'])->name('users_store');
            // Route::put('/{id}', [UserController::class, 'edit'])->name('users_edit');
            // Route::get('/{id}', [UserController::class, 'show'])->name('users_show');


        });
    });
});
