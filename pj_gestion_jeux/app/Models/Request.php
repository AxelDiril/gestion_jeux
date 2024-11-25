<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Request
 * 
 * @property int $request_id
 * @property string|null $request_motif
 * @property string $request_Name
 * @property string $request_desc
 * @property Carbon $request_year
 * @property string $request_cover
 * @property int $id
 * @property int $status_id
 * @property int|null $valide_id
 * 
 * @property Status $status
 * @property User|null $user
 *
 * @package App\Models
 */
class Request extends Model
{
	protected $table = 'GJ_requests';
	protected $primaryKey = 'request_id';
	public $timestamps = false;

	protected $casts = [
		'request_year' => 'datetime',
		'id' => 'int',
		'status_id' => 'int',
		'valide_id' => 'int'
	];

	protected $fillable = [
		'request_motif',
		'request_Name',
		'request_desc',
		'request_year',
		'request_cover',
		'id',
		'status_id',
		'valide_id'
	];

	public function status()
	{
		return $this->belongsTo(Status::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'valide_id');
	}
}
