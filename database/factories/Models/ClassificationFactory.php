<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Classification;
use Faker\Generator as Faker;

$factory->define(Classification::class, function (Faker $faker) {
    return [
        'parent_id' => factory(\App\Models\Classification::class),
        'lft' => $faker->randomNumber(),
        'rgt' => $faker->randomNumber(),
        'name' => $faker->name,
        'slug' => $faker->slug,
    ];
});
