<?php

use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RoomController;

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

Route::view('/', 'index')->name('home');

/*
|--------------------------------------------------------------------------
| Registration Routes
|--------------------------------------------------------------------------
*/
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/register-room', [RegisterController::class, 'registerRoom'])->name('register.room');

/*
|--------------------------------------------------------------------------
| Rooms Routes
|--------------------------------------------------------------------------
*/
Route::get('/rooms/{room}', [RoomController::class, 'view'])->name('rooms.index');
Route::get('/rooms/join/{token}', [RoomController::class, 'join'])->name('rooms.join');
Route::post('/rooms/add', [RoomController::class, 'add'])->name('rooms.add');

/*
|--------------------------------------------------------------------------
| Messages Routes
|--------------------------------------------------------------------------
*/
Route::post('/messages', [MessageController::class, 'add'])->name('message.post');