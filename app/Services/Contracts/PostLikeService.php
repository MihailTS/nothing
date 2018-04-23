<?php

namespace App\Services\Contracts;

use App\Post;

interface PostLikeService
{
    public function like(Post $post):?Post;

    public function dislike(Post $post):?Post;

}