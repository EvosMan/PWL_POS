<?php

use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

route::post('/register', RegisterController::class)->name('register');
route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');
route::middleware('auth:api')->get('/user', function (Request $request){
    return $request ->user();
});

route::post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('logout');

route::get('levels', [LevelController::class, 'index']);
route::post('levels', [LevelController::class, 'store']);
route::get('levels/{level}', [LevelController::class, 'show']);
route::put('levels/{level}', [LevelController::class, 'update']);
route::delete('levels/{level}', [LevelController::class, 'destroy']);