<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    //
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
