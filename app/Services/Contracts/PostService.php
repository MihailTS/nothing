<?php
namespace App\Services\Contracts;

use App\Post;
use Illuminate\Support\Collection;

interface PostService
{
    /**
     * Get all posts list.
     *
     * @param ?int $fromID
     */
    public function getPosts(?int $fromID);

    /**
     * Get the one post.
     *
     * @param Post $post
     * @return \App\Post|null
     */
    public function getOne(Post $post): ?Post;

    public function getList($criteria, $limit);
}