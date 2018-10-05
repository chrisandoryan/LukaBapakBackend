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

    public function headerReview()
    {
        return $this->belongsTo(HeaderReview::class, 'header_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

}
