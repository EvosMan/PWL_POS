<?php

use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\BarangController;
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
route::post('/register1', App\Http\Controllers\Api\RegisterController::class)->name('register1');




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


//Api user
route::get('users', [UserController::class, 'index']);
route::post('users', [UserController::class, 'store']);
route::get('users/{user}', [UserController::class, 'show']);
route::put('users/{user}', [UserController::class, 'update']);
route::delete('users/{user}', [UserController::class, 'destroy']);

//Api Kategori

route::get('kategoris', [KategoriController::class, 'index']);
route::post('kategoris', [KategoriController::class, 'store']);
route::get('kategoris/{kategori}', [KategoriController::class, 'show']);
route::put('kategoris/{kategori}', [KategoriController::class, 'update']);
route::delete('kategoris/{kategori}', [KategoriController::class, 'destroy']);

//Api Barang
route::get('Barangs', [BarangController::class, 'index']);
route::post('Barangs', [BarangController::class, 'store']);
route::get('Barangs/{Barang}', [BarangController::class, 'show']);
route::put('Barangs/{Barang}', [BarangController::class, 'update']);
route::delete('Barangs/{Barang}', [BarangController::class, 'destroy']);