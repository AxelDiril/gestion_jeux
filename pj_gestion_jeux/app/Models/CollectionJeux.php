<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CollectionJeux
 * 
 * @property int $id_GJ_JEUX
 * @property int $id_GJ_USERS
 * @property float $note
 * @property string $commentaire
 * @property int $id
 * 
 * @property Jeux $jeux
 * @property Progression $progression
 * @property User $user
 *
 * @package App\Models
 */
class CollectionJeux extends Model
{
	protected $table = 'GJ_collection_jeux';
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

	public function jeux()
	{
		return $this->belongsTo(Jeux::class, 'id_GJ_JEUX');
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
