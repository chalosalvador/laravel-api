<?php

use App\Article;
use App\User;
use Illuminate\Database\Seeder;
use Tymon\JWTAuth\Contracts\Providers\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;


class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        Article::truncate();
        JWTAuth::attempt(['email' => 'admin@test.com', 'password' => 'toptal']); // creates all articles for admin
        $faker = \Faker\Factory::create();

        // And now, let's create a few articles in our database:

        for ($i = 0; $i < 50; $i++) {
            Article::create([
                'title' => $faker->sentence,
                'body' => $faker->paragraph,
                'image' => $faker->imageUrl(400,300, null, false)
            ]);
        }
    }
}
