<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Patient;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(Patient::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
        'created_by' => 1,
        'updated_by' => 1
    ];
});
