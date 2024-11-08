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
 * @property Collection|CollectionJeux[] $collection_jeuxes
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

	public function collection_jeuxes()
	{
		return $this->hasMany(CollectionJeux::class, 'id');
	}
}
