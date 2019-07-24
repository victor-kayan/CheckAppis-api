<?php

use Illuminate\Database\Seeder;
use App\Model\Cidade;
use App\Model\Estado;

class EstadoCidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $result = new \GuzzleHttp\Client();
        $response = $result->get('https://gist.githubusercontent.com/letanure/3012978/raw/36fc21d9e2fc45c078e0e0e07cce3c81965db8f9/estados-cidades.json');
        $estados = collect(json_decode($response->getBody()->getContents()))->collapse();

        foreach ($estados as $estado) {
            $estadoDB = new Estado();
            foreach ($estado->cidades as $cidade) {
                $cidadeDB = new Cidade();
                $cidadeDB->nome = $cidade;
                $cidadeDB->uf   = $estado->sigla;
                $cidadeDB->save();
            }
            $estadoDB->uf    = $estado->sigla;
            $estadoDB->save();
        }
    }
}
