<?php

use Illuminate\Database\Seeder;
use App\Model\Role;
use App\Model\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Chamando o Seeder de Roles
        $this->call(RoleTableSeeder::class);
        // Chamando o Seeder de Users
        $this->call(UserTableSeeder::class);
    }
}
