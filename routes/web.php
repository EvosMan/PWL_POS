<?php

use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [WelcomeController::class, 'index']);

Route::group(['prefix' => 'user'])












Route::get('/level', [LevelController::class, 'index']);

Route::post('/level', [LevelController::class, 'store']);



Route::post('/kategori', [KategoriController::class, 'store']);

Route::get('/kategori', [KategoriController::class, 'index']);

Route::get('/kategori/edit/{id}', [KategoriController::class, 'edit']);

Route::get('/kategori/create/', [KategoriController::class, 'create']);

Route::put('/kategori/update/{id}', [KategoriController::class, 'edit_simpan']);

Route::delete('/kategori/delete/{id}', [KategoriController::class, 'delete']);

Route::get('/user', [UserController::class, 'index']);

Route::get('/user/tambah', [UserController::class, 'tambah']);

Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);

Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);

Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);

Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);
