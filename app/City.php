<?php

namespace App;

use App\Transaction;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
