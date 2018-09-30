<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class HeaderFavorite extends Model
{
    //
    protected $fillable = ['user_uuid'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid');
    }
}
