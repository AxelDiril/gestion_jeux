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
}
