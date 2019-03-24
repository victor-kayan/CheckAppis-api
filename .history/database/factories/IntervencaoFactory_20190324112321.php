<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Carbon\Carbon;
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

$factory->define(App\Model\\App\Model\Intervencao::class, function (Faker $faker) {
    return [
        'descricao' => $faker->name,
        'data_inicio' => $faker->dateTime($max = 'now', $timezone = null),
        'data_fim' => $faker->dateTime($max = 'now', $timezone = null),
        'apiario_id' => App\Model\Apiario::all()->random()->id,
        'tecnico_id' => App\Model\User::all()->random()->id,
    ];
});


