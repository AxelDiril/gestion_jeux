<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CollectionGame
 * 
 * @property int $id_GJ_JEUX
 * @property int $id_GJ_USERS
 * @property float|null $note
 * @property string|null $commentaire
 * @property int $id
 * 
 * @property Game $game
 * @property Progression $progression
 * @property User $user
 *
 * @package App\Models
 */
class CollectionGame extends Model
{
	protected $table = 'GJ_collection_games';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_GJ_JEUX' => 'int',
		'id_GJ_USERS' => 'int',
		'note' => 'float',
		'id' => 'int'
	];

	protected $fillable = [
		'note',
		'commentaire',
		'id'
	];

	public function game()
	{
		return $this->belongsTo(Game::class, 'id_GJ_JEUX');
	}

	public function progression()
	{
		return $this->belongsTo(Progression::class, 'id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'id_GJ_USERS');
	}
}
