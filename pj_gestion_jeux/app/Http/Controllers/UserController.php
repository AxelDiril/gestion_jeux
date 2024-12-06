<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CollectionGame;
use App\Models\CollectionSupport;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Récupère toutes les informations à afficher sur le profil
    // De l'utilisateur envoyé en paramètre
    public function profil($id){

        // Récupération de l'id de l'utilisateur passé en paramètres

        $objUser = User::find($id);
        $objAuthUser = Auth::user();

        // Ne pas accéder au profil si il a une visibilité privée
        if ($objUser->visibilite == false) {
            // Sauf si c'est l'utilisateur lui-même ou un administrateur
            if ($objAuthUser == false || $objAuthUser->id !=  $id || $objAuthUser->code != "A") {
                // Rediriger l'utilisateur vers l'accueil
                return redirect('/');
            }
        }

        // Statistiques du profil
        // Les cinq derniers jeux et supports ajoutés dans la collection
        $arLatestGames = CollectionGame::query()->where('id',$id)->orderBy('added_at')->limit(5)->get();
        $arLatestSupports = CollectionSupport::query()->where('id',$id)->orderBy('added_at')->limit(5)->get();
        
        // Total des jeux et supports possédés
        $iTotalGames = CollectionGame::query()->where('id',$id)->distinct('game_id')->count('game_id');
        $iTotalSupports = CollectionSUpport::query()->where('id',$id)->distinct('support_id')->count('support_id');

        return view('pages/profil', compact('objUser', 'iTotalGames', 'iTotalSupports', 'arLatestGames', 'arLatestSupports'));
    }

    // Retourne la liste de tous les utilisateurs et leurs informations
    // Les utilisateurs qui seront affichés dépendent des filtres saisis par l'utilisateur dans $request
    public function liste_utilisateurs_admin(Request $request)
    {
        // Réserver l'accès aux validateurs et à l'administrateur (role_code V ou A)
        $objUser = Auth::user();

        if ($objUser == false || $objUser->code == "U") {
            // Rediriger l'utilisateur vers l'accueil
            return redirect('/');
        }

        // Récupérer les filtres passés dans $request
        $strName = $request->query('name');
        $strOrder = $request->query('order');
        $strDirection = $request->query('direction');
        $visibilite = $request->query('visibilite');
        $code = $request->query('code');

        // Construction de la requête
        $arUsers = User::query();

        // Filtres
        if (!empty($strName)) {
            $arUsers->where('name', 'LIKE', '%' . $strName . '%');
        }

        // Filtres optionnels : les conditions s'additionnent si plusieurs filtres sont choisis
        if (!is_null($visibilite)) {
            $arUsers->where('visibilite', $visibilite);
        }

        if (!empty($code)) {
            $arUsers->where('code', $code);
        }

        if (!empty($strOrder) && !empty($strDirection)) {
            $arUsers->orderBy($strOrder, $strDirection);
        }

        $arUsers = $arUsers->get();

        return view('pages/liste_utilisateurs_admin', compact('arUsers', 'strName', 'strOrder', 'strDirection', 'visibilite', 'code'));
    }

    // Retourne la liste de tous les utilisateurs et leurs informations
    // Les utilisateurs qui seront affichés dépendent des filtres saisis par l'utilisateur dans $request
    public function liste_utilisateurs(Request $request)
    {
        // Récupérer les filtres passés dans $request
        $strName = $request->query('name');
        $strOrder = $request->query('order');
        $strDirection = $request->query('direction');

        // Construction de la requête
        $arUsers = User::query()
        ->where('visibilite','1');

        // Filtres
        if (!empty($strName)) {
            $arUsers->where('name', 'LIKE', '%' . $strName . '%');
        }

        if (!empty($strOrder) && !empty($strDirection)) {
            $arUsers->orderBy($strOrder, $strDirection);
        }

        $arUsers = $arUsers->get();

        return view('pages/liste_utilisateurs', compact('arUsers', 'strName', 'strOrder', 'strDirection'));
    }

    // Retourne la vue edit_utilisateur qui permet de changer le rôle
    // Et le droit de faire des requête de l'utilisateur passé en paramètres
    public function edit_utilisateur($id)
    {
        // Récupérer l'utilisateur par son ID
        $objUser = User::find($id);

        return view('pages/edit_utilisateur', compact('objUser'));
    }

    // Met à jour le rôle et le droit de contribuer de l'utilisateur
    // Passé en paramètress
    public function update_utilisateur(Request $request, $id)
    {
        // Récupérer l'utilisateur par son ID
        $objUser = User::find($id);

        // Mettre à jour les informations
        $objUser->update([
            'code' => $request->input('code'),
            'can_contribute' => $request->input('can_contribute'),
        ]);

        // Message personnalisé pour la vue message
        $strMessage = "Les informations de l'utilisateur ont bien été mises à jour.";
        $strLink = "/liste_utilisateurs_admin"; // Redirection vers la liste des utilisateurs
        $strLinkMessage = "Retour à la liste des utilisateurs";

        return view('pages/message', compact("strMessage", "strLink", "strLinkMessage"));
    }

    // Met à jour la visibilité du profil de l'utilisateur
    public function change_visibilite($id){
        $objUser = User::where('id', $id)->first();

        if($objUser->visibilite == 0){
            $objUser->visibilite = 1;
        }
        else{
            $objUser->visibilite = 0;
        }
        $objUser->save();
        
        // Message personnalisé pour la vue message
        $strMessage = "La visibilité de votre profil a bien été mise à jour.";
        $strLink = "/profil/{$id}"; // Redirection vers le profil de l'utilisateur
        $strLinkMessage = "Retour à votre profil";

        return view('/pages/message',compact('strMessage','strLink','strLinkMessage'));
    }

    // Supprime un utilisateur passé en paramètre
    public function delete_utilisateur($id)
    {
        // Vérifier si l'utilisateur est administrateur
        $objAuthUser = Auth::user();
        if ($objAuthUser == false || $objAuthUser->code != 'A') {
            // Rediriger vers l'accueil si l'utilisateur n'est pas administrateur
            return redirect('/');
        }

        // Récupérer l'utilisateur par son ID
        $objUser = User::find($id);

        // Vérifier si l'utilisateur existe
        if (!$objUser) {
            $strMessage = "Cet utilisateur n'existe pas.";
            $strLink = "/liste_utilisateurs_admin"; // Redirection vers le profil de l'utilisateur
            $strLinkMessage = "Retour à la liste des utilisateurs";
        }
        else{
            // Supprimer l'utilisateur
            $objUser->delete();

            // Message personnalisé pour la vue message
            $strMessage = "L'utilisateur a bien été supprimé.";
            $strLink = "/liste_utilisateurs_admin"; // Redirection vers la liste des utilisateurs
            $strLinkMessage = "Retour à la liste des utilisateurs";
        }

        return view('pages/message', compact("strMessage", "strLink", "strLinkMessage"));
    }

}
