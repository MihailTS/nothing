<?php

namespace App\Repositories\Contracts;


use App\Like;

interface LikeRepository
{
    /**
     * @param Like $like
     * @return \App\Like
     */
    public function save(Like $like):Like;

    /**
     * Update the post data.
     *
     * @param Like $like
     * @param int $id
     *
     * @return Like
     */
    public function updateLike(Like $like, int $id): Like;

    /**
     * @param int $id
     * @return int
     */
    public function destroy($id);

    public function isPostLiked(int $postID, int $userID):bool;

}