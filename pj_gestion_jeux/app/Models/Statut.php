<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Statut
 * 
 * @property int $id
 * @property string $label
 * 
 * @property Collection|Requete[] $requetes
 *
 * @package App\Models
 */
class Statut extends Model
{
	protected $table = 'GJ_statuts';
	public $timestamps = false;

	protected $fillable = [
		'label'
	];

	public function requetes()
	{
		return $this->hasMany(Requete::class, 'id_GJ_STATUT');
	}
}
