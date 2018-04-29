<?php
namespace App\Services;
use App\Criteria\PostsFromIDCriteria;
use App\Criteria\PostTagCriteria;
use App\Http\Requests\PostListRequest;
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
    public function getPosts(PostListRequest $request)
    {
        $fromID = $request->getFrom();
        $tags = $request->getTags();

        $criteria = [];
        if($fromID){
            $criteria[] = new PostsFromIDCriteria($fromID);
        }
        foreach($tags as $tag){
            $criteria[] = new PostTagCriteria($tag);
        }

        return $this->getList(self::PAGE_LIMIT, $criteria);

    }

    public function getList($limit, $arCriteria){
        foreach($arCriteria as $criterion){
            $this->postRepository->pushCriteria($criterion);
        }
        $result = $this->postRepository->paginate($limit);

        return $result;
    }

    public function getOne(Post $post)
    {
        return $post->with('likes');
    }
}