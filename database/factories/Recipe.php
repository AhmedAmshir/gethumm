<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Recipe;
use Faker\Generator as Faker;

$factory->define(Recipe::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(100),
        'created_at' => $faker->dateTime,
    ];
});
