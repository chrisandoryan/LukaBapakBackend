<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //
    protected $fillable = ['id', 'product_uuid', 'product_id', 'url', 'filename'];
    public $timestamps = false;
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_uuid');
    }

}
