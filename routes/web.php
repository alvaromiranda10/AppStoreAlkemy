<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;

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

Route::get('/', [UserController::class, 'welcome'])->name('welcome');

Route::get('/redirect', [UserController::class, 'redirect'])->name('redirect');


// route user
Route::middleware(['user'])->group(function () {
    Route::get('/apps/lists', [UserController::class , 'index'])->name('user.index');
});

// routes client
Route::middleware(['auth', 'cli'])->prefix('me')->group(function () {
    Route::get('/apps/lists', [ClientController::class , 'index'])->name('client.index');
    Route::get('/apps/categories', [ClientController::class , 'listCategories'])->name('client.categories');
    Route::get('/apps/category/{category}', [ClientController::class , 'listAppsCategory'])->name('client.appcategory');
});

// routes Developer
Route::middleware(['auth', 'dev'])->prefix('me')->group(function () {
        Route::get('/apps', [DeveloperController::class , 'index'])->name('developer.index');
        Route::get('/apps/create', [DeveloperController::class , 'create'])->name('developer.create');
        Route::post('/apps', [DeveloperController::class , 'store'])->name('developer.store');
        Route::delete('/apps/{id}/delete', [DeveloperController::class , 'destroy'])->name('developer.destroy');
        Route::get('/apps/{id}/edit', [DeveloperController::class , 'edit'])->name('developer.edit');
        Route::put('/apps/{id}', [DeveloperController::class , 'update'])->name('developer.update');
});
