<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\RosterController;
use App\Http\Controllers\TagController;
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

Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'enter'])->name('login.enter');

Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');

Route::middleware('auth')->group(function () {
    // web
    Route::get('/rosters', [RosterController::class, 'index'])->name('rosters.index');
    Route::get('/rosters/{id}', [RosterController::class, 'show'])->name('rosters.show');

    Route::get('/tags', [TagController::class, 'index'])->name('tags.index');

    // ajax
    Route::post('/rosters/create', [RosterController::class, 'create'])->name('rosters.create');
    Route::post('/rosters/update', [RosterController::class, 'update'])->name('rosters.update');
    Route::post('/rosters/delete', [RosterController::class, 'delete'])->name('rosters.delete');

    Route::post('/tags/create', [TagController::class, 'create'])->name('tags.create');
    Route::post('/tags/delete', [TagController::class, 'delete'])->name('tags.delete');

    Route::post('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items/update', [ItemController::class, 'update'])->name('items.update');
    Route::post('/items/delete', [ItemController::class, 'delete'])->name('items.delete');

    Route::post('/items/search', [ItemController::class, 'search'])->name('items.search');

    Route::post('/items/add_tag', [ItemController::class, 'addTag'])->name('items.addTag');
    Route::post('/items/delete_tag', [ItemController::class, 'deleteTag'])->name('items.deleteTag');

    Route::post('/items/{id}/upload_image', [ItemController::class, 'uploadImage'])->name('items.uploadImage');


    // will delete from production
    Route::get('/test_images', [ItemController::class, 'testImages']);

    Route::get('/test_form', function () {
        return view('test_form');
    });

});

