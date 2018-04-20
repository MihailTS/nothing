<?php

namespace App\Repositories;

use App\Post;
use App\Repositories\Contracts\PostRepository as PostRepositoryContract;
use Prettus\Repository\Eloquent\BaseRepository;

class PostRepository extends BaseRepository implements PostRepositoryContract
{
    /**
     * @return string
     */
    public function model()
    {
        return Post::class;
    }

    /**
     * @param \App\Post $post
     *
     * @return \App\Post
     */
    public function save(Post $post)
    {
        $post->push();
        return $post;
    }

    /**
     * Update the post data.
     *
     * @param \App\Post $post
     * @param int $id
     *
     * @return \App\Post
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function updatePost(Post $post, int $id): Post
    {
        return $this->update($post->toArray(), $id);
    }
}