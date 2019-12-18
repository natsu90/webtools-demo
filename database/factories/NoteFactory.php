<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Note;
use Faker\Generator as Faker;
use App\User;
use App\Patient;
use Carbon\Carbon;

$factory->define(Note::class, function (Faker $faker) {
    return [
        'description' => $faker->text,
        'patient_id' => function () {
            return factory(Patient::class)->create()->id;
        },
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
