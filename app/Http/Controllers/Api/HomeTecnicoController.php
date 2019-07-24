<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\Apiario;
use App\Model\Colmeia;

class HomeTecnicoController extends Controller
{
    public function index()
    {
        $qtd_apiarios = $this->qtdApiariosByTecnico();
        $qt_colmeias = $this->qtdColmeiasByTecnico();
        $qtd_apicultores = $this->qtdApicultoresByTecnico();

        return response()->json([
            'message' => 'Sucesso',
            'data' => [
                'qtd_apiarios' => $qtd_apiarios,
                'qtd_colmeias' => $qt_colmeias,
                'qtd_apicultores' => $qtd_apicultores,
            ],
        ]);
    }

    public function qtdApicultoresByTecnico()
    {
        $qtd = User::where('tecnico_id', auth()->user()->id)->count();

        return $qtd;
    }

    public function qtdApiariosByTecnico()
    {
        $qtd = Apiario::where('tecnico_id', auth()->user()->id)->count();

        return $qtd;
    }

    public function qtdColmeiasByTecnico()
    {
        $qtd = Colmeia::whereHas('apiario', function ($query) {
            $query->where('tecnico_id', auth()->user()->id);
        })->count();

        return $qtd;
    }
}
