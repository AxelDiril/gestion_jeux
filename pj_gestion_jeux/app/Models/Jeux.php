<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Jeux
 * 
 * @property int $id
 * @property string $titre
 * @property string $description
 * @property Carbon $date_sortie
 * @property string $fichier_couverture
 * @property int $possede_par
 * @property int|null $moyenne
 * @property int $id_GJ_SUPPORTS
 * 
 * @property Support $support
 * @property Collection|APPARTIENT[] $a_p_p_a_r_t_i_e_n_t_s
 * @property Collection|Collection[] $collections
 *
 * @package App\Models
 */
class Jeux extends Model
{
	protected $table = 'GJ_jeux';
	public $timestamps = false;

	protected $casts = [
		'date_sortie' => 'datetime',
		'possede_par' => 'int',
		'moyenne' => 'int',
		'id_GJ_SUPPORTS' => 'int'
	];

	protected $fillable = [
		'titre',
		'description',
		'date_sortie',
		'fichier_couverture',
		'possede_par',
		'moyenne',
		'id_GJ_SUPPORTS'
	];

	public function support()
	{
		return $this->belongsTo(Support::class, 'id_GJ_SUPPORTS');
	}

	public function a_p_p_a_r_t_i_e_n_t_s()
	{
		return $this->hasMany(APPARTIENT::class, 'id');
	}

	public function collections()
	{
		return $this->hasMany(Collection::class, 'id_GJ_JEUX');
	}
}
