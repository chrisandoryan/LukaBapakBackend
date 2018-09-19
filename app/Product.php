<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['uuid', 'category_uuid', 'user_uuid'];
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
