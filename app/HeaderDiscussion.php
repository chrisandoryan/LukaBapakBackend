<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class HeaderDiscussion extends Model
{
    //
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Uuid::uuid4();
        });
    }

    protected $table = 'header_discussions';
    protected $fillable = ['product_uuid'];
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_uuid', 'uuid');
    }

    public function detailDiscussion()
    {
        return $this->hasMany(DetailDiscussion::class, 'header_id', 'id');
    }
}
