<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Category extends Model
{
    //
    protected $with = "children";
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    // protected $table = 'newer_categories';
    public $timestamps = false;
    protected $table = 'categories';

    protected $fillable = ['uuid', 'parent_uuid', 'name'];
    
    public function products()
    {
        return $this->hasMany(Product::class, 'category_uuid', 'uuid');
    }
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_uuid', 'uuid');
        // return $this->belongsTo(Category::class, 'parent_id', 'id'); // uncomment this to migrate from HODB
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_uuid', 'uuid');
        // return $this->hasMany(Category::class, 'parent_id', 'id'); // uncomment this to migrate from HODB
    }
}
