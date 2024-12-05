<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\CollectionGameController;
use App\Http\Controllers\CollectionSupportController;
use App\Http\Controllers\UserController;

Route::get('/liste_jeux', [GameController::class, 'liste_jeux']);
Route::get('/detail_jeu/{game_id}', [GameController::class, 'detail_jeu']);
Route::get('/liste_supports', [SupportController::class, 'liste_supports']);
Route::get('/detail_support/{support_id}', [SupportController::class, 'detail_support']);
Route::get('/ajout_jeu/{game_id}/{id}', [CollectionGameController::class, 'add_to_collection']);
Route::get('/ajout_support/{support_id}/{id}', [CollectionSupportController::class, 'add_to_collection']);
Route::get('/profil_collection_supports/{id}', [CollectionSupportController::class, 'collection_supports']);
Route::get('/profil_collection_jeux/{id}', [CollectionGameController::class, 'collection_jeux']);
Route::get('/profil/{id}', [UserController::class, 'profil']);
Route::get('/edit_collection_jeu/{game_id}/{id}', [CollectionGameController::class, 'edit_collection_jeu']);
Route::put('/update_collection_jeu/{game_id}/{id}', [CollectionGameController::class, 'update_collection_jeu']);
Route::get('/liste_utilisateurs', [UserController::class, 'liste_utilisateurs']);
Route::get('/edit_utilisateur/{id}', [UserController::class, 'edit_utilisateur']);
Route::put('/update_utilisateur/{id}', [UserController::class, 'update_utilisateur']);


Route::get('/', function () {
    return view('/pages/accueil');
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
