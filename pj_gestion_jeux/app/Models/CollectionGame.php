<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CollectionGame
 * 
 * @property int $game_id
 * @property int $id
 * @property float|null $note
 * @property string|null $comment
 * @property int $progress_id
 * 
 * @property Game $game
 * @property Progression $progression
 * @property User $user
 *
 * @package App\Models
 */
class CollectionGame extends Model
{
	//protected $table = 'GJ_collection_games';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'game_id' => 'int',
		'id' => 'int',
		'note' => 'float',
		'progress_id' => 'int',
		'added_at' => 'timestamp'
	];

	protected $fillable = [
		'note',
		'comment',
		'progress_id'
	];

	public function game()
	{
		return $this->belongsTo(Game::class, 'game_id');
	}

	public function progression()
	{
		return $this->belongsTo(Progression::class, 'progress_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'id');
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
        return view('pages/profil_collection_jeux', compact('arCollectionGames', 'arSupports', 'arYears', "arGenres", 'strGameName', 'iSupportId', 'iGameYear', 'iGenreId'));
    }
}
