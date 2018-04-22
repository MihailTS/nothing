<?php

namespace App\Transformers;

use App\Post;
use Carbon\Carbon;
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
        return [
            'id' => $post->id,
            'content' => $post->content,
            'time_to_die' => $post->time_to_die->format('Y-m-d H:i:s'),
            'time_left' => $this->transformTimeLeft($post->time_to_die),
            'user' => $post->user,
        ];
    }

    public function transformTimeLeft(Carbon $timeToDie){
        $diff = Carbon::now()->diff($timeToDie,false);
        $resultTime = (($diff->invert)?"-":"").$diff->format('%H:%I:%S');
        return $resultTime;
    }
}
