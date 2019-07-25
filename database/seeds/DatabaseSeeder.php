<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        //POPULAR TABELA DE ESTADOS E CIDADES//
        echo ('*** RODANDO SEEDERS ***    ');

        $this->call('RoleTableSeeder');
        $this->call('UserTableSeeder');
        $this->call('EstadoCidadeSeeder');

        Model::reguard();

        factory(App\Model\Apiario::class, 5)->create();
        factory(App\Model\Colmeia::class, 5)->create();
        factory(App\Model\Intervencao::class, 5)->create();
        factory(App\Model\IntervencaoColmeia::class, 15)->create();

    }
}
