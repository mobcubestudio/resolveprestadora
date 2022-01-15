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
                    <a class="icon-action" style="margin-right: 1em" href="{{asset("admin/$base_uri/form")}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Relatório de: {{$data->name}}">
                        <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                            <use xlink:href="{{asset('images/actions/bootstrap-icons.svg')}}#file-earmark-text"></use>
                        </svg>
                    </a>
                    <a class="icon-action" style="margin-right: 1em" href="{{route("admin.$model.form.edit",["$var"=>$data])}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar: {{$data->name}}">
                        <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                            <use xlink:href="{{asset('images/actions/bootstrap-icons.svg')}}#pencil-square"></use>
                        </svg>
                    </a>
                    <a onclick="return confirm('Tem certeza que deseja mover {{$genre}} {{$name_singular}} {{$data->name}} para a lixeira?')" class="icon-action" style="margin-right: 0em" href="{{route("admin.$model.destroy",$data)}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir: {{$data->name}}">
                        <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                            <use xlink:href="{{asset('images/actions/bootstrap-icons.svg')}}#trash-fill"></use>
                        </svg>
                    </a>

                </th>
            </tr>
            @endforeach
        </tbody>
    </table>


@endsection
