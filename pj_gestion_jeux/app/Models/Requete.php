<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Requete
 * 
 * @property int $id
 * @property string|null $motif
 * @property string $titre
 * @property string $description
 * @property Carbon $date_sortie
 * @property string $fichier_couverture
 * @property int $id_GJ_USERS
 * @property int $id_GJ_STATUT
 * @property int|null $id_GJ_USERS_VALIDE
 * 
 * @property Statut $statut
 * @property User|null $user
 *
 * @package App\Models
 */
class Requete extends Model
{
	protected $table = 'GJ_requetes';
	public $timestamps = false;

	protected $casts = [
		'date_sortie' => 'datetime',
		'id_GJ_USERS' => 'int',
		'id_GJ_STATUT' => 'int',
		'id_GJ_USERS_VALIDE' => 'int'
	];

	protected $fillable = [
		'motif',
		'titre',
		'description',
		'date_sortie',
		'fichier_couverture',
		'id_GJ_USERS',
		'id_GJ_STATUT',
		'id_GJ_USERS_VALIDE'
	];

	public function statut()
	{
		return $this->belongsTo(Statut::class, 'id_GJ_STATUT');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'id_GJ_USERS_VALIDE');
	}
}
