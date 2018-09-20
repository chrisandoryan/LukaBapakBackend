<?php

namespace App;

use App\Product;
use App\CartHeader;
use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    //
    public function cartHeader()
    {
        return $this->belongsTo(CartHeader::class, 'header_id');
    }

    public function Product()
    {
        return $this->belongsTo(Product::class, 'product_uuid');
    }
}
