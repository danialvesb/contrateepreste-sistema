<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

use App\Models\Service;

$factory->define(Service::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'category_id' => 1,
        'description' => $faker->text,
        'file' => $faker->name
    ];
});
