<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailDiscussion extends Model
{
    //
    protected $table = 'detail_discussions';
    protected $fillable = ['header_id', 'user_uuid', 'parent_id', 'message'];

    public function parent()
    {
        return $this->belongsTo(DetailDiscussion::class, 'parent_id', 'id');
    }

    public function child()
    {
        return $this->hasMany(DetailDiscussion::class, 'parent_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }
}
