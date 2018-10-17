<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HeaderTransaction extends Model
{
    //
    protected $fillable = ['seller_uuid', 'buyer_uuid'];

    public function detailTransactions() {
        return $this->hasMany(DetailTransaction::class, 'header_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'buyer_uuid');
    }
}
