@extends('errors.minimal')

@section('title', 'Recurso não encontrado')
@section('code')
    <img src="{{URL::asset('/images/outros/404.png')}}" style="width: 100px; height: 100px"
        class="img-fluid center" alt="Foto">
@endsection
@section('message', 'Recurso não encontrado')
