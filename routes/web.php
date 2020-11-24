<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::middleware(['auth'])->group(function() {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resources([
        'authors' => App\Http\Controllers\AuthorController::class,
        'books' => App\Http\Controllers\BookController::class,
    ]);
    Route::post('/books/{book}/change-status', [\App\Http\Controllers\BookController::class, 'changeStatus'])->name('books.change-status');
});
