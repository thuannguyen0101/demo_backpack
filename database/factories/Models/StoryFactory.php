<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Story;
use Faker\Generator as Faker;

$factory->define(Story::class, function (Faker $faker) {
    return [
        'classification_id' => factory(\App\Models\Classification::class),
        'title' => $faker->sentence(4),
        'slug' => $faker->slug,
        'content' => $faker->paragraphs(3, true),
        'image' => $faker->word,
        'status' => $faker->randomElement(["PUBLISHED","DRAFF"]),
        'date' => $faker->date(),
        'featured' => $faker->boolean,
    ];
});
