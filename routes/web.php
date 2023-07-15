<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\RosterController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [MainController::class, 'index'])->name('main.index');

Route::get('/register', [RegisterController::class, 'showRegistrationForm']);
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    // web
    Route::get('/rosters', [RosterController::class, 'index'])->name('rosters.index');
    Route::get('/rosters/{id}', [RosterController::class, 'show'])->name('rosters.show');

    // ajax
    Route::post('/rosters/create', [RosterController::class, 'create'])->name('rosters.create');
    Route::post('/rosters/update', [RosterController::class, 'update'])->name('rosters.update');
    Route::post('/rosters/delete', [RosterController::class, 'delete'])->name('rosters.delete');

    Route::post('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items/update', [ItemController::class, 'update'])->name('items.update');
    Route::post('/items/delete', [ItemController::class, 'delete'])->name('items.delete');

    Route::post('/items/search', [ItemController::class, 'search'])->name('items.search');
});

