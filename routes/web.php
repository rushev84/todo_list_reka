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

Route::get('/rosters/{id}', [RosterController::class, 'show']);

Route::post('/items/create', [ItemController::class, 'create']);
Route::post('/items/store', [ItemController::class, 'store']);
Route::post('/items/delete', [ItemController::class, 'delete']);
