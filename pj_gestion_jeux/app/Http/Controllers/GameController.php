<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Support;
use App\Models\Genre;
use App\Models\AppartientGenre;

class GameController extends Controller
{
    public function liste_jeux(Request $request){

        // Récupération des filtres avec Request
        $iSupportId = $request->query('support_id');
        $iGameYear = $request->query('game_year');
        $strOrder = $request->query('order');
        $strDirection = $request->query('direction');
        $strGameName = $request->query('game_name');
        $iGenreId = $request->query('genre_id');

        // Construction de la requête pour l'appel des jeux
        $arGames = Game::query();

        // Jointure avec GJ_appartient_genres
        $arGames = $arGames->join('game_genres',"games.game_id", "=", "game_genres.game_id");

        // Ordonner la requête
        if(!empty($strOrder) && !empty($strDirection)){
            $arGames = $arGames->orderBy($strOrder,$strDirection);
        }

        // Filtres
        if(!empty($strGameName) && $strGameName != "all"){
            $arGames->where('game_name','LIKE','%'.$strGameName.'%');
        }

        if(!empty($iSupportId) && $iSupportId != "all"){
            $arGames->where('support_id',$iSupportId);
        }

        if(!empty($iGenreId) && $iGenreId != "all"){
            $arGames->where('genre_id',$iGenreId);
        }

        if(!empty($iGameYear) && $iGameYear != "all"){
            $arGames->whereYear('game_year',$iGameYear);
        }

        $arGames = $arGames->distinct('game_id')->get();
        $arSupports = Support::orderBy('support_name','asc')->get();
        $arGenres = Genre::orderBy('genre_label','asc')->get();
        $arYears = Game::select('game_year')->distinct()->orderBy('game_year','desc')->get();

        // Envoie les jeux, les supports et all les années
        return view('pages/liste_jeux', compact('arGames', 'arSupports', 'arYears', "arGenres", 'strGameName', 'iSupportId', 'iGameYear', 'iGenreId'));
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
