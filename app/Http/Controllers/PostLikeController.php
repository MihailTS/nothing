<?php

namespace App\Http\Controllers;

use App\Post;
use App\Services\Contracts\PostLikeService;

class PostLikeController extends Controller
{
    private $postLikeService;

    public function __construct(PostLikeService $postLikeService)
    {
        $this->postLikeService = $postLikeService;
    }

    public function like(Post $post){
        $post = $this->postLikeService->like($post);
        return response()->json($post);
    }

    public function dislike(Post $post){
        $post = $this->postLikeService->dislike($post);
        return response()->json($post);
    }
}
