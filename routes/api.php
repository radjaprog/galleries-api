<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GalleriesController;
use App\Http\Controllers\ImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|-------------------------------------------------------------------------
| API Routes
|-------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('images', ImageController::class);
Route::resource('comments', CommentController::class);

Route::controller(GalleriesController::class)->group(
    function () {
        Route::get('galleries', 'index');
        Route::get('my-galleries', 'getMyGalleries');
        Route::get('galleries/{Id}', 'show');
        Route::put('galleries/{Id}', 'update');
        Route::delete('galleries/{Id}', 'destroy');
        Route::post('galleries', 'store');
    }
);

Route::controller(AuthController::class)->group(
    function () {
        Route::post('login', 'login');
        Route::post('refresh', 'refresh');
        Route::post('logout', 'logout');
        Route::post('register', 'register');
    }
);
