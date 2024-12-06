<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Support;
use App\Models\CollectionSupport;

class SupportController extends Controller
{
    // Récupère tous les jeux de GJ_supports
    // Mes supports qui seront affichés dépendent des filtres saisis par l'utilisateur dans $request
    public function liste_supports(Request $request)
    {
        // Récupérer les filtres
        $strSupportName = $request->query('support_name');
        $iSupportYear = $request->query('support_year');
        $strOrder = $request->query('order');
        $strDirection = $request->query('direction');

        // Construction de la requête
        $arSupports = Support::query();

        // Ordonner des supports
        if(!empty($strOrder) && !empty($strDirection)){
            $arSupports = $arSupports->orderBy($strOrder,$strDirection);
        }

        // Filtres optionnels : les conditions s'additionnent si plusieurs filtres sont choisis
        if(!empty($strSupportName) && $strSupportName != "all"){
            $arSupports->where('support_name','LIKE','%'.$strSupportName.'%');
        }

        if(!empty($iSupportYear) && $iSupportYear != "all"){
            $arSupports->where('support_year',$iSupportYear);
        }

        $arSupports = $arSupports->get();

        // Récupérer les années pour les filtres
        $arYears = Support::select('support_year')->orderBy('support_year','desc')->get();

        return view('pages/liste_supports', compact('arSupports', 'arYears', 'strSupportName', 'iSupportYear'));
    }

    // Récupère toutes les informations d'un support choisi depuis liste_supports ou profil_collection_supports
    // A partir du support_id passé en paramètres
    public function detail_support($support_id)
    {
        $bOwned = false;

        // Requête pour l'appel du support à détailler
        $objSupport = Support::find($support_id);

        // Vérifier si l'utilisateur connecté a déjà le jeu ou non
        $objUser = Auth::user();
        if($objUser){
            // Récupérer le couple jeu-utilisateur à vérifier
            $objCollectionSupport = CollectionSupport::where('support_id', $support_id)
                ->where('id', $objUser->id)
                ->first();
            if($objCollectionSupport){
                $bOwned = true;
            }
        }

        return view('pages/detail_support', compact('objSupport','objUser','bOwned'));
    }

}
