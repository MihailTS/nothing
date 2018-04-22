<?php

namespace App\Http\Controllers;

use App\Post;
use App\Services\PostService;
use App\Transformers\PostTransformer;
use League\Fractal\Serializer\ArraySerializer;

class PostController extends Controller
{
    private $postService;

    /**
     * @param \App\Services\PostService $postService
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
        return fractal($posts, new PostTransformer())->toJson();
    }

    /**
     * Get the currency data.
     *
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function one(Post $post)
    {
        $post = $this->postService->getOne($post);
        return fractal($post, new PostTransformer())->toJson();
    }
}
