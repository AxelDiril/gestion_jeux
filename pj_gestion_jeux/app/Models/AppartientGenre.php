<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AppartientGenre
 * 
 * @property int $id
 * @property int $id_GJ_GENRES
 * 
 * @property Genre $genre
 * @property Game $game
 *
 * @package App\Models
 */
class AppartientGenre extends Model
{
	protected $table = 'GJ_appartient_genres';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'id_GJ_GENRES' => 'int'
	];

	public function genre()
	{
		return $this->belongsTo(Genre::class, 'id_GJ_GENRES');
	}

	public function game()
	{
		return $this->belongsTo(Game::class, 'id');
	}
}
