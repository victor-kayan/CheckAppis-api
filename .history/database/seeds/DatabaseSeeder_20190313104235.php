<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // // Role comes before User seeder here.
        // $this->call(RoleTableSeeder::class);
        // // User seeder will use the roles above created.
        // $this->call(UserTableSeeder::class);

        $role_apicultor = new Role();
        $role_apicultor->name = 'apicultor';
        $role_apicultor->description = 'O apicultor dono apiario';
        $role_apicultor->save();

        $role_tecnico = new Role();
        $role_tecnico->name = 'tecnico';
        $role_tecnico->description = 'O tecnico responsavel pelos apiarios';
        $role_tecnico->save();

        $role_apicultor = Role::where('name', 'apicultor')->first();
        $role_tecnico  = Role::where('name', 'tecnico')->first();

        $apicultor = new User();
        $apicultor->name = 'apicultor Name';
        $apicultor->email = 'apicultor@example.com';
        $apicultor->password = bcrypt('secret');
        $apicultor->save();
        $apicultor->roles()->attach($role_apicultor);

        print($apicultor->roles()->attach($role_apicultor));

        $tecnico = new User();
        $tecnico->name = 'tecnico Name';
        $tecnico->email = 'tecnico@example.com';
        $tecnico->password = bcrypt('secret');
        $tecnico->save();
        $tecnico->roles()->attach($role_tecnico);

    }
}
