<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Game;
use App\Models\Support;
use App\Models\Genre;
use App\Models\GameGenre;
use App\Models\CollectionGame;

/**
 * Contrôleur pour la gestion des jeux.
 * Permet d'afficher la liste des jeux, les détails d'un jeu, et de gérer les filtres.
 */
class GameController extends Controller
{
    /**
     * Récupère et affiche la liste des jeux avec les filtres.
     *
     * Cette méthode permet de filtrer les jeux selon les critères fournis dans la requête,
     * tels que le nom du jeu, l'année de sortie, le support, et le genre.
     * Elle renvoie également la liste des jeux sous forme de vue.
     *
     * @param  \Illuminate\Http\Request  $request Les paramètres de la requête HTTP.
     * @return \Illuminate\View\View La vue affichant la liste des jeux filtrée.
     */
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
            ->select('games.*');

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

        // Appliquer la pagination sur la requête avant d'exécuter la récupération
        $arGames = $arGames->distinct()->paginate(50);

        // Récupère tous les supports, genres et les années de sortie pour les filtres
        $arSupports = Support::orderBy('support_name', 'asc')->get();
        $arGenres = Genre::orderBy('genre_label', 'asc')->get();
        $arYears = Game::select('game_year')->distinct()->orderBy('game_year', 'desc')->get();

        return view('pages/liste_jeux', compact('arGames', 'arSupports', 'arYears', 'arGenres', 'strGameName', 'iSupportId', 'iGameYear', 'iGenreId'));
    }
    
    /**
     * Récupère et affiche les détails d'un jeu sélectionné.
     *
     * Cette méthode récupère toutes les informations d'un jeu à partir de son `game_id`.
     * Elle vérifie également si l'utilisateur connecté possède déjà ce jeu dans sa collection.
     *
     * @param  int  $game_id L'ID du jeu à afficher.
     * @return \Illuminate\View\View La vue affichant les détails du jeu.
     */
    public function detail_jeu($game_id)
    {
        $bOwned = false;

        // Requête pour l'appel du jeu à détailler
        $objGame = Game::find($game_id);

        // Vérifier si l'utilisateur connecté a déjà le jeu ou non
        $objUser = Auth::user();
        if ($objUser) {
            // Récupérer le couple jeu-utilisateur à vérifier
            $objCollectionGame = CollectionGame::where('game_id', $game_id)
                ->where('id', $objUser->id)
                ->first();
            if ($objCollectionGame) {
                $bOwned = true;
            }
        }

        return view('pages/detail_jeu', compact('objGame', 'objUser', 'bOwned'));
    }
}
