<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Movie;

$factory->define(Movie::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'director' => $faker->name,
        'imageUrl' => $faker->url,
        'duration' => $faker->numberBetween($min = 60, $max = 150),
        'releaseDate' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'genre' => $faker->word,
    ];
});
