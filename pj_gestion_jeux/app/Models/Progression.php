<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Progression
 * 
 * @property int $id
 * @property string $libelle
 * 
 * @property Collection|CollectionGame[] $collection_games
 *
 * @package App\Models
 */
class Progression extends Model
{
	protected $table = 'GJ_progression';
	public $timestamps = false;

	protected $fillable = [
		'libelle'
	];

	public function collection_games()
	{
		return $this->hasMany(CollectionGame::class, 'id');
	}
}
