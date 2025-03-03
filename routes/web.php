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

Route::get('/kategori', [KategoriController::class, 'index']);

Route::get('/user', [UserController::class, 'index']);

Route::get('/home', [HomeController::class, 'home']);

Route::prefix('category')->group(function () {
    Route::get('/food-baverage', [CategoryController::class, 'foodBaverage']);
    Route::get('/beauty-health', [CategoryController::class, 'beautyHealth']);
    Route::get('/home-care', [CategoryController::class, 'homeCare']);
    Route::get('/baby-kid', [CategoryController::class, 'babyKid']);
});

Route::get('/profil/name/{name}/umur/{umur}/nim/{nim}', [ProfilController::class, 'show']);

Route::get('/penjualan', [PenjualanController::class, 'penjualan']);
