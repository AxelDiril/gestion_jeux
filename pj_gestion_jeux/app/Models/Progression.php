<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Progression
 * 
 * @property int $progress_id
 * @property string $progress_label
 * 
 * @property Collection|CollectionGame[] $collection_games
 *
 * @package App\Models
 */
class Progression extends Model
{
	protected $table = 'GJ_progression';
	protected $primaryKey = 'progress_id';
	public $timestamps = false;

	protected $fillable = [
		'progress_label'
	];

	public function collection_games()
	{
		return $this->hasMany(CollectionGame::class, 'progress_id');
	}
}
