<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'id' => 1,
        'name' => 'Cat 1',
        'parent' => 0
    ];
});
