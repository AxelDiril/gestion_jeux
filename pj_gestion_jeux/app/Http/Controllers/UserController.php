<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CollectionGame;
use App\Models\CollectionSupport;

class UserController extends Controller
{
    public function show_profile(Request $request){

        // Récupération des filtres avec Request
        $iId = $request->query('id');

        $objUser = User::query()->where('id',$iId)->first();

        $arLatestGames = CollectionGame::query()->where('id',$iId)->orderBy('added_at')->limit(5)->get();
        $arLatestSupports = CollectionSupport::query()->where('id',$iId)->orderBy('added_at')->limit(5)->get();
        $iTotalGames = CollectionGame::query()->where('id',$iId)->distinct('game_id')->count('game_id');
        $iTotalSupports = CollectionSUpport::query()->where('id',$iId)->distinct('support_id')->count('support_id');

        return view('pages/profil', compact('objUser', 'iTotalGames', 'iTotalSupports', 'arLatestGames', 'arLatestSupports'));
    }
}
