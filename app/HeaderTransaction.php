<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HeaderTransaction extends Model
{
    //
    protected $fillable = ['seller_uuid', 'buyer_uuid'];
}
