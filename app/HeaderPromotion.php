<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class HeaderPromotion extends Model
{
    //
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo(User::class, 'seller_uuid');
    }

    public function detailPromotions() 
    {
        return $this->hasMany(DetailPromotion::class, 'header_id');
    }
}
