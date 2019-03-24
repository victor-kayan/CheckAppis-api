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

$factory->define(App\Model\IntervencaoColmeia::class, function (Faker $faker) {
    return [
        'descricao' => $faker->name,
        'data_inicio' => $faker->dateTimeBetween('now', '+1 days'),
        'data_fim' => $faker->dateTimeBetween('now', '+30 days'),
        'intervencao_id' => App\Model\Intervencao::all()->random()->id,
    ];
});


