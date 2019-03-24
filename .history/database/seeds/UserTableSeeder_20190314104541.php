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
        $apicultor->email = 'apicultor@gmail.com';
        $apicultor->password = bcrypt('123456');
        $apicultor->save();
        $apicultor->roles()->attach($role_apicultor);

        $tecnico = new User();
        $tecnico->name = 'tecnico Name';
        $tecnico->email = 'tecnico@gmail.com';
        $tecnico->password = bcrypt('123456');
        $tecnico->save();
        $tecnico->roles()->attach($role_tecnico);
    }
}