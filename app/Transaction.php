<?php

namespace App;

use App\City;
use App\PaymentMethod;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
