<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; // Add this line
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $telephone
 * @property bool $visibilite
 * @property bool $can_contribute
 * @property string $code
 * @property string|null $comment
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Role $role
 * @property Collection|CollectionGame[] $collection_games
 * @property Collection|CollectionSupport[] $collection_supports
 * @property Collection|Requete[] $requetes
 *
 * @package App\Models
 */
class User extends Authenticatable // Change this line to extend Authenticatable
{
    use Notifiable; // You might need this if you're using notifications

    protected $casts = [
        'email_verified_at' => 'datetime',
        'visibilite' => 'bool',
        'can_contribute' => 'bool'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'telephone',
        'visibilite',
        'can_contribute',
        'code',
        'comment'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'code');
    }

    public function collection_games()
    {
        return $this->hasMany(CollectionGame::class, 'id_GJ_USERS');
    }

    public function collection_supports()
    {
        return $this->hasMany(CollectionSupport::class, 'id_GJ_USERS');
    }

    public function requetes()
    {
        return $this->hasMany(Requete::class, 'id_GJ_USERS_VALIDE');
    }
}

