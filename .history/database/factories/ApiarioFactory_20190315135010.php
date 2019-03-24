<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Model\Apiario::class, function (Faker $faker) {
    return [
        'nome' => $faker->name,
        'endereco' => $faker->secondaryAddress,
        'user_id' => $faker->randomElement([1,3]),
        'tecnico_id' => 4,
    ];
});


