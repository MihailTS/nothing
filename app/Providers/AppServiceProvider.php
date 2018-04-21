<?php

namespace App\Providers;

//service contracts
use App\Services\Contracts\PostLikeService as PostLikeServiceContract;
use App\Services\Contracts\PostService as PostServiceContract;

//services
use App\Services\PostService;
use App\Services\PostLikeService;

//repository contracts
use App\Repositories\Contracts\LikeRepository as LikeRepositoryContract;
use App\Repositories\Contracts\PostRepository as PostRepositoryContract;

//repositories
use App\Repositories\LikeRepository;
use App\Repositories\PostRepository;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PostServiceContract::class, PostService::class);
        $this->app->bind(PostLikeServiceContract::class, PostLikeService::class);

        $this->app->bind(PostRepositoryContract::class, PostRepository::class);
        $this->app->bind(LikeRepositoryContract::class, LikeRepository::class);
    }
}
