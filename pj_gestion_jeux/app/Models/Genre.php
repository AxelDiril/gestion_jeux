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
 * @property Collection|APPARTIENT[] $a_p_p_a_r_t_i_e_n_t_s
 *
 * @package App\Models
 */
class Genre extends Model
{
	protected $table = 'GJ_genres';
	public $timestamps = false;

	protected $fillable = [
		'label'
	];

	public function a_p_p_a_r_t_i_e_n_t_s()
	{
		return $this->hasMany(APPARTIENT::class, 'id_GJ_GENRES');
	}
}
