<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $telephone
 * @property bool $visibilite
 * @property bool $can_contribute
 * @property string $code
 * @property string|null $comment
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Role $role
 * @property Collection|Collection[] $collections
 * @property Collection|Requete[] $requetes
 * @property Collection|POSSEDESUPPORT[] $p_o_s_s_e_d_e_s_u_p_p_o_r_t_s
 *
 * @package App\Models
 */
class User extends Model
{
	protected $table = 'GJ_users';

	protected $casts = [
		'email_verified_at' => 'datetime',
		'visibilite' => 'bool',
		'can_contribute' => 'bool'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'email',
		'email_verified_at',
		'password',
		'remember_token',
		'telephone',
		'visibilite',
		'can_contribute',
		'code',
		'comment'
	];

	public function role()
	{
		return $this->belongsTo(Role::class, 'code');
	}

	public function collections()
	{
		return $this->hasMany(Collection::class, 'id_GJ_USERS');
	}

	public function requetes()
	{
		return $this->hasMany(Requete::class, 'id_GJ_USERS_VALIDE');
	}

	public function p_o_s_s_e_d_e_s_u_p_p_o_r_t_s()
	{
		return $this->hasMany(POSSEDESUPPORT::class, 'id_GJ_USERS');
	}
}
