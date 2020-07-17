<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title'       => $faker->sentence,
        'description' => $faker->paragraph,
        'url'         => $faker->url,
        'user_id'    => function(){
            return factory(App\User::class)->create()->id;
        }
    ];
});
