<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Genre
 * 
 * @property int $genre_id
 * @property string $genre_label
 * 
 * @property Collection|Game[] $games
 *
 * @package App\Models
 */
class Genre extends Model
{
	//protected $table = 'GJ_genres';
	protected $primaryKey = 'genre_id';
	public $timestamps = false;

	protected $fillable = [
		'genre_label'
	];

	public function games()
	{
		return $this->belongsToMany(Game::class, 'GJ_game_genres');
	}
}
