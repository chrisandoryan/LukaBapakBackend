<?php

namespace App;

use App\Transaction;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    //
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
