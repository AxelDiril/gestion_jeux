<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Support;
use App\Models\CollectionSupport;

class CollectionSupportController extends Controller
{
    // Ajoute un support dans la collection dont l'ID est envoyé en paramètres.
    // Vérifie d'abord si il n'est pas déjà dans la collection
    public function add_to_collection($support_id){

        $objUser = Auth::user();

        // Vérifie si le support est déjà dans la collection
        $objGameUserExists = CollectionSupport::query()->where('id',$objUser->id)->where('support_id',$support_id)->exists();

        if($objGameUserExists){
            $strMessage = "Ce support a déjà été ajouté à votre collection";
        }
        else{
            // Ajout du support
            DB::table('collection_supports')->insert([
                'id' => $objUser->id,
                'support_id' => $iSupportId
            ]);
            $strMessage = "Ce support a bien été ajouté à votre collection.";
        }

        // Message personnalisé
        $strLink = "/liste_supports";
        $strLinkMessage = "Retour à la liste des supports";

        return view('pages/message',compact("iSupportId","strMessage","strLink","strLinkMessage"));
    }

    // Récupère les supports de la collection de l'utilisateur pour les afficher dans profil_collection_supports
    // Les supports affichés dépendent des filtres saisis par l'utilisateur
    public function collection_supports(Request $request, $id){

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
        $iSupportYear = $request->query('support_year');
        $strOrder = $request->query('order');
        $strDirection = $request->query('direction');
        $strSupportName = $request->query('game_name');

        // Construction de la requête pour récupérer les supports de l'utilisateur
        // + Jointures avec GJ_supports pour récupérer leur noms et leurs années de sortie
        $arCollectionSupports = CollectionSupport::query()
        ->join('supports',"supports.support_id","=","collection_supports.support_id")
        ->where('id',$id);

        // Ordre des supports
        if(!empty($strOrder) && !empty($strDirection)){
            $arCollectionSupports = $arCollectionSupports->orderBy($strOrder,$strDirection);
        }

        // Filtres optionnels : les conditions s'additionnent si plusieurs filtres sont choisis
        if(!empty($strSupportName) && $strSupportName != "all"){
            $arCollectionSupports->where('support_name','LIKE','%'.$strSupportName.'%');
        }

        if(!empty($iSupportYear) && $iSupportYear != "all"){
            $arCollectionSupports->where('support_year',$iSupportYear);
        }

        $arCollectionSupports = $arCollectionSupports->get();
        
        // Récupérer les années pour les filtres
        $arYears = Support::select('support_year')->distinct()->orderBy('support_year','desc')->get();

        return view('pages/profil_collection_supports', compact('arCollectionSupports', 'arYears', 'iSupportYear','strSupportName','id'));
    }

    // Editer le commentaire d'un support dans edit_collection_support
    public function edit_collection_support($supportId, $id)
    {
        // Vérifier si le support existe dans la collection de l'utilisateur
        $objCollectionSupport = CollectionSupport::where('support_id', $supportId)
                                                ->where('id', $id)
                                                ->first();

        // Si le support n'existe pas dans la collection, rediriger avec un message d'erreur
        if (!$objCollectionSupport) {
            $strMessage = "Ce support n'est pas dans votre collection.";
            $strLink = "/profil_collection_supports/" . $id;  // Rediriger vers la page de collection des supports
            $strLinkMessage = "Retour à ma collection de supports";
            return view('pages/message', compact('strMessage', 'strLink', 'strLinkMessage'));
        }

        // Retourner la vue d'édition du commentaire
        return view('pages/edit_collection_support', compact('objCollectionSupport'));
    }

    // Mettre à jour le commentaire d'un support dans la collection
    public function update_collection_support(Request $request, $supportId, $id)
    {
        // Vérifier si le couple support-utilisateur existe
        $objCollectionSupport = CollectionSupport::where('support_id', $supportId)
                                                ->where('id', $id)
                                                ->first();

        // Si le couple support-utilisateur n'existe pas, rediriger avec un message d'erreur
        if (!$objCollectionSupport) {
            $strMessage = "Ce support n'existe pas dans votre collection.";
            $strLink = "/profil_collection_supports/{$id}";  // Lien vers la collection de l'utilisateur
            $strLinkMessage = "Retour à ma collection de supports";

            return view('pages.message', compact('strMessage', 'strLink', 'strLinkMessage'));
        }

        // Validation du commentaire
        $request->validate([
            'comment' => 'nullable|string|max:255',
        ]);

        // Mettre à jour le commentaire du support
        $objCollectionSupport->comment = $request->comment;
        $objCollectionSupport->save();

        // Variables pour la vue du message
        $strMessage = "Le commentaire du support a été mis à jour avec succès.";
        $strLink = "/profil_collection_supports/{$id}";  // Lien vers la collection de l'utilisateur
        $strLinkMessage = "Retour à ma collection de supports";

        return view('pages.message', compact('strMessage', 'strLink', 'strLinkMessage'));
    }


}
