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

}
