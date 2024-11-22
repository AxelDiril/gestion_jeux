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
 * @property int $id
 * @property string $nom
 * @property string|null $description
 * @property Carbon $date_sortie
 * 
 * @property Collection|CollectionSupport[] $collection_supports
 * @property Collection|Game[] $games
 *
 * @package App\Models
 */
class Support extends Model
{

	public $timestamps = false;

	protected $casts = [
		'date_sortie' => 'string'
	];

	protected $fillable = [
		'nom',
		'description',
		'date_sortie'
	];

	public function collection_supports()
	{
		return $this->hasMany(CollectionSupport::class, 'id');
	}

	public function games()
	{
		return $this->hasMany(Game::class, 'id_GJ_SUPPORTS');
	}
}
