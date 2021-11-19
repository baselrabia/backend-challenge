<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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
    Route::prefix('/users')->group(function () {
        // authenticated routes
        Route::group(['middleware' => 'auth'], function () {
            Route::get('/', [UserController::class, 'index'])->name('users_list');
 
        });
    });

    // permission routes
    Route::prefix('/permissions')->group(function () {
        // authenticated routes
        Route::group(['middleware' => 'auth'], function () {
            Route::get('/', [PermissionController::class, 'index'])->name('permissions_list');
            Route::post('/', [PermissionController::class, 'store'])->name('permissions_store');
            Route::post('/assign/role', [PermissionController::class, 'assignToRole']);
            Route::post('/assign/user', [PermissionController::class, 'assignToUser']);
  
        });
    });

    // role routes
    Route::prefix('/roles')->group(function () {
        // authenticated routes
        Route::group(['middleware' => 'auth'], function () {
            Route::get('/', [RoleController::class, 'index'])->name('roles_list');
            Route::post('/', [RoleController::class, 'store'])->name('roles_store');
            Route::post('/assign/user', [RoleController::class, 'assignToUser']);
        });
    });

    // page routes
    Route::prefix('/page')->group(function () {
        // authenticated routes
        Route::group(['middleware' => 'auth'], function () {
            Route::get('/home', [PageController::class, 'home']);
            Route::get('/dashboard', [PageController::class, 'dashboard']);
            Route::get('/post', [PageController::class, 'viewPost']);
            Route::get('/upload', [PageController::class, 'uploadPhoto']);
        });
    });



});
