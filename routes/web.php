<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeckController;
use App\Http\Controllers\StudyController;
use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('/decks', DeckController::class);
Route::resource('/cards', CardController::class)
    ->except('show', 'index');

Route::get('/study', [StudyController::class, 'index'])->name('study.index');
Route::get('/study/{deck_id}/flashcard', [StudyController::class, 'flashcard'])->name('study.flashcard');
Route::post('/study/rate', [StudyController::class, 'rate'])->name('study.rate');
Route::get('/study/result/{session_id}', [StudyController::class, 'result'])->name('study.result');

