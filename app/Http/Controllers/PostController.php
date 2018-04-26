<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostListRequest;
use App\Post;
use App\Services\Contracts\PostService;
use App\Transformers\PostTransformer;
use League\Fractal\Serializer\ArraySerializer;

class PostController extends Controller
{
    private $postService;

    /**
     * @param PostService $postService
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
    public function all(PostListRequest $request)
    {
        $fromPostID = $request->getFrom();

        $posts = $this->postService->getPosts($fromPostID);
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
