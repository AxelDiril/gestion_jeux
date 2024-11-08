<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Support
 * 
 * @property int $id
 * @property string $nom
 * @property string|null $description
 * @property Carbon $date_sortie
 * 
 * @property Collection|Jeux[] $jeuxes
 * @property Collection|POSSEDESUPPORT[] $p_o_s_s_e_d_e_s_u_p_p_o_r_t_s
 *
 * @package App\Models
 */
class Support extends Model
{
	protected $table = 'GJ_supports';
	public $timestamps = false;

	protected $casts = [
		'date_sortie' => 'datetime'
	];

	protected $fillable = [
		'nom',
		'description',
		'date_sortie'
	];

	public function jeuxes()
	{
		return $this->hasMany(Jeux::class, 'id_GJ_SUPPORTS');
	}

	public function p_o_s_s_e_d_e_s_u_p_p_o_r_t_s()
	{
		return $this->hasMany(POSSEDESUPPORT::class, 'id');
	}
}
