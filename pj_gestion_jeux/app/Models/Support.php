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
 * @property int $support_id
 * @property string $support_name
 * @property string|null $support_desc
 * @property Carbon $support_year
 * @property string|null $support_pic
 * @property string|null $support_logo
 * 
 * @property Collection|CollectionSupport[] $collection_supports
 * @property Collection|Game[] $games
 *
 * @package App\Models
 */
class Support extends Model
{
	//protected $table = 'GJ_supports';
	protected $primaryKey = 'support_id';
	public $timestamps = false;

	protected $casts = [
		'support_year' => 'string'
	];

	protected $fillable = [
		'support_name',
		'support_desc',
		'support_year',
		'support_pic',
		'support_logo'
	];

	public function collection_supports()
	{
		return $this->hasMany(CollectionSupport::class);
	}

	public function games()
	{
		return $this->hasMany(Game::class);
	}
}
