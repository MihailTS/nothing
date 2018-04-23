<?php

namespace App\Repositories;

use App\Like;
use App\Repositories\Contracts\LikeRepository as LikeRepositoryContract;
use Prettus\Repository\Eloquent\BaseRepository;

class LikeRepository extends BaseRepository implements LikeRepositoryContract
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Like::class;
    }

    /**
     * @param Like $like
     * @return \App\Like
     */
    public function save(Like $like): Like
    {
        $like->push();
        return $like;
    }

    /**
     * Update the post data.
     *
     * @param Like $like
     * @param int $id
     *
     * @return Like
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function updateLike(Like $like, int $id): Like
    {
        return $this->update($like->toArray(), $id);
    }

    /**
     * @param int $id
     * @return int
     */
    public function destroy($id)
    {
        return $this->delete($id);
    }

    public function isPostLiked(int $postID, int $userID):bool
    {
        return $this->model->where("post_id",$postID)
            ->where("user_id",$userID)->exists();
    }
}