<?php

use Illuminate\Database\Seeder;
use App\Model\Apiario;
use App\Model\Endereco;

class ApiarioSeeder extends Seeder
{
    public function run()
    {
        $endereco = Endereco::create([
            'cidade_id' => 3787,
            'logradouro' => 'Sitio Belo Monte',
        ]);

        Apiario::create([
            'nome' => 'Apiário Bela Flora',
            'descricao' => 'O melhor mel da região',
            'latitude' => -6.1123,
            'longitude' => -38.2052,
            'apicultor_id' => 1,
            'tecnico_id' => 4,
            'endereco_id' => $endereco->id,
        ]);

        Apiario::create([
            'nome' => 'Apiário Santa Necilia',
            'descricao' => 'O melhor mel da região',
            'latitude' => -6.02457,
            'longitude' => -37.9845,
            'apicultor_id' => 1,
            'tecnico_id' => 4,
            'endereco_id' => $endereco->id,
        ]);

        Apiario::create([
            'nome' => 'Florencio Avelar',
            'descricao' => 'O melhor mel da região',
            'latitude' => -5.99457,
            'longitude' => -37.9421,
            'apicultor_id' => 1,
            'tecnico_id' => 4,
            'endereco_id' => $endereco->id,
        ]);

        Apiario::create([
            'nome' => 'Cachorrão do Brega',
            'descricao' => 'O melhor mel da região',
            'latitude' => -6.21481,
            'longitude' => -38.4968,
            'apicultor_id' => 1,
            'tecnico_id' => 4,
            'endereco_id' => $endereco->id,
        ]);
    }
}
