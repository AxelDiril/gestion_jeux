<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\CollectionGameController;
use App\Http\Controllers\CollectionSupportController;
use App\Http\Controllers\UserController;

Route::get('/liste_jeux', [GameController::class, 'liste_jeux']);
Route::get('/detail_jeu', [GameController::class, 'detail_jeu']);
Route::get('/liste_supports', [SupportController::class, 'liste_supports']);
Route::get('/detail_support', [SupportController::class, 'detail_support']);
Route::get('/ajout_jeu', [CollectionGameController::class, 'add_to_collection']);
Route::get('/ajout_support', [CollectionSupportController::class, 'add_to_collection']);
Route::get('/profil', [UserController::class, 'show_profile']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
