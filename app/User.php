<?php

namespace App;

use App\Delivery;
use App\CartHeader;
use Ramsey\Uuid\Uuid;
use App\HeaderFavorite;
use App\HeaderPromotion;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    public $incrementing = false;
    protected $primaryKey = 'uuid';
    // public $timestamps = false;
    protected $table = 'new_users';
    // protected $table = 'old_users';
    
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
        'username', 'name', 'email', 'origin', 'avatar_url', 'password', 'avatar_filename', 'positive_feedback', 'negative_feedback'
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

    public function CartHeaders()
    {
        return $this->hasMany(CartHeader::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    public function headerFavorite()
    {
        return $this->hasOne(HeaderFavorite::class);
    }

    public function headerPromotion()
    {
        return $this->hasMany(HeaderPromotion::class);
    }   

    public function verifyUser()
    {
        return $this->hasOne(VerifyUser::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
