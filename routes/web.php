<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::get('/redirect', [UserController::class, 'index'])->middleware(['auth']);

// Rutas client
Route::middleware(['auth', 'cli'])->prefix('me')->group(function () {
    Route::get('/apps/lists', [AppController::class , 'index'])->name('client');
});

// Rutas Developer
Route::middleware(['auth', 'dev'])->prefix('me')->group(function () {
        Route::get('/apps', [AppController::class , 'indextwo'])->name('developer');
});
