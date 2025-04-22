<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AuthController;
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

Route::pattern('id','[0-9e]+');

Route::get('login', [AuthController::class, 'login' ])->name('login');
Route::post('login', [AuthController::class, 'postlogin' ]);
Route::get('logout', [AuthController ::class,'logout' ])->middleware('auth');

Route::get('register', [AuthController::class, 'register' ])->name('register');
Route::post('register', [AuthController::class, 'postRegister'])->name('postRegister');

Route::middleware(['auth'])->group(function(){ // artinya semua route di dalam group ini harus login dulu
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::prefix('category')->group(function () {
        Route::get('/food-baverage', [CategoryController::class, 'foodBaverage']);
        Route::get('/beauty-health', [CategoryController::class, 'beautyHealth']);
        Route::get('/home-care', [CategoryController::class, 'homeCare']);
        Route::get('/baby-kid', [CategoryController::class, 'babyKid']);
    });

    Route::get('/profil/name/{name}/umur/{umur}/nim/{nim}', [ProfilController::class, 'show']);

    Route::get('/penjualan', [PenjualanController::class, 'penjualan']);

    Route::middleware(['authorize:ADM'])->group(function () {
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [UserController::class, 'index'])->name('user');
            Route::get('/getUsers', [UserController::class, 'getUsers'])->name('user.getUsers');
            // route simpan ajax
            Route::get('/create_ajax', [UserController::class, 'create_ajax'])->name('user.create_ajax');
            Route::post('/store_ajax', [UserController::class, 'store_ajax'])->name('user.store_ajax');
            //route edit ajax
            Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax'])->name('user.edit_ajax');
            Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax'])->name('user.update_ajax');
            //route hapus ajax
            Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax'])->name('user.confirm_ajax');
            Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax'])->name('user.delete_ajax');

            Route::get('/tambah', [UserController::class, 'tambah'])->name('user.tambah');
            Route::post('/tambah_simpan', [UserController::class, 'tambah_simpan'])->name('user.simpan');

            Route::get('/ubah/{id}', [UserController::class, 'ubah'])->name('user.ubah');
            Route::put('/ubah_simpan/{id}', [UserController::class, 'ubah_simpan'])->name('user.ubah_simpan');

            Route::get('/hapus/{id}', [UserController::class, 'hapus'])->name('user.hapus');

            //route import export ajax
            Route::get('/import', [UserController::class, 'import'])->name('user.import');
            Route::post('/import_ajax', [UserController::class, 'import_ajax'])->name('user.import_ajax');
            Route::get('/export_excel', [UserController::class, 'export_excel'])->name('user.export_excel');
        });

    });

    Route::middleware(['authorize:ADM,MNG'])->group(function () {
        Route::group(['prefix' => 'level'], function () {
            Route::get('/', [LevelController::class, 'index'])->name('level');
            Route::get('/getLevels', [LevelController::class, 'getLevels'])->name('level.getLevels');
            // route simpan ajax
            Route::get('/create_ajax', [LevelController::class, 'create_ajax'])->name('level.create_ajax');
            Route::post('/store_ajax', [LevelController::class, 'store_ajax'])->name('level.store_ajax');
            //route edit ajax
            Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax'])->name('level.edit_ajax');
            Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax'])->name('level.update_ajax');
            //route hapus ajax
            Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax'])->name('level.confirm_ajax');
            Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax'])->name('level.delete_ajax');
            //route import export ajax
            Route::get('/import', [LevelController::class, 'import'])->name('level.import');
            Route::post('/import_ajax', [LevelController::class, 'import_ajax'])->name('level.import_ajax');
            Route::get('/export_excel', [LevelController::class, 'export_excel'])->name('level.export_excel');
        });
    });

    Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        Route::group(['prefix' => 'kategori'], function () {
            Route::get('/', [KategoriController::class, 'index'])->name('kategori');
            Route::get('/getUsers', [KategoriController::class, 'getKategoris'])->name('kategori.getKategoris');
            Route::get('/create_ajax', [KategoriController::class, 'create_ajax'])->name('kategori.create_ajax');
            Route::post('/store_ajax', [KategoriController::class, 'store_ajax'])->name('kategori.store_ajax');

            Route::get('{id}/edit', [KategoriController::class, 'edit_ajax'])->name('kategori.edit_ajax');
            Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax'])->name('kategori.update_ajax');

            Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax'])->name('kategori.confirm_ajax');
            Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax'])->name('kategori.delete_ajax');

            //route import export ajax
            Route::get('/import', [KategoriController::class, 'import'])->name('kategori.import');
            Route::post('/import_ajax', [KategoriController::class, 'import_ajax'])->name('kategori.import_ajax');
            Route::get('/export_excel', [KategoriController::class, 'export_excel'])->name('kategori.export_excel');
        });

        Route::group(['prefix' => 'supplier'], function (){
            Route::get('/', [SupplierController::class, 'index'])->name('supplier');
            Route::get('/getsuppliers', [SupplierController::class, 'getsuppliers'])->name('supplier.getsuppliers');
            // route simpan ajax
            Route::get('/create_ajax', [SupplierController::class, 'create_ajax'])->name('supplier.create_ajax');
            Route::post('/store_ajax', [SupplierController::class, 'store_ajax'])->name('supplier.store_ajax');
            //route edit ajax
            Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax'])->name('supplier.edit_ajax');
            Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax'])->name('supplier.update_ajax');
            //route hapus ajax
            Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax'])->name('supplier.confirm_ajax');
            Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax'])->name('supplier.delete_ajax');
            //route import export ajax
            Route::get('/import', [SupplierController::class, 'import'])->name('supplier.import');
            Route::post('/import_ajax', [SupplierController::class, 'import_ajax'])->name('supplier.import_ajax');
            Route::get('/export_excel', [SupplierController::class, 'export_excel'])->name('supplier.export_excel');
        });

    });

    Route::group(['prefix' => 'barang'], function (){
        Route::get('/', [BarangController::class, 'index'])->name('barang');
        Route::get('/getBarangs', [BarangController::class, 'getBarangs'])->name('barang.getBarangs');
        // route simpan ajax
        Route::get('/create_ajax', [BarangController::class, 'create_ajax'])->name('barang.create_ajax');
        Route::post('/store_ajax', [BarangController::class, 'store_ajax'])->name('barang.store_ajax');
        //route edit ajax
        Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax'])->name('barang.edit_ajax');
        Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax'])->name('barang.update_ajax');
        //route hapus ajax
        Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax'])->name('barang.confirm_ajax');
        Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax'])->name('barang.delete_ajax');
        //route import export ajax
        Route::get('/import', [BarangController::class, 'import'])->name('barang.import');
        Route::post('/import_ajax', [BarangController::class, 'import_ajax'])->name('barang.import_ajax');
        Route::get('/export_excel', [BarangController::class, 'export_excel'])->name('barang.export_excel');
    });
});

