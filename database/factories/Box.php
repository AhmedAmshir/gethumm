<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Box;
use Faker\Generator as Faker;

$factory->define(Box::class, function (Faker $faker) {
    return [
        'fullname' => implode(' ',$faker->words(2)),
        'address' => $faker->text(50),
        'mobile' => $faker->unique()->randomNumber,
        'delivery_date' => $faker->dateTime,
        'created_at' => $faker->dateTime,
    ];
});
