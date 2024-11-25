<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Support;

class SupportController extends Controller
{
    public function liste_supports(Request $request){

        $strSupportName = $request->query('support_name');
        $iSupportYear = $request->query('support_year');
        $strOrder = $request->query('order');
        $strDirection = $request->query('direction');

        // Construction de la requête pour l'appel des jeux
        $arSupports = Support::query();

        // Ordonner la requête
        if(!empty($strOrder) && !empty($strDirection)){
            $arSupports = $arSupports->orderBy($strOrder,$strDirection);
        }

        // Filtres
        if(!empty($strSupportName) && $strSupportName != "all"){
            $arSupports->where('support_name','LIKE','%'.$strSupportName.'%');
        }

        if(!empty($iSupportYear) && $iSupportYear != "all"){
            $arSupports->whereYear('support_year',$iSupportYear);
        }

        $arSupports = $arSupports->get();
        $arYears = Support::select('support_year')->distinct()->orderBy('support_year','desc')->get();

        // Envoie les jeux, les supports et all les années
        return view('pages/liste_supports', compact('arSupports', 'arYears', 'strSupportName', 'iSupportYear'));
    }

    public function detail_support(Request $request)
    {
        $iSupportId = $request->query('support_id');

        $objSupport = Support::query();

        if (!empty($iSupportId)) {
            $objSupport->where('support_id', $iSupportId);
        }

        $objSupport = $objSupport->first();

        return view('pages/detail_support', compact('objSupport', 'iSupportId'));
    }

}
