<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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

        Model::reguard();
    }
}
