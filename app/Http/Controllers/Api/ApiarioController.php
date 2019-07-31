<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Apiario;
use App\Model\Colmeia;
use App\Model\Endereco;
use App\Model\Cidade;

class ApiarioController extends Controller
{
    private $apiario;

    public function __construct(Apiario $apiario)
    {
        $this->apiario = $apiario;
        $this->middleware('role:tecnico', ['except' => ['apiariosUserLogado']]);
    }

    public function index()
    {
        $this->apiario = $this->apiario->where('tecnico_id', auth()->user()->id)
            ->with(['endereco', 'apicultor', 'tecnico'])
            ->orderBy('updated_at', 'DESC')->get();

        foreach ($this->apiario as $a) {
            $qtdColmeias = Colmeia::where('apiario_id', $a->id)->count();
            $a->qtdColmeias = $qtdColmeias;
        }

        return response()->json([
            'message' => 'Lista de apiarios',
            'apiarios' => $this->apiario,
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    public function apiariosUserLogado()
    {
        $this->apiario = $this->apiario->where('user_id', auth()->user()->id)->with('colmeias')->get();

        return response()->json([
            'message' => 'Lista de apiarios',
            'apiarios' => $this->apiario,
        ], 200);
    }

    public function storeAnReturnEndereco($request)
    {
        $cidade = Cidade::where(['nome' => $request->nome_cidade, 'uf', $request->uf])->first();

        $endereco = Endereco::create([
            'cidade_id' => $cidade->id,
            'logradouro' => $request->logradouro,
        ]);

        return $endereco;
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'descricao' => 'required|string|max:50',
            'latitude' => 'required',
            'longitude' => 'required',
            'apicultor_id' => 'required|exists:users,id',
            'logradouro' => 'required|max:70',
        ]);

        \DB::transaction(function () use ($request) {
            $endereco = $this->storeAnReturnEndereco($request);

            $this->apiario = Apiario::create([
                'nome' => $request->nome,
                'descricao' => $request->descricao,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'endereco_id' => $endereco->id,
                'apicultor_id' => $request->apicultor_id,
                'tecnico_id' => $request->user()->id,
            ]);
        });

        return response()->json([
            'message' => 'Apiário cadastrado com sucesso',
            'apiario' => $this->apiario,
        ], 201);
    }

    public function show($id)
    {
        $this->apiario = $this->apiario->where('id', $id)
            ->with(['endereco', 'apicultor', 'tecnico'])
            ->orderBy('updated_at', 'DESC')->first();

        $qtdColmeias = Colmeia::where('apiario_id', $this->apiario->id)->count();
        $this->apiario->qtd_Colmeias = $qtdColmeias;

        return response()->json([
            'message' => 'Detalhes de um apiario',
            'apiario' => $this->apiario,
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    public function update(Request $request, $id)
    {
        return $request;
        $this->apiario = $this->apiario->findApiario($id);

        $request->validate([
            'nome' => 'required|string',
            'endereco' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $this->apiario->update($request->all());

        return response()->json([
            'message' => 'Apiário alterado com sucesso',
            'apario' => $this->apiario,
        ], 200);
    }

    public function destroy($id)
    {
        $this->apiario = $this->apiario->findApiario($id);

        $deleted = $this->apiario->delete();

        if ($deleted) {
            return response()->json([], 204);
        } else {
            return response()->json([
                'error' => 'Recurso não pode ser excluido',
            ], 500);
        }
    }
}
