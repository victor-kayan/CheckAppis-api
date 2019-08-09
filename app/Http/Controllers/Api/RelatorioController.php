<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\IntervencaoColmeia;
use App\Model\TokenRelatorios;
use Illuminate\Http\Request;
use App\Model\VisitaApiario;
use App\Model\VisitaColmeia;
use App\Model\Intervencao;
use App\Model\Apiario;
use App\Model\Colmeia;
use Carbon\Carbon;

class RelatorioController extends Controller
{
    public function isCheckToken($token_relatorio, $tecnico_id)
    {
        $token_valido = TokenRelatorios::where(
            ['token_relatorios' => $token_relatorio],
            ['tecnico_id' => $tecnico_id]
        )->first();

        if ($token_valido) {
            return true;
        }

        return false;
    }

    public function responseRelatorio($acao, $pdf)
    {
        return  ($acao == 'visualizar') ? $pdf->stream() : $pdf->download();
    }

    public function indexVisitasApiarios($tecnico_id)
    {
        $visitas = VisitaApiario::whereHas('apiario', function ($query) use ($tecnico_id) {
            $query->where('tecnico_id', $tecnico_id);
        })->with('apiario')->orderBy('created_at', 'DESC')->get();

        return $visitas;
    }

    public function indexVisitasColmeias($tecnico_id)
    {
        $visitas = VisitaColmeia::whereHas('colmeia', function ($query) use ($tecnico_id) {
            $query->whereHas('apiario', function ($query2) use ($tecnico_id) {
                $query2->where('tecnico_id', $tecnico_id);
            });
        })->with(['colmeia.apiario'])->orderBy('created_at', 'DESC')->get();

        return $visitas;
    }

    public function indexApiarios($tecnico_id)
    {
        $apiarios = Apiario::where('tecnico_id', $tecnico_id)
                ->with(['endereco.cidade', 'apicultor', 'tecnico'])
                ->orderBy('updated_at', 'DESC')->get();

        return $apiarios;
    }

    public function indexIntervencaoApiarios($tecnico_id, $situacao)
    {
        $intervencoes = null;
        if ($situacao == null) {
            $intervencoes = Intervencao::whereHas('apiario', function ($query) use ($tecnico_id) {
                $query->where('tecnico_id', $tecnico_id);
            })->with('apiario')->orderBy('created_at', 'DESC')->get();
        } else {
            $intervencoes = Intervencao::whereHas('apiario', function ($query) use ($tecnico_id) {
                $query->where('tecnico_id', $tecnico_id);
            })->where('is_concluido', true)->with('apiario')->orderBy('created_at', 'DESC')->get();
        }

        $intervencoes = $this->formatData($intervencoes);

        return $intervencoes;
    }

    public function indexIntervencaoColmeias($tecnico_id, $situacao)
    {
        $intervencoes = IntervencaoColmeia::whereHas('colmeia', function ($query) use ($tecnico_id) {
            $query->whereHas('apiario', function ($query2) use ($tecnico_id) {
                $query2->where('tecnico_id', $tecnico_id);
            });
        })->with('colmeia.apiario')->orderBy('created_at', 'DESC')->get();

        $intervencoes = $this->formatData($intervencoes);

        return $intervencoes;
    }

    public function formatData($intervencoes)
    {
        foreach ($intervencoes as $i) {
            $data_ini_format = new Carbon($i->data_inicio);
            $i->data_inicio = $data_ini_format->format('d-m-Y');

            $data_fim_format = new Carbon($i->data_fim);
            $i->data_fim = $data_fim_format->format('d-m-Y');
        }

        return $intervencoes;
    }

    public function gerarRelatorioVisitas(Request $request)
    {
        if ($this->isCheckToken($request->token_relatorio, $request->tecnico_id)) {
            switch ($request->tipo_visita) {
                case 'apiario':
                    $visitas = $this->indexVisitasApiarios($request->tecnico_id);
                    $total_visitas = count($visitas);

                    $pdf = \PDF::loadView('relatorio.relatorioVisitasApiario',
                        compact('visitas', 'total_visitas'))->setPaper('a4', $request->orientacao_papel);

                    return $this->responseRelatorio($request->acao, $pdf);
                break;
                case 'colmeia':
                    $visitas = $this->indexVisitasColmeias($request->tecnico_id);
                    $total_visitas = count($visitas);

                    $pdf = \PDF::loadView('relatorio.relatorioVisitasColmeia',
                        compact('visitas', 'total_visitas'))->setPaper('a4', 'landscape');

                    return $this->responseRelatorio($request->acao, $pdf);
                break;
            }
        }

        return view('errors.404');
    }

