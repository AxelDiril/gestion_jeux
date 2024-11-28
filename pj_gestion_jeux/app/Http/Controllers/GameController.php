<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Support;
use App\Models\Genre;
use App\Models\AppartientGenre;

class GameController extends Controller
{
    public function liste_jeux(Request $request)
    {
        // Retrieve filters
        $iSupportId = $request->query('support_id');
        $iGameYear = $request->query('game_year');
        $strOrder = $request->query('order', 'game_name'); // Default to 'game_name' if no order provided
        $strDirection = $request->query('direction', 'asc'); // Default to ascending if no direction provided
        $strGameName = $request->query('game_name');
        $iGenreId = $request->query('genre_id');
    
        // Start building the query
        $arGames = Game::query();
    
        // Add filters
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
    
        // Add ordering
        $arGames->orderBy($strOrder, $strDirection);
    
        // Get the results
        $arGames = $arGames->get();
    
        // Retrieve supports, genres, and years
        $arSupports = Support::orderBy('support_name', 'asc')->get();
        $arGenres = Genre::orderBy('genre_label', 'asc')->get();
        $arYears = Game::select('game_year')->distinct()->orderBy('game_year', 'desc')->get();
    
        // Send to the view
        return view('pages/liste_jeux', compact('arGames', 'arSupports', 'arYears', 'arGenres', 'strGameName', 'iSupportId', 'iGameYear', 'iGenreId'));
    }
    
    public function detail_jeu(Request $request){

        $iGameId = $request->query('game_id');

        // Construction de la requête pour l'appel du jeu à détailler
        $objGame = Game::query();

        if(!empty($iGameId)){
            $objGame->where('game_id',$iGameId);
        }

        //Obtenir l'unique jeu
        $objGame = $objGame->first();

        // Charge la page avec les détails du jeu concerné
        return view('pages/detail_jeu', compact('objGame', 'iGameId'));
    }
}
