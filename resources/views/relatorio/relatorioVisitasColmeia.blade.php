@extends('relatorio.layout')
@section('titleHeader', 'Relatório de visitas nas colmeias')
@section('content')
<table>
    <thead>
        <tr>
            <th class="desc">Apiário</th>
            <th class="desc">Colmeia</th>
            <th class="">Tem comida</th>
            <th class="">Tem água</th>
            <th class="">Tem postura</th>
            <th class="">Qtd qua mel</th>
            <th class="">Qtd qua polen</th>
            <th class="">Qtd cria aberta</th>
            <th class="">Qtd cria fechada</th>
            <th class="">Postura</th>
            <th class="">Data</th>
        </tr>
    </thead>
    <tbody>
        @if (count($visitas) > 0)
        @foreach($visitas as $v)
        <tr>
            <td>{{$v->colmeia->apiario->nome}}</td>
            <td>{{$v->colmeia->nome}}</td>

            @if($v->tem_comida)
            <td>Sim</td>
            @else
            <td>Não</td>
            @endif

            @if($v->tem_agua)
            <td>Sim</td>
            @else
            <td>Não</td>
            @endif

            @if($v->tem_abelhas_mortas)
            <td>Sim</td>
            @else
            <td>Não</td>
            @endif

            <td>{{$v->qtd_quadros_mel}}</td>
            <td>{{$v->qtd_quadros_polen}}</td>
            <td>{{$v->qtd_cria_aberta }}</td>
            <td>{{$v->qtd_cria_fechada }}</td>
            <td>{{$v->tem_postura }}</td>
            <td>{{$v->created_at->format('d-m-Y')}}</td>

        </tr>

        @endforeach
        <tr>
            <td colspan="10" style="text-align:right">TOTAL DE VISITAS</td>
            <td class="total" style="text-align:right">{{$total_visitas}}</td>
        </tr>
        @else
        <tr>
            <td colspan="11" style="text-align:center;font-size:11pt;color: #5D6975" class="notice">Ainda não há
                informações</td>
        </tr>
        @endif
    </tbody>
</table>
<div id="notices">
    <div id="observacao">Observações:</div>
    <div class="notice">
        Qua. (Quadros)
    </div>
    <div class="notice">
        Qtd. (Quantidade)
    </div>
</div>
@endsection