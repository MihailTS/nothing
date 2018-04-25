<?php
namespace App\Services;
use App\Post;
use Illuminate\Support\Collection;
use App\Repositories\Contracts\PostRepository;
use App\Services\Contracts\PostService as PostServiceContract;

class PostService implements PostServiceContract
{
    protected $postRepository;

    /**
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }
    public function getAll(): Collection
    {
        return $this->postRepository->all();
    }

    public function getOne(Post $post): ?Post
    {
        return $post->with('likes');
    }
}