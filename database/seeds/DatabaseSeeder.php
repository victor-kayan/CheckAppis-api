<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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
    }
}
