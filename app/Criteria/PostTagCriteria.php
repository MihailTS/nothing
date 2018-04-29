<?php

namespace App\Criteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class PostTagCriteria implements CriteriaInterface
{
    protected $tagName;

    public function __construct($tagName)
    {
        $this->tagName = $tagName;
    }
    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $name = $this->tagName;
        return $model
            ->orderBy('id')
            ->whereHas('tags', function ($query) use ($name){
                $query->where('tag',$name);
            });
    }
}