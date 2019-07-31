<?php

use App\Model\Colmeia;
use Faker\Generator as Faker;
use App\Model\Apiario;

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
        'apiario_id' => Apiario::all()->random()->id,
        'foto' => 'https://s3-sa-east-1.amazonaws.com/beecheck/images/default.png',
    ];
});
