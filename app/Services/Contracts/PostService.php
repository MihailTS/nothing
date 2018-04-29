<?php
namespace App\Services\Contracts;

use App\Http\Requests\PostListRequest;
use App\Post;
use Illuminate\Support\Collection;

interface PostService
{
    /**
     * Get all posts list.
     *
     * @param PostListRequest $request
     */
    public function getPosts(PostListRequest $request);

    /**
     * Get the one post.
     *
     * @param Post $post
     */
    public function getOne(Post $post);

    public function getList($limit, $arCriteria);
}