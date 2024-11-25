<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Status
 * 
 * @property int $status_id
 * @property string $status_label
 * 
 * @property Collection|Request[] $requests
 *
 * @package App\Models
 */
class Status extends Model
{
	protected $table = 'GJ_status';
	protected $primaryKey = 'status_id';
	public $timestamps = false;

	protected $fillable = [
		'status_label'
	];

	public function requests()
	{
		return $this->hasMany(Request::class);
	}
}
