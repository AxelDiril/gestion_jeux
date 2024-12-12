<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Support;
use App\Models\CollectionSupport;

/**
 * Contrôleur pour la gestion des supports.
 * Permet d'afficher la liste des supports, les détails d'un support, et de gérer les filtres.
 */
class SupportController extends Controller
{
    /**
     * Récupère et affiche la liste des supports avec les filtres.
     *
     * Cette méthode permet de filtrer les supports selon les critères fournis dans la requête,
     * tels que le nom du support, l'année de sortie, et l'ordre de tri.
     * Elle renvoie également la liste des supports sous forme de vue.
     *
     * @param  \Illuminate\Http\Request  $request Les paramètres de la requête HTTP.
     * @return \Illuminate\View\View La vue affichant la liste des supports filtrée.
     */
    public function liste_supports(Request $request)
    {
        // Récupérer les filtres
        $strSupportName = $request->query('support_name');
        $iSupportYear = $request->query('support_year');
        $strOrder = $request->query('order');
        $strDirection = $request->query('direction');

        // Construction de la requête
        $arSupports = Support::query();

        // Ordonner les supports
        if (!empty($strOrder) && !empty($strDirection)) {
            $arSupports = $arSupports->orderBy($strOrder, $strDirection);
        }

        // Filtres optionnels : les conditions s'additionnent si plusieurs filtres sont choisis
        if (!empty($strSupportName) && $strSupportName != "all") {
            $arSupports->where('support_name', 'LIKE', '%' . $strSupportName . '%');
        }

        if (!empty($iSupportYear) && $iSupportYear != "all") {
            $arSupports->where('support_year', $iSupportYear);
        }

        $arSupports = $arSupports->get();

        // Récupérer les années pour les filtres
        $arYears = Support::select('support_year')->orderBy('support_year', 'desc')->get();

        return view('pages/liste_supports', compact('arSupports', 'arYears', 'strSupportName', 'iSupportYear'));
    }

    /**
     * Récupère et affiche les détails d'un support sélectionné.
     *
     * Cette méthode récupère toutes les informations d'un support à partir de son `support_id`.
     * Elle vérifie également si l'utilisateur connecté possède déjà ce support dans sa collection.
     *
     * @param  int  $support_id L'ID du support à afficher.
     * @return \Illuminate\View\View La vue affichant les détails du support.
     */
    public function detail_support($support_id)
    {
        $bOwned = false;

        // Requête pour l'appel du support à détailler
        $objSupport = Support::find($support_id);

        // Vérifier si l'utilisateur connecté a déjà le support ou non
        $objUser = Auth::user();
        if ($objUser) {
            // Récupérer le couple support-utilisateur à vérifier
            $objCollectionSupport = CollectionSupport::where('support_id', $support_id)
                ->where('id', $objUser->id)
                ->first();
            if ($objCollectionSupport) {
                $bOwned = true;
            }
        }

        return view('pages/detail_support', compact('objSupport', 'objUser', 'bOwned'));
    }
}
