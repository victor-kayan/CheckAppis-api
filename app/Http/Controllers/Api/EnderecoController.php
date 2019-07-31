<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Endereco;

class EnderecoController extends Controller
{
    private $endereco;

    public function __construct(Endereco $endereco)
    {
        $this->endereco = $endereco;
    }

    public function store(Request $request)
    {
        $request->validate([
            'logradouro' => 'required|max:100',
            'cidade_id' => 'required|exists:cidades,id',
        ]);

        return $this->endereco->create($request->all());
    }
}
