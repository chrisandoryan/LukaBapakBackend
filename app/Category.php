<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    //
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $table = 'new_categories';
    // use NodeTrait;
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_uuid', 'uuid');
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_uuid', 'uuid');
    }
}
