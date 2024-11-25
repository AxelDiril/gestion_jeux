<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Game
 * 
 * @property int $game_id
 * @property string $game_name
 * @property string $game_desc
 * @property Carbon $game_year
 * @property string $game_cover
 * @property int $owned_by
 * @property int|null $rating
 * @property int $support_id
 * 
 * @property Support $support
 * @property Collection|CollectionGame[] $collection_games
 * @property Collection|Genre[] $genres
 *
 * @package App\Models
 */
class Game extends Model
{
	//protected $table = 'GJ_games';
	protected $primaryKey = 'game_id';
	public $timestamps = false;

	protected $casts = [
		'game_year' => 'string',
		'owned_by' => 'int',
		'rating' => 'int',
		'support_id' => 'int'
	];

	protected $fillable = [
		'game_name',
		'game_desc',
		'game_year',
		'game_cover',
		'owned_by',
		'rating',
		'support_id'
	];

    public function support()
    {
        return $this->belongsTo(Support::class, 'support_id');
    }

	public function collection_games()
	{
		return $this->hasMany(CollectionGame::class);
	}

	public function genres()
	{
		return $this->belongsToMany(Genre::class, 'GJ_game_genres');
	}
}
