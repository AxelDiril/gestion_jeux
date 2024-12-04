<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CollectionGame;
use App\Models\CollectionSupport;

class UserController extends Controller
{
    public function show_profile(Request $request){

        // Récupération des filtres avec Request
        $iId = $request->query('id');

        $objUser = User::query()->where('id',$iId)->first();

        $arLatestGames = CollectionGame::query()->where('id',$iId)->orderBy('added_at')->limit(5)->get();
        $arLatestSupports = CollectionSupport::query()->where('id',$iId)->orderBy('added_at')->limit(5)->get();
        $iTotalGames = CollectionGame::query()->where('id',$iId)->distinct('game_id')->count('game_id');
        $iTotalSupports = CollectionSUpport::query()->where('id',$iId)->distinct('support_id')->count('support_id');

        return view('pages/profil', compact('objUser', 'iTotalGames', 'iTotalSupports', 'arLatestGames', 'arLatestSupports'));
    }

    public function liste_utilisateurs(Request $request)
    {
        // Récupération des filtres de la requête
        $strName = $request->query('name');
        $strOrder = $request->query('order');
        $strDirection = $request->query('direction');
        $visibilite = $request->query('visibilite');
        $code = $request->query('code');

        // Construction de la requête pour obtenir les utilisateurs
        $arUsers = User::query();

        // Filtrage par nom
        if (!empty($strName)) {
            $arUsers->where('name', 'LIKE', '%' . $strName . '%');
        }

        // Filtrage par visibilité
        if (!is_null($visibilite)) {
            $arUsers->where('visibilite', $visibilite);
        }

        // Filtrage par code
        if (!empty($code)) {
            $arUsers->where('code', $code);
        }

        // Tri
        if (!empty($strOrder) && !empty($strDirection)) {
            $arUsers->orderBy($strOrder, $strDirection);
        }

        // Récupération des utilisateurs avec les filtres appliqués
        $arUsers = $arUsers->get();

        return view('pages/liste_utilisateurs', compact('arUsers', 'strName', 'strOrder', 'strDirection', 'visibilite', 'code'));
    }

    public function edit_utilisateur($id)
    {
        // Récupérer l'utilisateur par son ID
        $user = User::findOrFail($id);

        // Passer les données à la vue
        return view('pages/edit_utilisateur', compact('user'));
    }

    public function update_utilisateur(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'code' => 'required|in:A,V,U', // Le code peut être A, V, ou U
            'can_contribute' => 'required|boolean', // can_contribute doit être un booléen
        ]);

        // Récupérer l'utilisateur par son ID
        $user = User::findOrFail($id);

        // Mettre à jour les informations
        $user->update([
            'code' => $request->input('code'),
            'can_contribute' => $request->input('can_contribute'),
        ]);

        // Message et redirection
        $strMessage = "Les informations de l'utilisateur ont bien été mises à jour.";
        $strLink = "/liste_utilisateurs"; // Redirection vers la liste des utilisateurs
        $strLinkMessage = "Retour à la liste des utilisateurs";

        return view('pages/message', compact("strMessage", "strLink", "strLinkMessage"));
    }

}
