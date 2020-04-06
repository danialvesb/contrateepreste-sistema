<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Models\Service\Category;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
    ];
});
