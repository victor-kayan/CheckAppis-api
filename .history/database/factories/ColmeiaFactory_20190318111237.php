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
        'apiario_id' => $faker->randomElement([1,5]),
        'foto' => 'http://192.168.200.253/storage/images/beehive.png'
    ];
});


