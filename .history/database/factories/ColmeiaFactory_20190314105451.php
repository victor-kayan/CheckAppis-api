<?php

use App\Model\Colmeia;
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

$factory->define(Colmeia::class, function (Faker $faker) {
    return [
        'nome' => $faker->name,
        'descricao' => $faker->name,
        'longitude' => $faker->latitude($min = -90, $max = 90),
        'longitude' => $faker->longitude($min = -180, $max = 180),
        'apiario_id' => faker->randomNumber(3),
    ];
});


