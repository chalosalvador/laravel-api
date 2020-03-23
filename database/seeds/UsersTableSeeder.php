<?php

use App\Article;
use App\User;
use Illuminate\Database\Seeder;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's clear the users table first
        User::truncate();
        Article::truncate();

        $faker = \Faker\Factory::create();

        // Let's make sure everyone has the same password and
        // let's hash it before the loop, or else our seeder
        // will be too slow.
        $password = Hash::make('toptal');

        User::create([
            'name' => 'Administrator',
            'email' => 'admin@test.com',
            'password' => $password,
        ]);

        // And now let's generate a few dozen users for our app:
        for ($i = 0; $i < 10; $i++) {
            $email = $faker->email;
            User::create([
                'name' => $faker->name,
                'email' => $email,
                'password' => $password,
            ]);

            // login with recently created user
            JWTAuth::attempt(['email' => $email, 'password' => 'toptal']);

            // And now, let's create a few articles in our database for this user:
            $num_articles = rand(0, 20);
            for ($j = 0; $j < $num_articles; $j++) {
                Article::create([
                    'title' => $faker->sentence,
                    'body' => $faker->paragraph,
                ]);
            }


        }
    }
}
