<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Game;
use App\Models\Support;
use App\Models\Genre;
use App\Models\GameGenre;
use App\Models\CollectionGame;

class GameController extends Controller
{
    // Récupère la liste de tous les jeux de GJ_games
    // Affiche les jeux selon les filtres envoyés en paramètres
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
        $arGames = Game::query()
            ->leftJoin('game_genres', 'games.game_id', '=', 'game_genres.game_id') // Jointure avec la table des genres
            ->select('games.*'); // Sélectionne les colonnes de la table `games`

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
            $arGames->where('game_genres.genre_id', $iGenreId);
        }

        $arGames = $arGames->distinct()->get();

        // Récupère tous les supports, genres et les années de sortie pour les filtres
        $arSupports = Support::orderBy('support_name', 'asc')->get();
        $arGenres = Genre::orderBy('genre_label', 'asc')->get();
        $arYears = Game::select('game_year')->distinct()->orderBy('game_year', 'desc')->get();

        return view('pages/liste_jeux', compact('arGames', 'arSupports', 'arYears', 'arGenres', 'strGameName', 'iSupportId', 'iGameYear', 'iGenreId'));
    }
    
    // Récupère toutes les informations d'un jeu choisi depuis liste_jeux ou profil_collection_jeux
    // A partir du game_id passé en paramètres
    public function detail_jeu($game_id){

        $bOwned = false;

        // Requête pour l'appel du jeu à détailler
        $objGame = Game::find($game_id);

        // Vérifier si l'utilisateur connecté a déjà le jeu ou non
        $objUser = Auth::user();
        if($objUser){
            // Récupérer le couple jeu-utilisateur à vérifier
            $objCollectionGame = CollectionGame::where('game_id', $game_id)
            ->where('id', $objUser->id)
            ->first();
            if($objCollectionGame){
                $bOwned = true;
            }
        }

        return view('pages/detail_jeu', compact('objGame','objUser','bOwned'));

    }
}
