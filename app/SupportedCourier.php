<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupportedCourier extends Model
{
    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courier()
    {
        return $this->belongsTo(Courier::class);
    }
}
