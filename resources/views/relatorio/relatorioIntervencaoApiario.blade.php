@extends('relatorio.layout')
@section('titleHeader', 'Relatório de intervenções '. $situacao_formatada. ' nos apiários')
@section('content')
<table>
    <thead>
        <tr>
            <th class="desc">#</th>
            <th class="desc">Apiário</th>
            <th class="">Descrição</th>
            <th class="">Data Ini</th>
            <th class="">Data Fim</th>
            <th>Concluida</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
        @if (count($intervencoes) > 0)
        @foreach($intervencoes as $i)
        <tr>
            <td>{{$i->id}}</td>
            <td>{{$i->apiario->nome}}</td>
            <td>{{$i->descricao}}</td>
            <td>{{$i->data_inicio}}</td>
            <td>{{$i->data_fim}}</td>

            @if($i->is_concluido)
            <td>Sim</td>
            @else
            <td>Não</td>
            @endif

            <td>{{$i->created_at->format('d-m-Y')}}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="6" class="grand total">
                TOTAL DE INTERVENÇÕES
            </td>
            <td class="grand total">{{$total_intervencoes}}</td>
        </tr>
        @else
        <tr>
            <td colspan="7" style="text-align:center;font-size:11pt;color: #5D6975" class="notice">Ainda não há
                informações</td>
        </tr>
        @endif
    </tbody>
</table>
<div id="notices">
    <div id="observacao">Observações:</div>
    <div class="notice">
        Data ini (Data de inicio para realização da intervencão)
    </div>
</div>
@endsection