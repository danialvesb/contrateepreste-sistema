<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

use App\Models\Service;

$factory->define(Service::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'category' => $faker->name,
        'description' => $faker->text,
        'file' => $faker->name
    ];
});
