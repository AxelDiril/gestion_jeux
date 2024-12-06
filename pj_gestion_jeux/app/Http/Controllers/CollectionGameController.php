<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Game;
use App\Models\Support;
use App\Models\Genre;
use App\Models\Progression;
use App\Models\CollectionGame;

class CollectionGameController extends Controller
{
    // Ajoute un jeu dans la collection dont l'ID est envoyé en paramètres.
    // Vérifie d'abord si il n'est pas déjà dans la collection
    public function add_to_collection($game_id){

        $objUser = Auth::user();

        // Vérifie si le jeu est déjà dans la collection ou non
        $objGameUserExists = CollectionGame::query()->where('id',$objUser->id)->where('game_id',$game_id)->exists();

        if($objGameUserExists){
            $strMessage = "Ce jeu a déjà été ajouté à votre collection";
        }
        else{
            // Ajout du jeu
            DB::table('collection_games')->insert([
                'id' => $objUser->id,
                'game_id' => $game_id
            ]);
            $strMessage = "Ce jeu a bien été ajouté à votre collection.";
        }

        // Message personnalisé
        $strLink = "/liste_jeux";
        $strLinkMessage = "Retour à la liste des jeux";

        return view('pages/message',compact("strMessage","strLink","strLinkMessage"));
    }

    // Récupère les jeux de la collection de l'utilisateur pour les afficher dans profil_collection_jeux
    // Les jeux affichés dépendent des filtres saisis par l'utilisateur
    public function collection_jeux(Request $request, $id){

        // Vérifier si l'utilisateur existe avec l'ID passé en paramètre
        $objUser = User::find($id);  // Recherche de l'utilisateur par ID

        // Si l'utilisateur n'existe pas, rediriger vers la page d'accueil avec un message
        if (!$objUser) {
            $strMessage = "L'utilisateur n'existe pas.";
            $strLink = "/";  // Rediriger vers la page d'accueil
            $strLinkMessage = "Retour à l'accueil";
            return view('pages/message', compact('strMessage', 'strLink', 'strLinkMessage'));
        }

        // Récupération des filtres avec Request
        $iSupportId = $request->query('support_id');
        $iGameYear = $request->query('game_year');
        $strOrder = $request->query('order');
        $strDirection = $request->query('direction');
        $strGameName = $request->query('game_name');
        $iGenreId = $request->query('genre_id');

        // Construction de la requête pour récupérer les jeux de l'utilisateur
        $arCollectionGames = CollectionGame::query()
            ->join('games', 'collection_games.game_id', '=', 'games.game_id')
            ->join('game_genres', 'games.game_id', '=', 'game_genres.game_id')
            ->where('id', $id);

        // Ordre des jeux
        if (!empty($strOrder) && !empty($strDirection)) {
            $arCollectionGames = $arCollectionGames->orderBy('games.' . $strOrder, $strDirection);
        }

        // Filtres optionnels : les conditions s'additionnent si plusieurs filtres sont choisis
        if (!empty($strGameName) && $strGameName != "all") {
            $arCollectionGames->where('games.game_name', 'LIKE', '%' . $strGameName . '%');
        }

        if (!empty($iSupportId) && $iSupportId != "all") {
            $arCollectionGames->where('support_id', $iSupportId);
        }

        if (!empty($iGenreId) && $iGenreId != "all") {
            $arCollectionGames->where('genre_id', $iGenreId);
        }

        if (!empty($iGameYear) && $iGameYear != "all") {
            $arCollectionGames->whereYear('game_year', $iGameYear);
        }

        // Récupérer les jeux de la collection
        $arCollectionGames = $arCollectionGames->distinct('game_id')->get();

        // Récupérer les noms/années pour les filtres
        $arSupports = Support::orderBy('support_name', 'asc')->get();
        $arGenres = Genre::orderBy('genre_label', 'asc')->get();
        $arYears = Game::select('game_year')->distinct()->orderBy('game_year', 'desc')->get();

        // Retourner la vue avec les jeux et les filtres
        return view('pages/profil_collection_jeux', compact('arCollectionGames', 'arSupports', 'arYears', 'arGenres', 'strGameName', 'iSupportId', 'iGameYear', 'iGenreId', 'id'));
    }


