<?php

namespace App\Http\Requests\Contracts;

interface PostListRequest
{
    public function getFrom():int;

    public function getRawFilter():string;

    public function getFilter():array;

    public function getFilterParam(string $param, string $cast = 'string'):?mixed;
}
