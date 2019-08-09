<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\IntervencaoColmeia;
use Illuminate\Http\Request;
use App\Model\User;

class IntervencaoColmeiaController extends Controller
{
    private $intervencao;

    public function __construct(IntervencaoColmeia $intervencao)
    {
        $this->$intervencao = $intervencao;
    }

    public function index()
    {
        $intervencoes = IntervencaoColmeia::whereHas('colmeia', function ($query) {
            $query->whereHas('apiario', function ($query2) {
                $query2->where('tecnico_id', auth()->user()->id);
            });
        })->with('colmeia.apiario')->orderBy('created_at', 'DESC')->paginate(10);

        return $intervencoes;
    }

    public function indexByApiario($apiario_id)
    {
        $intervencoes = IntervencaoColmeia::whereHas('intervencao', function ($query) use ($apiario_id) {
            $query->where('apiario_id', $apiario_id);
        })->where('is_concluido', false)->with(['intervencao', 'colmeia'])->orderBy('created_at', 'DESC')->get();

        foreach ($intervencoes as $intervencao) {
            $intervencao->tecnico = User::find($intervencao->intervencao->tecnico_id);
        }

        return response()->json([
            'message' => 'Lista de intervencaos',
            'intervencoes' => $intervencoes,
        ], 200);
    }

    public function concluirIntervencao($intervencao_id)
    {
        $intervencao = IntervencaoColmeia::findOrFail($intervencao_id);
        $intervencao->is_concluido = true;
        $intervencao->save();

        return response()->json([
            'message' => 'Itervencao concluida',
            'intervencao' => $intervencao,
        ], 200);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string|max:200',
            'data_inicio' => 'required|date|before_or_equal:data_fim',
            'data_fim' => 'required|date',
            'colmeia_id' => 'required|exists:colmeias,id',
        ]);

        $intervencao = IntervencaoColmeia::create([
            'descricao' => $request->descricao,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'colmeia_id' => $request->colmeia_id,
        ]);

        return response()->json([
            'message' => 'Intervenção cadastrada com sucesso',
            'data' => $intervencao,
        ]);
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
        IntervencaoColmeia::find($id)->delete();

        return response()->json([], 204);
    }
}
