<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\TokenRelatorios;
use Illuminate\Http\Request;
use App\Model\Apiario;
use App\Model\Colmeia;
use App\Model\User;
use App\Model\VisitaApiario;
use App\Model\VisitaColmeia;

class RelatorioController extends Controller
{
    public function gerarRelatorioVisitas(Request $request)
    {
        $token_valido = TokenRelatorios::where('token_relatorios', $request->token_relatorio)->first();

        if ($token_valido) {
            if ($request->tipo_visita == 'apiario') {
                $visitas = VisitaApiario::whereHas('apiario', function ($query) {
                    $query->where('tecnico_id', 4);
                })->with('apiario')->get();

                $pdf = \PDF::loadView('relatorio.relatorioVisitasApiario',
                    compact('visitas'))->setPaper('a4', 'portrait');

                if ($request->acao == 'visualizar') {
                    return $pdf->stream();
                }

                return $pdf->download();
            } elseif ($request->visita == 'colmeia') {
                $visitas = VisitaColmeia::with('colmeia')->get();
                $pdf = \PDF::loadView('relatorio.relatorioVisitasColmeia',
                    compact('visitas'))->setPaper('a4', 'portrait');

                if ($request->acao == 'visulizar') {
                    return $pdf->stream();
                }

                return $pdf->download();
            }
        }

        return view('errors.404');
    }

    public function gerarRelatorioApiario(Request $request)
    {
        $token_valido = TokenRelatorios::where('token_relatorios', $request->token_relatorio)->first();

        if ($token_valido) {
            $tecnico = User::find(4);

            $apiarios = Apiario::where('tecnico_id', 4)
                ->with(['endereco.cidade', 'apicultor', 'tecnico'])
                ->orderBy('updated_at', 'DESC')->get();
            $total_colmeias = 0;
            $total_apiarios = $this->qtdApiarios($apiarios);

            foreach ($apiarios as $a) {
                $qtd_colmeias = Colmeia::where('apiario_id', $a->id)->count();
                $a->qtd_colmeias = $qtd_colmeias;
                $total_colmeias += $qtd_colmeias;
            }

            $pdf = \PDF::loadView('relatorio.relatorioApiario',
                compact('tecnico', 'apiarios', 'total_colmeias', 'total_apiarios'))->setPaper('a4', 'portrait');

            if ($request->acao == 'visualizar') {
                return $pdf->stream();
            }

            return $pdf->download();
        }

        return view('errors.404');
    }

    public function qtdApiarios($apiarios)
    {
        return count($apiarios);
    }
}
