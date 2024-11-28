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
    public function add_to_collection(Request $request){

        $iSupportId = $request->query("support_id");

        $objUser = Auth::user();

        $objGameUserExists = CollectionSupport::query()->where('id',$iSupportId)->where('support_id',$objUser->id)->exists();

        if($objGameUserExists){
            $strMessage = "Ce support a déjà été ajouté à votre collection";
        }
        else{
            DB::table('collection_supports')->insert([
                'id' => $objUser->id,
                'support_id' => $iSupportId
            ]);
            $strMessage = "Ce support a bien été ajouté à votre collection.";
        }

        $strLink = "/liste_supports";
        $strLinkMessage = "Retour à la liste des supports";

        return view('pages/message',compact("iSupportId","strMessage","strLink","strLinkMessage"));
    }

    public function collection_supports(Request $request){

        // Récupération des filtres avec Request
        $iId = $request->query('id');
        $iSupportYear = $request->query('support_year');
        $strOrder = $request->query('order');
        $strDirection = $request->query('direction');
        $strSupportName = $request->query('game_name');

        // Construction de la requête pour l'appel des jeux
        $arCollectionSupports = CollectionSupport::query()
        ->join('supports',"supports.support_id","=","collection_supports.support_id")
        ->where('id',$iId);

        // Ordonner la requête
        if(!empty($strOrder) && !empty($strDirection)){
            $arCollectionSupports = $arCollectionSupports->orderBy($strOrder,$strDirection);
        }

        // Filtres
        if(!empty($strSupportName) && $strSupportName != "all"){
            $arCollectionSupports->where('support_name','LIKE','%'.$strSupportName.'%');
        }

        if(!empty($iSupportYear) && $iSupportYear != "all"){
            $arCollectionSupports->where('support_year',$iSupportYear);
        }

        $arCollectionSupports = $arCollectionSupports->get();
        $arYears = Support::select('support_year')->distinct()->orderBy('support_year','desc')->get();

        // Envoie les supports
        return view('pages/profil_collection_supports', compact('arCollectionSupports', 'arYears', 'iSupportYear','strSupportName',));
    }
}
