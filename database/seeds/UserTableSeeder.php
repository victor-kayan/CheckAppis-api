<?php

use Illuminate\Database\Seeder;
use App\Model\Endereco;
use App\Model\Role;
use App\Model\User;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        $role_apicultor = Role::where('name', 'apicultor')->first();
        $role_tecnico = Role::where('name', 'tecnico')->first();

        $endereco = Endereco::create([
            'cidade_id' => 3787,
            'logradouro' => 'Sitio Belo Monte',
        ]);

        $endereco1 = Endereco::create([
            'cidade_id' => 3789,
            'logradouro' => 'Francisco Rodrigues',
        ]);

        $endereco2 = Endereco::create([
            'cidade_id' => 2896,
            'logradouro' => 'Mariano Suassuna',
        ]);

        $endereco3 = Endereco::create([
            'cidade_id' => 3756,
            'logradouro' => 'Maria José',
        ]);

        $apicultor1 = new User();
        $apicultor1->name = 'Claudio Rodrigo';
        $apicultor1->email = 'claudio@gmail.com';
        $apicultor1->password = bcrypt('123456');
        $apicultor1->tecnico_id = '4';
        $apicultor1->endereco_id = $endereco->id;
        $apicultor1->telefone = '(84) 99996-5566';
        $apicultor1->foto = 'https://s3-sa-east-1.amazonaws.com/beecheck/images/apicultor-default.jpg';
        $apicultor1->save();
        $apicultor1->roles()->attach($role_apicultor);

        $apicultor2 = new User();
        $apicultor2->name = 'Rodrigo Mendes';
        $apicultor2->email = 'rodrigo@gmail.com';
        $apicultor2->password = bcrypt('123456');
        $apicultor2->tecnico_id = '4';
        $apicultor2->endereco_id = $endereco1->id;
        $apicultor2->telefone = '(86) 99996-5566';
        $apicultor2->foto = 'https://s3-sa-east-1.amazonaws.com/beecheck/images/apicultor-default.jpg';
        $apicultor2->save();
        $apicultor2->roles()->attach($role_apicultor);

        $apicultor3 = new User();
        $apicultor3->name = 'Mario José';
        $apicultor3->email = 'mario@gmail.com';
        $apicultor3->password = bcrypt('123456');
        $apicultor3->tecnico_id = '4';
        $apicultor3->endereco_id = $endereco2->id;
        $apicultor3->telefone = '(82) 99996-5566';
        $apicultor3->foto = 'https://s3-sa-east-1.amazonaws.com/beecheck/images/apicultor-default.jpg';
        $apicultor3->save();
        $apicultor3->roles()->attach($role_apicultor);

        $tecnico = new User();
        $tecnico->name = 'Abreu Neto';
        $tecnico->email = 'abreu@gmail.com';
        $tecnico->password = bcrypt('123456');
        $tecnico->foto = 'https://s3-sa-east-1.amazonaws.com/beecheck/images/apicultor-default.jpg';
        $tecnico->telefone = '(84) 99996-5566';
        $tecnico->endereco_id = $endereco3->id;
        $tecnico->save();
        $tecnico->roles()->attach($role_tecnico);
    }
}
