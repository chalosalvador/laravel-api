<?php

use App\Article;
use App\User;
use App\Comment;
use Illuminate\Database\Seeder;
use Tymon\JWTAuth\Facades\JWTAuth;


class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        Comment::truncate();
        $faker = \Faker\Factory::create();

        // And now, let's create a few articles in our database:
        for ($i = 1; $i <= 10; $i++) { // users
            $user = User::find($i);
            // login with recently created user
            JWTAuth::attempt(['email' => $user->email, 'password' => 'toptal']);

            // And now, let's create a few articles in our database for this user:
            $num_articles = 5;
            for ($j = 1; $j < $num_articles; $j++) { // articles
                Comment::create([
                    'text' => $faker->paragraph,
                    'article_id' => $j,
                ]);
            }
        }
    }
}
