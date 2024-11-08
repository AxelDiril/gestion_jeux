<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * 
 * @property string $code
 * @property string $label
 * 
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Role extends Model
{
	protected $table = 'GJ_roles';
	protected $primaryKey = 'code';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'label'
	];

	public function users()
	{
		return $this->hasMany(User::class, 'code');
	}
}