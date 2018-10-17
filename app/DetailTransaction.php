<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailTransaction extends Model
{
    //
    protected $fillable = ['header_id', 'product_uuid', 'amount'];
    public $timestamps = false;

    public function headerTransaction() {
        return $this->belongsTo(HeaderTransaction::class, 'header_id', 'id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_uuid');
    }
}
