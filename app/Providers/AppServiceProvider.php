<?php

namespace App\Providers;

use App\Services\Contracts\PostService as PostServiceContract;
use App\Services\PostService;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Contracts\PostRepository as PostRepositoryContract;
use App\Repositories\PostRepository;

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

        $this->app->bind(PostRepositoryContract::class, PostRepository::class);
    }
}
