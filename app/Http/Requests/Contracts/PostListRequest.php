<?php

namespace App\Http\Requests\Contracts;

interface PostListRequest
{
    public function getFrom():?int;

    public function getRawTags():?string;

    public function getTags():?array;

    public function getTag($param, $cast = 'string');
}
