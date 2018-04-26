<?php
namespace App\Services;
use App\Criteria\PostsFromIDCriteria;
use App\Post;
use Doctrine\Common\Collections\Criteria;
use Illuminate\Support\Collection;
use App\Repositories\Contracts\PostRepository;
use App\Services\Contracts\PostService as PostServiceContract;

class PostService implements PostServiceContract
{
    const PAGE_LIMIT = 10;
    protected $postRepository;

    /**
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }
    public function getPosts(?int $fromID)
    {
        $criteria = false;
        if($fromID){
            $criteria = new PostsFromIDCriteria($fromID);
        }
        return $this->getList($criteria, self::PAGE_LIMIT);

    }

    public function getList($criteria, $limit){
        if($criteria){
            $this->postRepository->pushCriteria($criteria);
        }
        $result = $this->postRepository->paginate($limit);

        return $result;
    }

    public function getOne(Post $post): ?Post
    {
        return $post->with('likes');
    }
}