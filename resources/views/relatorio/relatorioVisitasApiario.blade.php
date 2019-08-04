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
            <td>{{$v->tem_sombra}}</td>
            <td>{{$v->tem_comida}}</td>
            <td>{{$v->tem_agua}}</td>
            <td>{{$v->created_at->format('d-m-Y')}}</td>
        </tr>
        @endforeach
        <!-- <tr>
            <td colspan="4" style="text-align:right">TOTAL DE COLMEIAS</td>
            <td class="total" style="text-align:right"></td>
        </tr> -->
        <!-- <tr>
            <td colspan="4" class="grand total">
                TOTAL DE APIÁRIOS
            </td>
            <td class="grand total"></td>
        </tr> -->
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
        Qtd colmeias = Quantidade de colmeias dos apiários
    </div>
    <div class="notice">
        Apic respo. = Apicultor responsável pelo apiário
    </div>
</div>
@endsection