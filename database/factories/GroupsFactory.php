<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Models\Group;

$factory->define(Group::class, function (Faker $faker) {
    return [
        'name' => 'Provider'
    ];
});



