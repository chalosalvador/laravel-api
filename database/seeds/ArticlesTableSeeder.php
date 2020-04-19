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
        $faker = \Faker\Factory::create();

        // And now, let's create a few articles in our database:
        for ($i = 1; $i <= 10; $i++) {
            $user = User::find($i);
            // login with recently created user
            JWTAuth::attempt(['email' => $user->email, 'password' => 'toptal']);

            // And now, let's create a few articles in our database for this user:
            $num_articles = 5;
            for ($j = 0; $j < $num_articles; $j++) {
                Article::create([
                    'title' => $faker->sentence,
                    'body' => $faker->paragraph,
                ]);
            }
        }
    }
}
