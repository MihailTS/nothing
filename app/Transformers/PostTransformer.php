<?php

namespace App\Transformers;

use App\Like;
use App\Post;
use Carbon\Carbon;
use Illuminate\Auth\AuthenticationException;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Post $post
     * @return array
     */
    public function transform(Post $post) : array
    {
        $rated = "";
        $likeType = null;
        try {
            $likeType = $post->getCurrentUserLike();
        } catch (AuthenticationException $e) {

        }
        if($likeType){
            switch($likeType->type){
                case Like::DEFAULT_LIKE:
                    $rated = "like";
                    break;
                case Like::DEFAULT_DISLIKE:
                    $rated = "dislike";
                    break;
            }
        }

        return [
            'id' => $post->id,
            'content' => $post->content,
            'time_to_die' => $post->time_to_die->format('Y-m-d H:i:s'),
            'time_left' => $this->transformTimeLeft($post->time_to_die),
            'user' => $post->user,
            'rated'=>$rated
        ];
    }

    public function transformTimeLeft(Carbon $timeToDie){
        $diff = Carbon::now()->diff($timeToDie,false);
        $resultTime = (($diff->invert)?"-":"").$diff->format('%H:%I:%S');
        return $resultTime;
    }
}
