<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class GameController extends Controller
{
    public function liste_jeux(){
        $jeux = Game::all();

        // Envoie les jeux à la vue
        return view('pages/liste_jeux', compact('jeux'));
    }
}
