<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Apiario;
use App\Model\Colmeia;
use App\Model\Endereco;
use App\Model\Cidade;
use Illuminate\Http\Request;

class ApiarioController extends Controller
{
    private $apiario;

    public function __construct(Apiario $apiario)
    {
        $this->apiario = $apiario;
        $this->middleware('role:tecnico', ['except' => ['apiariosUserLogado', 'getApiariosWithColmeiasWithIntervencoes', 'countApairosByUser']]);
    }

    public function countApairosByUser()
    {
        return response()->json([
            'count_apiarios' => Apiario::where('user_id', auth()->user()->id)->count(),
        ]);
    }

    public function index()
    {
        $this->apiario = $this->apiario->where('tecnico_id', auth()->user()->id)
            ->with(['endereco.cidade', 'apicultor', 'tecnico'])
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

    public function getApiariosWithColmeiasWithIntervencoes()
    {
        $apiarios = Apiario::whereHas('colmeias', function ($query) {
            $query->whereHas('intervencaoColmeias', function ($query2) {
                $query2->where('is_concluido', false);
            });
        })->where('user_id', auth()->user()->id)->get();

        return response()->json([
            'message' => 'Lista de apiarios',
            'apiarios' => $apiarios,
        ]);
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
        $maps = 'https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyA3byNpUcao4ZQud-zGppXCjHSZVOaoygI&address='.$request->latitude.','.$request->longitude;

        $result = new \GuzzleHttp\Client();
        $response = $result->get($maps);
        $localizacao = collect(json_decode($response->getBody()->getContents()))->collapse();

        foreach ($localizacao as $localizacao) {
            if ($localizacao->types[0] == 'postal_code' && count($localizacao->types) < 2) {
                $cep = $localizacao->address_components[0]->long_name;
                $cep_convertido = str_replace('-', '', $cep);
                $cidade = $result->get('https://viacep.com.br/ws/'.$cep_convertido.'/json/');
                $cidade_convertida = json_decode($cidade->getBody()->getContents());
                $cidade = Cidade::where(['nome' => $cidade_convertida->localidade, 'uf' => $cidade_convertida->uf])->first();

                if ($cidade) {
                    $endereco = Endereco::create([
                        'cidade_id' => $cidade->id,
                        'logradouro' => $request->logradouro,
                    ]);

                    return $endereco;
                }
            }
        }

        abort(422, 'Houve algum problema com o local selecionado');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'descricao' => 'required|string|max:50',
            'latitude' => 'required',
            'longitude' => 'required',
            'apicultor_id' => 'required|exists:users,id',
        ]);

        try {
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
        } catch (Exception $e) {
            abort(422, 'Houve algum problema. Por favor aguarde');
        }

        return response()->json([
            'message' => 'Apiário cadastrado com sucesso',
            'apiario' => $this->apiario,
        ], 201);
    }

    public function show($id)
    {
        $this->apiario = $this->apiario->where('id', $id)
            ->with(['endereco.cidade', 'apicultor', 'tecnico'])
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
        $request->validate([
            'nome' => 'required|string',
            'logradouro' => 'required|string',
            'apicultor_id' => 'required',
        ]);

        $this->apiario = $this->apiario->where('id', $id)->with('endereco')->first();
        Endereco::where('id', $this->apiario->endereco->id)->update(['logradouro' => $request->logradouro]);

        if (is_string($request->apicultor_id)) {
            $this->apiario->update([
                'nome' => $request->nome,
                'descricao' => $request->descricao,
            ]);
        } else {
            $this->apiario->update($request->all());
        }

        return response()->json([
            'message' => 'Apiário alterado com sucesso',
            'apiário' => $this->apiario,
        ], 200);
    }

    public function destroy($id)
    {
        return response()->json([
            'data' => $this->apiario->find($id)->delete(),
            'message' => 'Apiário removido com sucesso',
        ], 204);
    }
}
