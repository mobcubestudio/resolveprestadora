@extends('layouts.admin')
@section('content')

@php
$model = 'providers';
$var = 'provider';
$base_uri = 'fornecedores';
$genre = 'o';
$name_singular = 'fornecedor';
$name_plural = 'fornecedores';
$image = false;
@endphp

@php
    /**
    *   Cabeçalho da lsitagem
    * 1 - Descrição da coluna
    * 2 - class
    * 3 - style
    */
    $heads_table = [
        //['Foto','col text-center', 'width: 100px'],
        ['Nome','col',null],
        ['CNPJ','col',null]
    ];
@endphp

<div class="container">
    <h1 class="pt-4 pb-4 text-center">Lista de {{ucfirst($name_plural)}}</h1>
    @include('admin.includes.busca-por')
    <table class="table table-hover table-striped table-responsive">
        <thead class="bg-primary text-white">
            <tr >
                @foreach($heads_table as $head_table)
                    <th class="{{$head_table[1]}}" style="{{$head_table[2]}}">{{$head_table[0]}}</th>
                @endforeach
                <th class="col text-center">Ações</th>
            </tr>
        </thead>


        <tbody>
            @if(count($datas) == 0)
                <tr>
                    <td colspan="{{count($heads_table)+1}}" class="text-center">
                        Nenhum {{$name_singular}} cadastrado.
                    </td>
                </tr>
            @endif

            @foreach($datas as $data)

                @php
                  $values = [ $data->name, $data->cnpj ];
                @endphp

            <tr class="align-middle">



                @if($image==true)
                <td class="text-center">
                    @if(file_exists("images/$model/$data->id.jpg"))
                        <img class="img-thumbnail" src="{{asset("images/$model/$data->id.jpg")}}" alt="{{$data->name}}">
                    @endif
                </td>
                @endif



                @foreach($values as $value)
                    <td>{{$value}}</td>
                @endforeach




                <td class="text-center">
                    @php
                        Tools::montaAcoes([$var=>$data]);
                    @endphp
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>


@endsection
