<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UserController::class, 'register'])->name('register.submit');

Route::get('/game/{link}', [GameController::class, 'show'])->name('game.show');
Route::post('/game/{userId}/play', [GameController::class, 'play'])->name('game.play');
Route::get('/game/{userId}/history', [GameController::class, 'history'])->name('game.history');

Route::post('/game/{userId}/new-link', [UserController::class, 'generateNewLink'])->name('game.newLink');
Route::post('/game/{userId}/deactivate', [UserController::class, 'deactivateLink'])->name('game.deactivate');
