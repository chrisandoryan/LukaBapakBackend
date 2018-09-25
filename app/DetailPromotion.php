<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPromotion extends Model
{
    //
    protected $primaryKey = 'id';

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_uuid');
    }

    public function headerPromotion() 
    {
        return $this->belongsTo(HeaderPromotion::class, 'header_id', 'id');
    }
}
