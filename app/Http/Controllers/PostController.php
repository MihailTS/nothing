<?php

namespace App\Http\Controllers;

use App\Post;
use App\Services\Contracts\PostService;

class PostController extends Controller
{
    private $postService;

    /**
     * @param \App\Services\Contracts\PostService $postService
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
    /**
     * Get all currencies list.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $posts = $this->postService->getAll();
        return response()->json($posts);
    }

    /**
     * Get the currency data.
     *
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function one(Post $post)
    {
        $currency = $this->postService->getOne($post);
        return response()->json($currency);
    }
}
