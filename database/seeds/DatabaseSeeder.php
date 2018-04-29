<?php

use App\Like;
use App\Post;
use App\Tag;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        User::truncate();
        Post::truncate();
        Like::truncate();
        Tag::truncate();

        factory(User::class)->create();
        factory(Post::class, 100)->create();
        factory(Tag::class, 20)->create();
    }
}
