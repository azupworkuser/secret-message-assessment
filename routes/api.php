<?php

use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/messages/{room}', [MessageController::class, 'index'])->name('message.get');
Route::post('/messages/mark-as-read', [MessageController::class, 'markAsRead'])->name('message.read');