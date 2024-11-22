<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Support;
use App\Models\Genre;
use App\Models\AppartientGenre;

class GameController extends Controller
{
    public function liste_jeux(Request $request){

        $support = $request->query('support');
        $annee = $request->query('annee');
        $ordre = $request->query('ordre');
        $sens = $request->query('ordre_sens');
        $nom = $request->query('nom');
        $genre = $request->query('genre');

        // Construction de la requête pour l'appel des jeux
        $arGames = Game::query();

        // Jointure avec GJ_appartient_genres
        $arGames = $arGames->join('appartient_genres',"games.id", "=", "appartient_genres.id");

        // Ordonner la requête
        if(!empty($ordre) && !empty($sens)){
            $arGames = $arGames->orderBy($ordre,$sens);
        }

        // Filtres
        if(!empty($nom) && $nom != "tous"){
            $arGames->where('titre','LIKE','%'.$nom.'%');
        }

        if(!empty($support) && $support != "tous"){
            $arGames->where('id_GJ_SUPPORTS',$support);
        }

        if(!empty($genre) && $genre != "tous"){
            $arGames->where('id_GJ_Genres',$genre);
        }

        if(!empty($annee) && $annee != "toutes"){
            $arGames->whereYear('date_sortie',$annee);
        }

        $arGames = $arGames->get();
        $arSupports = Support::orderBy('nom','asc')->get();
        $arGenres = Genre::orderBy('label','asc')->get();
        $arAnnees = Game::select('date_sortie')->distinct()->orderBy('date_sortie','desc')->get();

        // Envoie les jeux, les supports et toutes les années
        return view('pages/liste_jeux', compact('arGames', 'arSupports', 'arAnnees', "arGenres", 'nom', 'support', 'annee', 'genre'));
    }

    public function detail_jeu(Request $request){

        $id = $request->query('id');

        // Construction de la requête pour l'appel des jeux
        $arGames = Game::query();

        // Filtres
        if(!empty($id)){
            $arGames->where('id',$id);
        }

        $arGames = $arGames->get();

        // Envoie le jeu
        return view('pages/detail_jeu', compact('arGames', 'id'));
    }
}
