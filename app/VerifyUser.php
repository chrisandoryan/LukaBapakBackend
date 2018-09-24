<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerifyUser extends Model
{
    //
    public $timestamps = false;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid');
    }
}
