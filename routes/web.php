<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopcartController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sepet', [ShopcartController::class, 'index'])->name('basket');
Route::post('/sepet/ekle', [ShopcartController::class, 'add'])->name('basket.add');
Route::post('/sepet/code-control', [ShopcartController::class, 'code'])->name('basket.code');
Route::get('/sepet/remove/{id}', [ShopcartController::class, 'remove'])->name('basket.remove');


