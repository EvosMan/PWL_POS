<?php

use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PenjualanController;
use App\Models\BarangModel;

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

Route::group(['prefix' => 'penjualan'], function () {
    Route::get('/', [PenjualanController::class, 'index']);
    Route::post('/list', [PenjualanController::class, 'list']);
    Route::get('/create', [PenjualanController::class, 'create']);
    Route::post('/', [PenjualanController::class, 'store']);
    Route::get('/{id}', [PenjualanController::class, 'show']);
    Route::get('/{id}/edit', [PenjualanController::class, 'edit']);
    Route::put('/{id}', [PenjualanController::class, 'update']);
    Route::delete('/{id}', [PenjualanController::class, 'destroy']);
});

Route::group(['prefix' => 'user'], function(){
    Route::get('/', [UserController::class, 'index']);//menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']);//Menampikan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create']);//menampilkan halam form tambah user
    Route::post('/', [UserController::class, 'store']);//menyimpan data user baru
    Route::get('/{id}', [UserController::class, 'show']);//menampilkan halaman detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']);//menampilkan halaman form edit user
    Route::put('/{id}',[UserController::class, 'update']);//menyimpan perubahan data user
    Route::delete('/{id}', [UserController::class, 'destroy']);//menghapus data user
});
// Route::get('test/list', [KategoriController::class, 'list']);//Menampikan data Kategori dalam bentuk json untuk datatables

Route::group(['prefix' => 'kategori'], function(){
    Route::get('/', [KategoriController::class, 'index']);//menampilkan halaman awal Kategori
    Route::post('/list', [KategoriController::class, 'list']);//Menampikan data Kategori dalam bentuk json untuk datatables
    Route::get('/create', [KategoriController::class, 'create']);//menampilkan halam form tambah Kategori
    Route::post('/', [KategoriController::class, 'store']);//menyimpan data Kategori baru
    Route::get('/{id}', [KategoriController::class, 'show']);//menampilkan halaman detail Kategori
    Route::get('/{id}/edit', [KategoriController::class, 'edit']);//menampilkan halaman form edit Kategori
    Route::put('/{id}',[KategoriController::class, 'update']);//menyimpan perubahan data Kategori
    Route::delete('/{id}', [KategoriController::class, 'destroy']);//menghapus data Kategori
});



Route::group(['prefix' => 'level'], function(){
    Route::get('/', [LevelController::class, 'index']);//menampilkan halaman awal Level
    Route::post('/list', [LevelController::class, 'list']);//Menampikan data Level dalam bentuk json untuk datatables
    Route::get('/create', [LevelController::class, 'create']);//menampilkan halam form tambah Level
    Route::post('/', [LevelController::class, 'store']);//menyimpan data Level baru
    Route::get('/{id}', [LevelController::class, 'show']);//menampilkan halaman detail Level
    Route::get('/{id}/edit', [LevelController::class, 'edit']);//menampilkan halaman form edit Level
    Route::put('/{id}',[LevelController::class, 'update']);//menyimpan perubahan data Level
    Route::delete('/{id}', [LevelController::class, 'destroy']);//menghapus data Level
});

Route::group(['prefix' => 'stok'], function () {
    Route::get('/', [StokController::class, 'index']);
    Route::post('/list', [StokController::class, 'list']);
    Route::get('/create', [StokController::class, 'create']);
    Route::post('/', [StokController::class, 'store']);
    Route::get('/{id}', [StokController::class, 'show']);
    Route::get('/{id}/edit', [StokController::class, 'edit']);
    Route::put('/{id}', [StokController::class, 'update']);
    Route::delete('/{id}', [StokController::class, 'destroy']);
});














Route::get('test', function() {
    return BarangModel::with('kategori')->get();
});
Route::get('/ok', [BarangController::class, 'list']);//Menampikan data Barang dalam bentuk json untuk datatables

Route::group(['prefix' => 'barang'], function(){
    Route::get('/', [BarangController::class, 'index']);//menampilkan halaman awal Barang
    Route::post('/list', [BarangController::class, 'list']);//Menampikan data Barang dalam bentuk json untuk datatables
    Route::get('/create', [BarangController::class, 'create']);//menampilkan halam form tambah Barang
    Route::post('/', [BarangController::class, 'store']);//menyimpan data Barang baru
    Route::get('/{id}', [BarangController::class, 'show']);//menampilkan halaman detail Barang
    Route::get('/{id}/edit', [BarangController::class, 'edit']);//menampilkan halaman form edit Barang
    Route::put('/{id}',[BarangController::class, 'update']);//menyimpan perubahan data Barang
    Route::delete('/{id}', [BarangController::class, 'destroy']);//menghapus data Barang
});







// Route::get('/level', [LevelController::class, 'index']);

// Route::post('/level', [LevelController::class, 'store']);




// Route::get('/user', [UserController::class, 'index']);

// Route::get('/user/tambah', [UserController::class, 'tambah']);

// Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);

// Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);

// Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);

// Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);
