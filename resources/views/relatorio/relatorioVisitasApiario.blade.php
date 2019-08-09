@extends('relatorio.layout')
@section('titleHeader', 'Relatório de visitas nos apiários')
@section('content')
<table>
    <thead>
        <tr>
            <th class="desc">#</th>
            <th class="desc">Apiário</th>
            <th class="">Tem sombra</th>
            <th class="">Tem comida</th>
            <th>Tem água</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
        @if (count($visitas) > 0)
        @foreach($visitas as $v)
        <tr>
            <td>{{$v->id}}</td>
            <td>{{$v->apiario->nome}}</td>

            @if($v->tem_sombra)
            <td>Sim</td>
            @else
            <td>Não</td>
            @endif

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

            <td>{{$v->created_at->format('d-m-Y')}}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="5" class="grand total">
                TOTAL DE VISITAS
            </td>
            <td class="grand total">{{$total_visitas}}</td>
            </<tr>
            @else
        <tr>
            <td colspan="6" style="text-align:center;font-size:11pt;color: #5D6975" class="notice">Ainda não há
                informações</td>
        </tr>
        @endif
    </tbody>
</table>
<div id="notices">
    <div id="observacao">Observações:</div>
    <div class="notice">
        Sem
    </div>
</div>
@endsection