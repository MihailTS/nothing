<?php
namespace App\Services\Contracts;

use App\Post;
use Illuminate\Support\Collection;

interface PostService
{
    /**
     * Get all posts list.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAll(): Collection;

    /**
     * Get the one post.
     *
     * @param Post $post
     * @return \App\Post|null
     */
    public function getOne(Post $post): ?Post;
}