<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailTransaction extends Model
{
    //
    protected $fillable = ['header_id', 'product_uuid', 'amount'];
    public $timestamps = false;
}
