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
 * @property int $id
 * @property string $label
 * 
 * @property Collection|AppartientGenre[] $appartient_genres
 *
 * @package App\Models
 */
class Genre extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'label'
	];

	public function appartient_genres()
	{
		return $this->hasMany(AppartientGenre::class, 'id_GJ_GENRES');
	}
}
