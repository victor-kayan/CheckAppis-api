<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Cidade;

class CidadeController extends Controller
{
    private $cidade;

    public function __construct(Cidade $cidade)
    {
        $this->cidade = $cidade;
    }

    public function cidadesByUf($uf)
    {
        $this->cidade = $this->cidade->where('uf', 'ilike', '%'.strtolower($uf).'%')->orderBy('nome', 'ASC')->get();

        return response()->json([
            'message' => 'Lista de cidades do estado selecionado',
            'cidades' => $this->cidade,
        ]);
    }
}
