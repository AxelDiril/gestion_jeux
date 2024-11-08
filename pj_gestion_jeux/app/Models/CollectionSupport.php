<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CollectionSupport
 * 
 * @property int $id
 * @property int $id_GJ_USERS
 * 
 * @property Support $support
 * @property User $user
 *
 * @package App\Models
 */
class CollectionSupport extends Model
{
	protected $table = 'GJ_collection_supports';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'id_GJ_USERS' => 'int'
	];

	public function support()
	{
		return $this->belongsTo(Support::class, 'id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'id_GJ_USERS');
	}
}
