@extends('layouts.admin')
@section('content')

@php
    //use App\Classes\Tools;
    $model = 'employees';
    $var = 'employee';
    $base_uri = 'funcionarios';
    $genre = 'o';
    $name_singular = 'funcionário';
    $name_plural = 'Funcionários';
@endphp



<div class="container">
    <h1 class="pt-4 pb-4 text-center">Lista de {{ucfirst($name_plural)}}</h1>
    @include('admin.includes.busca-por')
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
            @if(count($employees) == 0)
                <tr>
                    <td colspan="5" class="text-center">
                        Nenhum {{$name_singular}} cadastrado.
                    </td>
                </tr>
            @endif

            @foreach($employees as $employee)
            <tr class="align-middle">



                <td class="text-center">
                    @if(file_exists("images/$model/$employee->id.jpg"))
                        <img class="img-thumbnail" src="{{asset("images/$model/$employee->id.jpg")}}" alt="{{$employee->name}}">
                    @endif
                </td>
                <td>{{$employee->name}}</td>
                <td >{{$employee->registration}}</td>
                <td >{{$employee->phone}}</td>



                <td class="text-center">
                    <!--a class="icon-action" style="margin-right: 1em" href="{{asset("admin/$base_uri/form")}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Relatório de: {{$employee->name}}">
                        <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                            <use xlink:href="{{asset('images/actions/bootstrap-icons.svg')}}#file-earmark-text"></use>
                        </svg>
                    </a>
                    <a class="icon-action" style="margin-right: 1em" href="{{route("admin.$model.form.edit",["$var"=>$employee])}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar: {{$employee->name}}">
                        <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                            <use xlink:href="{{asset('images/actions/bootstrap-icons.svg')}}#pencil-square"></use>
                        </svg>
                    </a>
                    <a onclick="return confirm('Tem certeza que deseja mover {{$genre}} {{$name_singular}} {{$employee->name}} para a lixeira?')" class="icon-action" style="margin-right: 0em" href="{{route("admin.$model.destroy",$employee)}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir: {{$employee->name}}">
                        <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                            <use xlink:href="{{asset('images/actions/bootstrap-icons.svg')}}#trash-fill"></use>
                        </svg>
                    </a-->

                @php
                    Tools::montaAcoes([$var=>$employee]);
                @endphp

                </th>
            </tr>
            @endforeach
        </tbody>
    </table>


@endsection
