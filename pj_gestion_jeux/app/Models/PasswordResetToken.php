<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PasswOrdersetToken
 * 
 * @property string $email
 * @property string $token
 * @property Carbon|null $created_at
 *
 * @package App\Models
 */
class PasswOrdersetToken extends Model
{
	protected $table = 'GJ_password_reset_tokens';
	protected $primaryKey = 'email';
	public $incrementing = false;
	public $timestamps = false;

	protected $hidden = [
		'token'
	];

	protected $fillable = [
		'token'
	];
}
