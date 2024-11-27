<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Game;
use App\Models\CollectionGame;

class CollectionGameController extends Controller
{
    public function add_to_collection(Request $request){

        $iGameId = $request->query("game_id");

        $objUser = Auth::user();

        $objGameUserExists = CollectionGame::query()->where('id',$iGameId)->where('game_id',$objUser->id)->exists();

        if($objGameUserExists){
            $strMessage = "Ce jeu a déjà été ajouté à votre collection";
        }
        else{
            DB::table('collection_games')->insert([
                'id' => $objUser->id,
                'game_id' => $iGameId
            ]);
            $strMessage = "Ce jeu a bien été ajouté à votre collection.";
        }

        $strLink = "/liste_jeux";
        $strLinkMessage = "Retour à la liste des jeux";

        return view('pages/message',compact("iGameId","strMessage","strLink","strLinkMessage"));
    }
}
