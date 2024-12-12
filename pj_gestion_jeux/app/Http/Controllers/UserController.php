<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CollectionGame;
use App\Models\CollectionSupport;
use Illuminate\Support\Facades\Auth;

/**
 * Contrôleur pour la gestion des utilisateurs.
 * Permet d'afficher les profils, de gérer les utilisateurs, et de mettre à jour les informations des utilisateurs.
 */
class UserController extends Controller
{
    /**
     * Affiche le profil d'un utilisateur.
     *
     * Cette méthode récupère toutes les informations nécessaires pour afficher le profil d'un utilisateur,
     * en vérifiant si le profil est privé ou accessible en fonction de l'utilisateur connecté.
     *
     * @param  int  $id L'ID de l'utilisateur à afficher.
     * @return \Illuminate\View\View La vue du profil de l'utilisateur.
     */
    public function profil($id)
    {
        // Récupération de l'utilisateur
        $objUser = User::find($id);
        $objAuthUser = Auth::user();

        // Vérifier la visibilité du profil
        if ($objUser->visibilite == false) {
            // Accès interdit sauf pour l'utilisateur lui-même ou un administrateur
            if ($objAuthUser == false || $objAuthUser->id != $id || $objAuthUser->code != "A") {
                return redirect('/');
            }
        }

        // Statistiques du profil
        $arLatestGames = CollectionGame::where('id', $id)->orderBy('added_at')->limit(5)->get();
        $arLatestSupports = CollectionSupport::where('id', $id)->orderBy('added_at')->limit(5)->get();
        $iTotalGames = CollectionGame::where('id', $id)->distinct('game_id')->count('game_id');
        $iTotalSupports = CollectionSupport::where('id', $id)->distinct('support_id')->count('support_id');

        return view('pages/profil', compact('objUser', 'iTotalGames', 'iTotalSupports', 'arLatestGames', 'arLatestSupports'));
    }

