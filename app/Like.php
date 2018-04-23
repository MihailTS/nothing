<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    const DEFAULT_LIKE = 0;
    const DEFAULT_DISLIKE = 1;

    protected $fillable = [
        'post_id',
        'user_id',
        'type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
