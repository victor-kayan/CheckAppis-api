<?php

use Illuminate\Database\Seeder;
use App\Model\User;
use App\Model\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_apicultor = Role::where('name', 'apicultor')->first();
        $role_tecnico  = Role::where('name', 'tecnico')->first();

        $apicultor = new User();
        $apicultor->name = 'apicultor Name';
        $apicultor->email = 'apicultor@example.com';
        $apicultor->password = bcrypt('secret');
        $apicultor->save();

        $apicultor->roles()->attach($role_apicultor);

        $tecnico = new User();
        $tecnico->name = 'tecnico Name';
        $tecnico->email = 'tecnico@example.com';
        $tecnico->password = bcrypt('secret');
        $tecnico->save();

        $tecnico->roles()->attach($role_tecnico);
    }
}