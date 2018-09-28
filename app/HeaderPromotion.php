<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class HeaderPromotion extends Model
{
    //
    protected $primaryKey = 'id';

    protected $fillable = ['name'];

    public function user()
    {
        return $this->belongsTo(User::class, 'seller_uuid');
    }

    public function detailPromotions() 
    {
        return $this->hasManyThrough(Product::class, DetailPromotion::class, 'header_id', 'uuid', 'id', 'product_uuid');
    }
}
