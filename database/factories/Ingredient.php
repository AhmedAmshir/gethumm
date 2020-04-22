<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Ingredient;
use Faker\Generator as Faker;

$factory->define(Ingredient::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'supplier' => $faker->word,
        'measure' => ['g','piece','tpsb', 'kg'][rand(0,3)],
        'created_at' => $faker->dateTime,
    ];
});
