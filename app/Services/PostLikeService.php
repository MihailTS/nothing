<?php

namespace App\Services;

use App\Events\PostUpdateTime;
use App\Like;
use App\Post;
use App\Services\Contracts\PostLikeService as PostLikeServiceContract;
use App\Repositories\Contracts\PostRepository;
use App\Repositories\Contracts\LikeRepository;
use Auth;

class PostLikeService implements PostLikeServiceContract
{
    private $postRepository;
    private $likeRepository;
    private $user;

    public function __construct(PostRepository $postRepository, LikeRepository $likeRepository)
    {
        $this->postRepository = $postRepository;
        $this->likeRepository = $likeRepository;
    }

    public function like(Post $post):?Post
    {
        return $this->changeTimeToDie($post,Like::DEFAULT_LIKE);
    }
    public function dislike(Post $post):?Post
    {
        return $this->changeTimeToDie($post,Like::DEFAULT_DISLIKE);
    }

    private function changeTimeToDie(Post $post, int $type):?Post
    {
        $user = Auth::user();
        if(
            $user->id != $post->user->id && //user can't rate own posts
            !$this->likeRepository->isPostLiked($post->id,$user->id)
        ){

            $like = new Like;
            $like->user_id = $user->id;
            $like->post_id = $post->id;
            $like->type = $type;
            $this->likeRepository->save($like);

            $timeToDie = $post->time_to_die;
            switch ($type){
                case Like::DEFAULT_LIKE:
                    $post->time_to_die=$timeToDie->addMinutes(2);
                    break;
                case Like::DEFAULT_DISLIKE:
                    $post->time_to_die=$timeToDie->addMinutes(-2);
                    break;
            }

            $this->postRepository->save($post);
            event(new PostUpdateTime($post));
        }
        return $post;
    }
}