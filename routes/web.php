<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Monolog\Level;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/level', [LevelController::class, 'index']);

Route::get('/home', [HomeController::class, 'home']);

Route::prefix('category')->group(function () {
    Route::get('/food-baverage', [CategoryController::class, 'foodBaverage']);
    Route::get('/beauty-health', [CategoryController::class, 'beautyHealth']);
    Route::get('/home-care', [CategoryController::class, 'homeCare']);
    Route::get('/baby-kid', [CategoryController::class, 'babyKid']);
});

Route::get('/profil/name/{name}/umur/{umur}/nim/{nim}', [ProfilController::class, 'show']);

Route::get('/penjualan', [PenjualanController::class, 'penjualan']);

Route::get('/user', [UserController::class, 'index'])->name('user');
Route::get('/user/getUsers', [UserController::class, 'getUsers'])->name('user.getUsers');

//route simpan ajax
Route::get('/user/create_ajax', [UserController::class, 'create_ajax'])->name('user.create_ajax');
Route::post('/user/ajax', [UserController::class, 'store_ajax'])->name('user.store_ajax');

Route::get('/user/tambah', [UserController::class, 'tambah'])->name('user.tambah');
Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan'])->name('user.simpan');

Route::get('/user/ubah/{id}', [UserController::class, 'ubah'])->name('user.ubah');
Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan'])->name('user.ubah_simpan');
Route::get('/user/hapus/{id}', [UserController::class, 'hapus'])->name('user.hapus');


Route::any('/kategori', [KategoriController::class, 'index'])->name('kategori');
Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.create_save');

Route::get('/kategori/edit/{id}', [KategoriController::class, 'edit'])->name('kategori.edit');
Route::put('/kategori/editSave/{id}', [KategoriController::class, 'edit_save'])->name('kategori.edit_save');
Route::delete('/kategori/hapus/{id}', [KategoriController::class, 'hapus'])->name('kategori.hapus');