    /**
     * Affiche la liste des utilisateurs pour l'administrateur.
     *
     * Cette méthode permet à un administrateur de filtrer et de visualiser tous les utilisateurs avec leurs informations.
     * Les utilisateurs sont filtrés selon les critères passés dans la requête.
     *
     * @param  \Illuminate\Http\Request  $request Les paramètres de la requête HTTP pour les filtres.
     * @return \Illuminate\View\View La vue affichant la liste des utilisateurs.
     */
    public function liste_utilisateurs_admin(Request $request)
    {
        // Vérification des autorisations (seuls les validateurs ou administrateurs peuvent accéder à cette page)
        $objUser = Auth::user();
        if ($objUser == false || $objUser->code == "U") {
            return redirect('/');
        }

        // Récupérer les filtres passés dans $request
        $strName = $request->query('name');
        $strOrder = $request->query('order');
        $strDirection = $request->query('direction');
        $visibilite = $request->query('visibilite');
        $code = $request->query('code');

        // Construction de la requête avec les filtres
        $arUsers = User::query();

        if (!empty($strName)) {
            $arUsers->where('name', 'LIKE', '%' . $strName . '%');
        }

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

    /**
     * Affiche la liste des utilisateurs publics.
     *
     * Cette méthode permet d'afficher une liste d'utilisateurs ayant un profil public,
     * avec des options de filtrage par nom, ordre, et direction de tri.
     *
     * @param  \Illuminate\Http\Request  $request Les paramètres de la requête HTTP pour les filtres.
     * @return \Illuminate\View\View La vue affichant la liste des utilisateurs publics.
     */
    public function liste_utilisateurs(Request $request)
    {
        // Récupérer les filtres passés dans $request
        $strName = $request->query('name');
        $strOrder = $request->query('order');
        $strDirection = $request->query('direction');

        // Construction de la requête
        $arUsers = User::query()->where('visibilite', 1); // Seulement les utilisateurs publics

        if (!empty($strName)) {
            $arUsers->where('name', 'LIKE', '%' . $strName . '%');
        }

        if (!empty($strOrder) && !empty($strDirection)) {
            $arUsers->orderBy($strOrder, $strDirection);
        }

        $arUsers = $arUsers->get();

        return view('pages/liste_utilisateurs', compact('arUsers', 'strName', 'strOrder', 'strDirection'));
    }

    /**
     * Affiche le formulaire de modification d'un utilisateur.
     *
     * Cette méthode permet de pré-remplir les informations d'un utilisateur pour modification,
     * en particulier pour changer son rôle ou ses droits d'accès.
     *
     * @param  int  $id L'ID de l'utilisateur à modifier.
     * @return \Illuminate\View\View La vue pour éditer un utilisateur.
     */
    public function edit_utilisateur($id)
    {
        // Récupérer l'utilisateur par son ID
        $objUser = User::find($id);

        return view('pages/edit_utilisateur', compact('objUser'));
    }

    /**
     * Met à jour les informations d'un utilisateur.
     *
     * Cette méthode permet de mettre à jour le rôle et les droits de contribution d'un utilisateur
     * via les données envoyées par le formulaire d'édition.
     *
     * @param  \Illuminate\Http\Request  $request Les données du formulaire de modification.
     * @param  int  $id L'ID de l'utilisateur à mettre à jour.
     * @return \Illuminate\View\View La vue de confirmation de mise à jour.
     */
    public function update_utilisateur(Request $request, $id)
    {
        // Récupérer l'utilisateur
        $objUser = User::find($id);

        // Mettre à jour les informations
        $objUser->update([
            'code' => $request->input('code'),
            'can_contribute' => $request->input('can_contribute'),
        ]);

        // Message de confirmation
        $strMessage = "Les informations de l'utilisateur ont bien été mises à jour.";
        $strLink = "/liste_utilisateurs_admin"; // Redirection vers la liste des utilisateurs
        $strLinkMessage = "Retour à la liste des utilisateurs";

        return view('pages/message', compact("strMessage", "strLink", "strLinkMessage"));
    }

    /**
     * Change la visibilité du profil d'un utilisateur.
     *
     * Cette méthode permet à l'utilisateur de rendre son profil public ou privé
     * en inversant la valeur du champ `visibilite`.
     *
     * @param  int  $id L'ID de l'utilisateur dont la visibilité est à changer.
     * @return \Illuminate\View\View La vue de confirmation de changement de visibilité.
     */
    public function change_visibilite($id)
    {
        $objUser = User::where('id', $id)->first();

        // Changer la visibilité
        $objUser->visibilite = !$objUser->visibilite;
        $objUser->save();

        // Message de confirmation
        $strMessage = "La visibilité de votre profil a bien été mise à jour.";
        $strLink = "/profil/{$id}";
        $strLinkMessage = "Retour à votre profil";

        return view('/pages/message', compact('strMessage', 'strLink', 'strLinkMessage'));
    }

    /**
     * Supprime un utilisateur.
     *
     * Cette méthode permet à un administrateur de supprimer un utilisateur du système.
     * L'utilisateur ne peut être supprimé que par un administrateur.
     *
     * @param  int  $id L'ID de l'utilisateur à supprimer.
     * @return \Illuminate\View\View La vue de confirmation de suppression.
     */
    public function delete_utilisateur($id)
    {
        // Vérifier si l'utilisateur est administrateur
        $objAuthUser = Auth::user();
        if ($objAuthUser == false || $objAuthUser->code != 'A') {
            return redirect('/');
        }

        // Récupérer l'utilisateur
        $objUser = User::find($id);

        // Vérifier si l'utilisateur existe
        if (!$objUser) {
            $strMessage = "Cet utilisateur n'existe pas.";
            $strLink = "/liste_utilisateurs_admin";
            $strLinkMessage = "Retour à la liste des utilisateurs";
        } else {
            // Supprimer l'utilisateur
            $objUser->delete();
            $strMessage = "L'utilisateur a bien été supprimé.";
            $strLink = "/liste_utilisateurs_admin";
            $strLinkMessage = "Retour à la liste des utilisateurs";
        }

        return view('pages/message', compact("strMessage", "strLink", "strLinkMessage"));
    }
}
