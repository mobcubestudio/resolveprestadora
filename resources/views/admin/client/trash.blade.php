@extends('layouts.admin')
@section('content')


    @php
        $model = 'clients';
        $var = 'client';
        $base_uri = 'clientes';
        $genre = 'o';
        $name_singular = 'cliente';
        $name_plural = 'clientes';
    @endphp


<div class="container">
    <h1 class="pt-4 pb-4 text-center">{{ucfirst($name_plural)}} Excluídos</h1>
    <table class="table table-hover table-striped table-responsive">
        <thead class="bg-primary text-white">
            <tr >
                <th class="col text-center" style="width: 100px">Foto</th>
                <th class="col">Nome</th>
                <th class="col">Matrícula</th>
                <th class="col">Telefone</th>
                <th class="col text-center">Ações</th>
            </tr>
        </thead>
        <tbody>

            @if(count($datas) == 0)
                <tr>
                    <td colspan="5" class="text-center">
                        Nenhum {{$name_singular}} cadastrado.
                    </td>
                </tr>
            @endif

            @foreach($datas as $data)
            <tr class="align-middle">



                <td class="text-center">
                    @if(file_exists("images/$model/$data->id.jpg"))
                        <img class="img-thumbnail" src="{{asset("images/$model/$data->id.jpg")}}" alt="{{$data->name}}">
                    @endif
                </td>
                <td>{{$data->name}}</td>
                <td >{{$data->cnpj}}</td>
                <td >{{$data->phone}}</td>




                <td class="text-center">
                    <a onclick="return confirm('Tem certeza que deseja restaurar {{$genre}} {{$name_singular}} {{$data->name}}?')"
                       class="icon-action" style="margin-right: 0em"
                       href="{{route("admin.$model.recycle",$data->id)}}"
                       data-bs-toggle="tooltip" data-bs-placement="top" title="Restaurar: {{$data->name}}">
                        <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                            <use xlink:href="{{asset('images/actions/bootstrap-icons.svg')}}#recycle"></use>
                        </svg>
                    </a>

                </th>
            </tr>
            @endforeach
        </tbody>
    </table>


@endsection
