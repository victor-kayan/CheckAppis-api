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
        $role_employee = new Role();
        $role_employee->name = ‘apicultor’;
        $role_employee->description = ‘O apicultor dono do apiario’;
        $role_employee->save();

        $role_manager = new Role();
        $role_manager->name = ‘tecnico’;
        $role_manager->description = ‘O tecnico responsavel pelos apiarios’;
        $role_manager->save();
    }
}
