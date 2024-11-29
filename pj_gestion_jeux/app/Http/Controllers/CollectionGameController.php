<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Game;
use App\Models\Support;
use App\Models\Genre;
use App\Models\Progression;
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

    public function collection_jeux(Request $request){

        // Récupération des filtres avec Request
        $iId = $request->query('id');
        $iSupportId = $request->query('support_id');
        $iGameYear = $request->query('game_year');
        $strOrder = $request->query('order');
        $strDirection = $request->query('direction');
        $strGameName = $request->query('game_name');
        $iGenreId = $request->query('genre_id');

        // Construction de la requête pour l'appel des jeux
        $arCollectionGames = CollectionGame::query()
        ->join('games', 'collection_games.game_id', '=', 'games.game_id')
        ->where('id',$iId);

        // Jointure avec GJ_appartient_genres
        $arCollectionGames = $arCollectionGames->join('game_genres',"games.game_id", "=", "game_genres.game_id");

        // Ordonner la requête
        if(!empty($strOrder) && !empty($strDirection)){
            $arCollectionGames = $arCollectionGames->orderBy('games'.$strOrder,$strDirection);
        }

        // Filtres
        if(!empty($strGameName) && $strGameName != "all"){
            $arCollectionGames->where('games.game_name','LIKE','%'.$strGameName.'%');
        }

        if(!empty($iSupportId) && $iSupportId != "all"){
            $arCollectionGames->where('support_id',$iSupportId);
        }

        if(!empty($iGenreId) && $iGenreId != "all"){
            $arCollectionGames->where('genre_id',$iGenreId);
        }

        if(!empty($iGameYear) && $iGameYear != "all"){
            $arCollectionGames->whereYear('game_year',$iGameYear);
        }

        $arCollectionGames = $arCollectionGames->distinct('game_id')->get();
        $arSupports = Support::orderBy('support_name','asc')->get();
        $arGenres = Genre::orderBy('genre_label','asc')->get();
        $arYears = Game::select('game_year')->distinct()->orderBy('game_year','desc')->get();

        // Envoie les jeux, les supports et all les années
        return view('pages/profil_collection_jeux', compact('arCollectionGames', 'arSupports', 'arYears', "arGenres", 'strGameName', 'iSupportId', 'iGameYear', 'iGenreId', 'iId'));
    }

    public function edit_collection_jeu(Request $request){
        $iGameId = $request->query("game_id");
        $iId = $request->query("id");

        $objCollectionGame = CollectionGame::query()
        ->where('id',$iId)
        ->where('game_id',$iGameId)
        ->first();

        $arProgress = Progression::all();

        return view('pages/edit_collection_jeu',compact('objCollectionGame','arProgress'));
    }

    public function update_collection_jeu(Request $request)
    {
        $iGameId = $request->query("game_id");
        $iId = $request->query("id");
    
        // Log the query parameters
        logger()->info('Updating collection game', ['game_id' => $iGameId, 'id' => $iId]);
    
        // Fetch the record
        $objCollectionGame = CollectionGame::query()
            ->where('id', $iId)
            ->where('game_id', $iGameId)
            ->first();
    
        // Log if the record is found or not
        if (!$objCollectionGame) {
            logger()->error('Collection game not found', ['id' => $iId, 'game_id' => $iGameId]);
            return redirect()->back()->withErrors('Record not found');
        }
    
        logger()->info('Fetched record:', $objCollectionGame->toArray());
    
        // Update fields
        $objCollectionGame->note = $request->input('note');
        $objCollectionGame->progress_id = $request->input('progress');
        $objCollectionGame->comment = $request->input('comment');
        $objCollectionGame->save();
    
        logger()->info('Updated collection game:', $objCollectionGame->toArray());
    
        // Return success message
        $strMessage = "Ce jeu a bien été modifié.";
        $strLink = "/profil_collection_jeux?id=" . $iId;
        $strLinkMessage = "Retour à votre collection de jeux";
    
        return view('pages/message', compact('strLink', 'strLinkMessage', 'strMessage'));
    }
}
