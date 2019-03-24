<?php

use Illuminate\Database\Seeder;
use App\Model\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_apicultor = new Role();
        $role_apicultor->name = 'apicultor 1';
        $role_apicultor->description = 'O apicultor dono apiario';
        $role_apicultor->save();

        $role_apicultor2 = new Role();
        $role_apicultor2->name = 'apicultor 2';
        $role_apicultor2->description = 'O apicultor dono apiario';
        $role_apicultor2->save();

        $role_apicultor3 = new Role();
        $role_apicultor3->name = 'apicultor 3';
        $role_apicultor3->description = 'O apicultor dono apiario';
        $role_apicultor3->save();

        $role_tecnico = new Role();
        $role_tecnico->name = 'tecnico';
        $role_tecnico->description = 'O tecnico responsavel pelos apiarios';
        $role_tecnico->save();
    }
}
