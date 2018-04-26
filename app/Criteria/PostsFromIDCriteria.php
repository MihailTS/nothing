<?php

namespace App\Criteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class PostsFromIDCriteria implements CriteriaInterface
{
    protected $fromID;

    public function __construct(int $fromID)
    {
        $this->fromID = $fromID;
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
        return $model
            ->orderBy('id')
            ->where('id','>',$this->fromID);
    }
}