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
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'api_token'      => str_random(10)
    ];
});

$factory->define(App\News::class, function (Faker\Generator $faker) {
    return [
        'image' => $faker->image(),
       // 'options' => $faker->options(),
    ];
});

$factory->define(App\NewsDetail::class, function (Faker\Generator $faker) {
	static $news;
	$news = $news ?: App\News::pluck('id');
        $langs=['ar','fa','en'];
    $tags = str_replace(' ', ',', $faker->words(rand(3,6),true));
    return [
		'news_id' => $news[rand(0,count($news)-1)] ,
        'lang'    => $langs[rand(0,2)],
        'title'   => $faker->words(rand(3,6),true),
		'summary' => $faker->sentences(rand(0,2),true),
		'text'    => $faker->sentences(rand(3,6),true),
		'tags'    => $tags,
    ];
});
