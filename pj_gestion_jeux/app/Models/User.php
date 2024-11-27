<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
 * @property Collection|CollectionGame[] $collection_games
 * @property Collection|CollectionSupport[] $collection_supports
 * @property Collection|Request[] $requests
 *
 * @package App\Models
 */
class User extends Authenticatable
{
	use Notifiable;
	//protected $table = 'GJ_users';

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

	public function collection_games()
	{
		return $this->hasMany(CollectionGame::class, 'id');
	}

	public function collection_supports()
	{
		return $this->hasMany(CollectionSupport::class, 'id');
	}

	public function requests()
	{
		return $this->hasMany(Request::class, 'valide_id');
	}
}
