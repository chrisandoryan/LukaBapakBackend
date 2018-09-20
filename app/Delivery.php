<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    //
    public function user()
    {
        return $this->belongsTo(User::class, 'seller_uuid');
    }
}
