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

        factory(App\Model\Apiario::class, 3)->create()->each(function($u) {
            $u->issues()->save(factory(App\Issues::class)->make());
        });
    }
}