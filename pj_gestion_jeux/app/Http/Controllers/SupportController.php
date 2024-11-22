<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Support;

class SupportController extends Controller
{
    public function liste_supports(Request $request){

        $nom = $request->query('nom');
        $annee = $request->query('annee');
        $ordre = $request->query('ordre');
        $sens = $request->query('ordre_sens');

        // Construction de la requête pour l'appel des jeux
        $arSupports = Support::query();

        // Ordonner la requête
        if(!empty($ordre) && !empty($sens)){
            $arSupports = $arSupports->orderBy($ordre,$sens);
        }

        // Filtres
        if(!empty($nom) && $nom != "tous"){
            $arSupports->where('nom','LIKE','%'.$nom.'%');
        }

        if(!empty($annee) && $annee != "toutes"){
            $arSupports->whereYear('date_sortie',$annee);
        }

        $arSupports = $arSupports->get();
        $arAnnees = Support::select('date_sortie')->distinct()->orderBy('date_sortie','desc')->get();

        // Envoie les jeux, les supports et toutes les années
        return view('pages/liste_supports', compact('arSupports', 'arAnnees', 'nom', 'annee'));
    }
}
