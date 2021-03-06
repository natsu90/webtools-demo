<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Patient;
use Faker\Generator as Faker;
use Carbon\Carbon;
use App\User;

$factory->define(Patient::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
        'created_by' => function () {
            return factory(User::class)->create()->id;
        },
        'updated_by' => function (array $patient) {
            return $patient['created_by'];
        }
    ];
});
