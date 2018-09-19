<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Ramsey\Uuid\Uuid;

class User extends Authenticatable
{
    use Notifiable;
    public $incrementing = false;
    protected $primaryKey = 'uuid';
    protected $table = 'new_users';
    
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Uuid::uuid4();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'email', 'avatar_url', 'avatar_filename', 'positive_feedback', 'negative_feedback'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
