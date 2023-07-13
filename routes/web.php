<?php

use App\Http\Controllers\ItemController;
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

Route::get('/rosters', [RosterController::class, 'index'])->name('rosters.index');
Route::get('/rosters/{id}', [RosterController::class, 'show'])->name('rosters.show');

Route::post('/items/create', [ItemController::class, 'create'])->name('items.create');
Route::post('/items/update', [ItemController::class, 'update'])->name('items.update');
Route::post('/items/delete', [ItemController::class, 'delete'])->name('items.delete');
