<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Support;
use App\Models\Genre;
use App\Models\AppartientGenre;

class GameController extends Controller
{
    // Récupère tous les jeux de GJ_games
    // Les jeux qui seront affichés dépendent des filtres saisis par l'utilisateur dans $request
    public function liste_jeux(Request $request)
    {
        // Récupérer les filtres passés dans $request
        $iSupportId = $request->query('support_id');
        $iGameYear = $request->query('game_year');
        $strOrder = $request->query('order', 'game_name');
        $strDirection = $request->query('direction', 'asc');
        $strGameName = $request->query('game_name');
        $iGenreId = $request->query('genre_id');
    
        // Construction de la requête
        $arGames = Game::query();
    
        // Ordre des jeux
        $arGames->orderBy($strOrder, $strDirection);

        // Filtres optionnels : les conditions s'additionnent si plusieurs filtres sont choisis
        if (!empty($strGameName) && $strGameName != "all") {
            $arGames->where('game_name', 'LIKE', '%' . $strGameName . '%');
        }
    
        if (!empty($iSupportId) && $iSupportId != "all") {
            $arGames->where('support_id', $iSupportId);
        }
    
        if (!empty($iGameYear) && $iGameYear != "all") {
            $arGames->where('game_year', $iGameYear);
        }
    
        if (!empty($iGenreId) && $iGenreId != "all") {
            $arGames->whereHas('genres', function ($query) use ($iGenreId) {
                $query->where('genre_id', $iGenreId);
            });
        }
    
        $arGames = $arGames->get();
    
        // Récupère tous les supports, genres et les années de sortie pour les filtres
        $arSupports = Support::orderBy('support_name', 'asc')->get();
        $arGenres = Genre::orderBy('genre_label', 'asc')->get();
        $arYears = Game::select('game_year')->distinct()->orderBy('game_year', 'desc')->get();
    
        return view('pages/liste_jeux', compact('arGames', 'arSupports', 'arYears', 'arGenres', 'strGameName', 'iSupportId', 'iGameYear', 'iGenreId'));
    }
    
    // Récupère toutes les informations d'un jeu choisi depuis liste_jeux ou profil_collection_jeux
    // A partir du game_id passé en paramètres
    public function detail_jeu($game_id){

        // Requête pour l'appel du jeu à détailler
        $objGame = Game::find($game_id);

        return view('pages/detail_jeu', compact('objGame'));
    }
}
