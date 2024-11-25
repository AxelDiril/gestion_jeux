<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CollectionSupport
 * 
 * @property int $support_id
 * @property int $id
 * 
 * @property Support $support
 * @property User $user
 *
 * @package App\Models
 */
class CollectionSupport extends Model
{
	//protected $table = 'GJ_collection_supports';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'support_id' => 'int',
		'id' => 'int'
	];

	public function support()
	{
		return $this->belongsTo(Support::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'id');
	}
}
