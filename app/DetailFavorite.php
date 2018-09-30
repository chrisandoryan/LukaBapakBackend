<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class DetailFavorite extends Model
{
    //

    protected $fillable = ['user_uuid', 'product_uuid'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_uuid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid');
    }
}
