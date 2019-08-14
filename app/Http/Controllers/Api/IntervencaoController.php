<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\IntervencaoColmeia;
use Illuminate\Http\Request;
use App\Model\Intervencao;
use App\Model\User;

class IntervencaoController extends Controller
{
    public function __construct(Intervencao $intervencao)
    {
        $this->$intervencao = $intervencao;
    }

    public function index()
    {
        $intervencao = Intervencao::where('tecnico_id', auth()->user()->id)
            ->with('apiario')->orderBy('updated_at', 'DESC')->paginate(10);

        return $intervencao;
    }

    public function countIntervencoesByUser()
    {
        $id = auth()->user()->id;
        $countIntervencoes = Intervencao::whereHas('apiario', function ($query) use ($id) {
            $query->where('apicultor_id', $id);
        })->where('is_concluido', false)->count();

        $countIntervencoesColmeias = IntervencaoColmeia::whereHas('colmeia', function ($query) use ($id) {
            $query->whereHas('apiario', function ($query2) use ($id) {
                $query2->where('apicultor_id', $id);
            });
        })->where('is_concluido', false)->count();

        return response()->json([
            'count_intervencoes' => $countIntervencoes + $countIntervencoesColmeias,
        ]);
    }

    public function indexByUserLogged()
    {
        $intervencoes = Intervencao::whereHas('apiario', function ($query) {
            $query->where('apicultor_id', auth()->user()->id);
        })->where('is_concluido', false)->with('apiario')->orderBy('created_at', 'DESC')->get();

        foreach ($intervencoes as $intervencao) {
            $intervencao->tecnico = User::find($intervencao->tecnico_id);
        }

        return response()->json([
            'message' => 'Lista de irvencaos',
            'intervencoes' => $intervencoes,
        ], 200);
    }

    public function concluirIntervencao($intervencao_id)
    {
        Intervencao::findOrFail($intervencao_id)->update(['is_concluido' => true]);

        return response()->json([
            'message' => 'Itervencao concluida',
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string|max:200',
            'data_inicio' => 'required|date|before_or_equal:data_fim',
            'data_fim' => 'required|date',
            'apiario_id' => 'required|exists:apiarios,id',
        ]);

        $intervencoes = Intervencao::create([
            'descricao' => $request->descricao,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'tecnico_id' => auth()->user()->id,
            'is_concluido' => false,
            'apiario_id' => $request->apiario_id,
        ]);

        return response()->json([
            'message' => 'Intervenção cadastrada com sucesso',
            'data' => $intervencoes,
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
        Intervencao::find($id)->delete();

        return response()->json([], 204);
    }
}