    public function gerarRelatorioApiario(Request $request)
    {
        if ($this->isCheckToken($request->token_relatorio, $request->tecnico_id)) {
            $apiarios = $this->indexApiarios($request->tecnico_id);
            $total_apiarios = count($apiarios);
            $total_colmeias = 0;

            foreach ($apiarios as $a) {
                $qtd_colmeias = Colmeia::where('apiario_id', $a->id)->count();
                $a->qtd_colmeias = $qtd_colmeias;
                $total_colmeias += $qtd_colmeias;
            }

            $pdf = \PDF::loadView('relatorio.relatorioApiario',
            compact('tecnico', 'apiarios', 'total_colmeias', 'total_apiarios'))
            ->setPaper('a4', $request->orientacao_papel);

            return $this->responseRelatorio($request->acao, $pdf);
        }

        return view('errors.404');
    }

    public function gerarRelatorioIntervencoes(Request $request)
    {
        if ($this->isCheckToken($request->token_relatorio, $request->tecnico_id)) {
            $situacao_formatada = $this->formatarSituacao($request->situacao);
            $qtd_intevercoes_con = $this->qtdIntervencoaPorSituacao(true, $request);
            $qtd_intevercoes_nao_con = $this->qtdIntervencoaPorSituacao(false, $request);

            if ($request->situacao == 'todas_intervencoes') {
                if ($request->tipo_intervencao == 'apiario') {
                    $intervencoes = $this->indexIntervencaoApiarios($request->tecnico_id, null);
                    $total_intervencoes = count($intervencoes);
                    $situacao = $request->situacao;

                    $pdf = \PDF::loadView('relatorio.relatorioIntervencaoApiario',
                        compact('intervencoes', 'total_intervencoes', 'situacao_formatada'))
                        ->setPaper('a4', $request->orientacao_papel);

                    return $this->responseRelatorio($request->acao, $pdf);
                }
                if ($request->tipo_intervencao == 'colmeia') {
                    $intervencoes = $this->indexIntervencaoColmeias($request->tecnico_id, null);
                    $total_intervencoes = count($intervencoes);

                    $pdf = \PDF::loadView('relatorio.relatorioIntervencaoColmeia',
                        compact('intervencoes', 'total_intervencoes', 'situacao_formatada'))
                        ->setPaper('a4', $request->orientacao_papel);

                    return $this->responseRelatorio($request->acao, $pdf);
                }
            }
            if ($request->situacao == 'is_concluidas') {
                if ($request->tipo_intervencao == 'apiario') {
                    $intervencoes = $this->indexIntervencaoApiarios($request->tecnico_id, true);
                    $situacao = $request->situacao;
                    $total_intervencoes = count($intervencoes);

                    $pdf = \PDF::loadView('relatorio.relatorioIntervencaoApiario',
                        compact('intervencoes', 'total_intervencoes', 'situacao_formatada'))
                        ->setPaper('a4', $request->orientacao_papel);

                    return $this->responseRelatorio($request->acao, $pdf);
                }
                if ($request->tipo_intervencao == 'colmeia') {
                    $intervencoes = $this->indexIntervencaoColmeias($request->tecnico_id, true);
                    $total_intervencoes = count($intervencoes);

                    $pdf = \PDF::loadView('relatorio.relatorioIntervencaoColmeia',
                        compact('intervencoes', 'total_intervencoes', 'situacao_formatada'))
                        ->setPaper('a4', $request->orientacao_papel);

                    return $this->responseRelatorio($request->acao, $pdf);
                }
            }
            if ($request->situacao == 'is_nao_concluidas') {
                if ($request->tipo_intervencao == 'apiario') {
                    $intervencoes = $this->indexIntervencaoApiarios($request->tecnico_id, false);
                    $situacao = $request->situacao;
                    $total_intervencoes = count($intervencoes);

                    $pdf = \PDF::loadView('relatorio.relatorioIntervencaoApiario',
                        compact('intervencoes', 'total_intervencoes', 'situacao_formatada'))
                        ->setPaper('a4', $request->orientacao_papel);

                    return $this->responseRelatorio($request->acao, $pdf);
                }
                if ($request->tipo_intervencao == 'colmeia') {
                    $intervencoes = $this->indexIntervencaoColmeias($request->tecnico_id, false);
                    $total_intervencoes = count($intervencoes);

                    $pdf = \PDF::loadView('relatorio.relatorioIntervencaoColmeia',
                        compact('intervencoes', 'total_intervencoes', 'situacao_formatada'))
                        ->setPaper('a4', $request->orientacao_papel);

                    return $this->responseRelatorio($request->acao, $pdf);
                }
            }
        }

        return view('errors.404');
    }

    public function qtdIntervencoaPorSituacao($situacao, $request)
    {
        $qtd_intevercoes = Intervencao::whereHas('apiario', function ($query) use ($request) {
            $query->where('tecnico_id', 4);
        })->where('is_concluido', $situacao)->count();

        return $qtd_intevercoes;
    }

    public function formatarSituacao($situacao)
    {
        switch ($situacao) {
            case 'is_concluidas':
                return 'concluidas';
            break;
            case 'is_nao_concluidas':
                return 'não concluidas';
            break;
            case 'todas_intervencoes':
                return '';
        }
    }
}
