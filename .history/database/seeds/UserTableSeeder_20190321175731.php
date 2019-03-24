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

        $apicultor1 = new User();
        $apicultor1->name = 'apicultor Name 1';
        $apicultor1->email = 'apicultor@gmail.com';
        $apicultor1->password = bcrypt('123456');
        $apicultor1->tecnico_id = '4';
        $apicultor1->foto = ''
        $apicultor1->save();
        $apicultor1->roles()->attach($role_apicultor);

        $apicultor2 = new User();
        $apicultor2->name = 'apicultor Name 2';
        $apicultor2->email = 'apicultor1@gmail.com';
        $apicultor2->password = bcrypt('123456');
        $apicultor2->foto = 'http://192.168.200.253/storage/images/user2.';
        $apicultor2->save();
        $apicultor2->roles()->attach($role_apicultor);

        $apicultor3 = new User();
        $apicultor3->name = 'apicultor Name 3';
        $apicultor3->email = 'apicultor2@gmail.com';
        $apicultor3->password = bcrypt('123456');
        $apicultor3->tecnico_id = '4';
        $apicultor3->save();
        $apicultor3->roles()->attach($role_apicultor);

        $tecnico = new User();
        $tecnico->name = 'tecnico Name';
        $tecnico->email = 'tecnico@gmail.com';
        $tecnico->password = bcrypt('123456');
        $tecnico->save();
        $tecnico->roles()->attach($role_tecnico);
    }
}