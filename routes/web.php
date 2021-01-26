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

Route::get('/', [UserController::class, 'index'])->name('welcome');

Route::get('/redirect', [UserController::class, 'redirect'])->name('redirect');


// route user
// Route::group(['prefix' => 'user'], function () {
    Route::middleware(['user'])->group(function () {
    Route::get('/apps/categories', [UserController::class , 'listsCategories'])->name('user.categories');
    Route::get('/apps/categories/{category}', [UserController::class , 'listAppsCategory'])->name('user.appcategory');
    Route::get('/apps/{id}/detail', [UserController::class , 'appDetail'])->name('user.appdetail');
});


// routes client
// Route::group(['prefix' => 'me'], function () {
Route::group(['prefix' => 'me', 'middleware' => ['auth', 'cli']], function () {
    Route::get('/apps', [ClientController::class , 'index'])->name('client.index');
    Route::get('/apps/categories', [ClientController::class , 'listsCategories'])->name('client.categories');
    Route::get('/apps/category/{category}', [ClientController::class , 'listAppsCategory'])->name('client.appcategory');
    Route::get('/apps/{id}/detail', [ClientController::class , 'appDetail'])->name('client.appdetail');
    Route::post('wish', [ClientController::class , 'wishApp'])->name('client.wish');
    Route::delete('wish', [ClientController::class , 'deleteWishApp'])->name('client.delete.wish');
});

// Route::group(['prefix' => 'me'], function () {
Route::group(['prefix' => 'api', 'middleware' => ['auth', 'cli']], function () {
    Route::post('buy', [ClientController::class , 'buyApp'])->name('client.buy');
    Route::delete('buy', [ClientController::class , 'deleteBuyApp'])->name('client.delete.buy');
});

// routes Developer
// Route::group(['prefix' => 'admin'], function () {
    Route::group(['prefix' => 'me', 'middleware' => [ 'auth', 'dev']], function () {
        Route::get('/apps/created', [DeveloperController::class , 'index'])->name('developer.index');
        Route::get('/apps/create', [DeveloperController::class , 'create'])->name('developer.create');
        Route::post('/apps', [DeveloperController::class , 'store'])->name('developer.store');
        Route::delete('/apps/{id}/delete', [DeveloperController::class , 'destroy'])->name('developer.destroy');
        Route::get('/apps/{id}/edit', [DeveloperController::class , 'edit'])->name('developer.edit');
        Route::put('/apps/{id}', [DeveloperController::class , 'update'])->name('developer.update');
});