<?php
namespace App\Repositories\Contracts;
use App\Post;
use Prettus\Repository\Contracts\RepositoryInterface;
interface PostRepository extends RepositoryInterface
{
    /**
     * @param \App\Post $post
     *
     * @return \App\Post
     */
    public function save(Post $post);

    /**
     * Update the post data.
     *
     * @param \App\Post $post
     * @param int $id
     *
     * @return \App\Post
     */
    public function updatePost(Post $post, int $id): Post;
}