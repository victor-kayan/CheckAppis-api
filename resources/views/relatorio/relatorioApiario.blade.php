@extends('relatorio.layout')
@section('titleHeader', 'Relatório de apiários')
@section('content')
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>APIÁRIO</th>
            <th>QTD COL.</th>
            <th>ENDEREÇO</th>
            <th>DATA CRIA.</th>
            <th>APIC RESPO.</th>
        </tr>
    </thead>
    <tbody>
        @if (count($apiarios) > 0)
        @foreach($apiarios as $a)
        <tr>
            <td>{{$a->id}}</td>
            <td>{{$a->nome}}</td>
            <td>
                {{$a->qtd_colmeias}}
            </td>
            <td>{{$a->endereco->logradouro}}, {{$a->endereco->cidade->nome}} -
                {{$a->endereco->cidade->uf}}</td>
            <td>{{$a->created_at->format('d/m/Y')}}</td>
            @if(isset($a->apicultor->name))
            <td>{{$a->apicultor->name}}</td>
            @else
            <td>-</td>
            @endif
        </tr>
        @endforeach
        <tr>
            <td colspan="5" style="text-align:right">TOTAL DE COLMEIAS</td>
            <td class="total" style="text-align:right">{{$total_colmeias}}</td>
        </tr>
        <tr>
            <td colspan="5" class="grand total">
                TOTAL DE APIÁRIOS
            </td>
            <td class="grand total">{{$total_apiarios}}</td>
        </tr>
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
        Qtd col (Quantidade de colmeias dos apiários)
    </div>
    <div class="notice">
        Apic respo (Apicultor responsável pelo apiário)
    </div>
    <div class="notice">
        Data cria (Data de criação do apiário)
    </div>
</div>
@endsection