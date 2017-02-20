<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\News::class, function (Faker\Generator $faker) {
    return [
        'image' => $faker->image(),
       // 'options' => $faker->options(),
    ];
});

$factory->define(App\NewsDetail::class, function (Faker\Generator $faker) {
    return [
		'news_id' => App\News::all()->random()->id ,
        'lang' => $faker->name,
        'title' => str_random(20),
		'summary' => str_random(40),
		'text' => str_random(100),
		'tags' => str_random(5),
    ];
});