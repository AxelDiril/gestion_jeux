<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Support;
use App\Models\Genre;

class GameController extends Controller
{
    public function liste_jeux(Request $request){

        $support = $request->query('support');
        $annee = $request->query('annee');

        // Construction de la requête pour l'appel des jeux
        $arGames = Game::query();

        if(!empty($support) && $support != "tous"){
            $arGames->where('id_GJ_SUPPORTS',$support);
        }

        if(!empty($annee) && $annee != "toutes"){
            $arGames->whereYear('date_sortie',$annee);
        }

        $arGames = $arGames->get();
        $arSupports = Support::orderBy('nom','asc')->get();
        $arAnnees = Game::select('date_sortie')->distinct()->orderBy('date_sortie','desc')->get();


        // Envoie les jeux, les supports et toutes les années
        return view('pages/liste_jeux', compact('arGames', 'arSupports', 'arAnnees'));
    }
}
