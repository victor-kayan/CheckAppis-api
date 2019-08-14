<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        Model::unguard();

        //POPULAR TABELA DE ESTADOS E CIDADES//
        echo '*** RODANDO SEEDERS ***    ';

        $this->call('EstadoCidadeSeeder');
        $this->call('RoleTableSeeder');
        $this->call('UserTableSeeder');
        // $this->call('ApiarioSeeder');

        Model::reguard();

        // factory(App\Model\Colmeia::class, 5)->create();
        // factory(App\Model\Intervencao::class, 5)->create();
        // factory(App\Model\IntervencaoColmeia::class, 15)->create();
    }
}
