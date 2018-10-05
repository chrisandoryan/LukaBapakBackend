<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class DetailReview extends Model
{
    //
    protected $table = 'detail_review';
    protected $fillable = ['header_id', 'user_uuid', 'message'];
    public $timestamps = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Uuid::uuid4();
        });
    }
}