    // Editer la note, le commentaire et la progression d'un jeu dans edit_collection_jeu
    public function edit_collection_jeu($gameId, $id)
    {
        // Vérifier si le jeu existe dans la collection de l'utilisateur
        $objCollectionGame = CollectionGame::where('game_id', $gameId)
                                        ->where('id', $id)
                                        ->first();

        // Si le jeu n'existe pas dans la collection, rediriger avec un message d'erreur
        if (!$objCollectionGame) {
            $strMessage = "Ce jeu n'est pas dans votre collection.";
            $strLink = "/profil_collection_jeux/{$id}";  // Rediriger vers la page de collection des jeux
            $strLinkMessage = "Retour à ma collection de jeux";
            return view('pages/message', compact('strMessage', 'strLink', 'strLinkMessage'));
        }

        // Récupérer les progressions à sélectionner
        $arProgressions = Progression::all();

        // Retourner la vue d'édition du jeu
        return view('pages/edit_collection_jeu', compact('objCollectionGame', 'arProgressions'));
    }

    // Mettre à jour les informations du jeu saisies dans edit_collection_jeu
    public function update_collection_jeu(Request $request, $gameId, $userId)
    {
        // Récupérer le couple jeu-utilisateur à mettre à jour
        $objCollectionGame = CollectionGame::where('game_id', $gameId)
        ->where('id', $userId)
        ->first();

        // Si le couple jeu-utilisateur n'existe pas, rediriger avec un message d'erreur
        if (!$objCollectionGame) {
            $strMessage = "Ce jeu n'existe pas dans votre collection.";
            $strLink = "/profil_collection_jeux/{$userId}";  // Lien vers la collection de l'utilisateur
            $strLinkMessage = "Retour à ma collection de jeux";

            return view('pages.message', compact('strMessage', 'strLink', 'strLinkMessage'));
        }

        // Validation des données du formulaire
        $request->validate([
                'note' => 'nullable|numeric|min:0|max:10',
                'comment' => 'nullable|string|max:255',
                'progress_id' => 'nullable|exists:progressions,progress_id',
        ]);
    
        // Mettre à jour les informations
        $objCollectionGame->update($request->all());
    
        // Variables pour la vue du message
        $strMessage = "Les informations du jeu ont été mises à jour avec succès.";
        $strLink = "/liste_jeux";
        $strLinkMessage = "Retour à la collection";

        return view('/pages/message', compact('strMessage', 'strLink', 'strLinkMessage'));
    }
    
    // Supprime un jeu de la collection de l'utilisateur
    public function delete_collection_jeu($game_id)
    {
        $objUser = Auth::user();

        // Vérifier si le jeu existe dans la collection de l'utilisateur
        $objCollectionGame = CollectionGame::where('game_id', $game_id)
                                            ->where('id', $objUser->id)
                                            ->first();

        // Si le jeu n'existe pas dans la collection, rediriger avec un message d'erreur
        if (!$objCollectionGame) {
            $strMessage = "Ce jeu n'existe pas dans votre collection.";
            $strLink = "/profil_collection_jeux/{$objUser->id}"; // Rediriger vers la collection
            $strLinkMessage = "Retour à ma collection de jeux";
            return view('pages/message', compact('strMessage', 'strLink', 'strLinkMessage'));
        }
        else{
            // Supprimer le jeu de la collection
            $objCollectionGame->delete();

            // Message personnalisé pour la vue message
            $strMessage = "Le jeu a été supprimé de votre collection avec succès.";
            $strLink = "/profil_collection_jeux/{$objUser->id}"; // Redirection vers la collection
            $strLinkMessage = "Retour à ma collection de jeux";
        }
        return view('pages/message', compact('strMessage', 'strLink', 'strLinkMessage'));
    }
}
