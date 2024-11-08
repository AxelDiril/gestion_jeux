<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Migration
 * 
 * @property int $id
 * @property string $migration
 * @property int $batch
 *
 * @package App\Models
 */
class Migration extends Model
{
	protected $table = 'GJ_migrations';
	public $timestamps = false;

	protected $casts = [
		'batch' => 'int'
	];

	protected $fillable = [
		'migration',
		'batch'
	];
}
