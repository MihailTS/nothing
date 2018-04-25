<?php

namespace App;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'content',
        'time_to_die',
        'user_id',
    ];

    protected $dates = [
        'time_to_die',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    /**
     * @return mixed
     * @throws AuthenticationException
     */
    public function getCurrentUserLike(){
        $currentUser=\Auth::user();
        if(!$currentUser){
            throw new AuthenticationException();
        }else{
            return $this->likes()->where('user_id','=', $currentUser->id)->first();
        }
    }
}
