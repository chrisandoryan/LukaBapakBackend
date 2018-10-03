<?php

namespace App;

use App\Product;
use App\CartHeader;
use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    //
    protected $fillable = ['user_uuid', 'product_uuid', 'amount'];

    public function cartHeader()
    {
        return $this->belongsTo(CartHeader::class, 'header_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_uuid', 'uuid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }
}
