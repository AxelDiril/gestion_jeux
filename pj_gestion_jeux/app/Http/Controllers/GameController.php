<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class GameController extends Controller
{
    public function liste_jeux(){
        // Récupère les jeux dans la base de données
        $jeux = Game::all();  // Retrieve all jeux from the database

        // Envoie les jeux à la vue
        return view('liste_jeux', compact('jeux'));
    }
}
