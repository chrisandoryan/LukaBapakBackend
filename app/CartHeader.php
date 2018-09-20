<?php

namespace App;

use App\User;
use App\CartDetail;
use Illuminate\Database\Eloquent\Model;

class CartHeader extends Model
{
    //
    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid');
    }

    public function cartDetails()
    {
        return $this->hasMany(CartDetail::class);
    }
}
