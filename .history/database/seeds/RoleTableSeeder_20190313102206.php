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
        $role_apicultor->name = 'apicultor';
        $role_apicultor->description = 'O apicultor dono apiario';
        $role_apicultor->save();

        $role_tecnico = new Role();
        $role_tecnico->name = 'tecnico';
        $role_tecnico->description = 'O tecnico responsavel pelos apiarios';
        $role_tecnico->save();
    }
}
