@extends('errors.minimal')

@section('title', __('Erro interno no servidor'))
@section('code')
    <img src="{{URL::asset('/images/outros/500.png')}}" style="width: 100px; height: 100px"
        class="img-fluid center" alt="Sucesso">
@endsection
@section('message', __('Erro interno no servidor'))

