<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GameGenre
 * 
 * @property int $game_id
 * @property int $genre_id
 * 
 * @property Genre $genre
 * @property Game $game
 *
 * @package App\Models
 */
class GameGenre extends Model
{
	//protected $table = 'GJ_game_genres';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'game_id' => 'int',
		'genre_id' => 'int'
	];

	public function genre()
	{
		return $this->belongsTo(Genre::class);
	}

	public function game()
	{
		return $this->belongsTo(Game::class);
	}
}
