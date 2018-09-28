<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    //
    public function supportedCouriers()
    {
        return $this->hasMany(SupportedCourier::class);
    }
}
