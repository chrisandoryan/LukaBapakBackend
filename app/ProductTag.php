<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \JordanMiguel\LaravelPopular\Traits\Visitable;

class ProductTag extends Model
{
    //
    use Visitable;
    protected $table = "product_tags";

    public function product()
    {
        return $this->hasMany(Product::class, 'tag_id', 'id');
    }
}
