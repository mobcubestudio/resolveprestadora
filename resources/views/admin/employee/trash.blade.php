@extends('layouts.admin')
@section('content')


    @php
        $model = 'employees';
        $var = 'employee';
        $base_uri = 'funcionarios';
        $genre = 'o';
        $name_singular = 'funcionário';
        $name_plural = 'Funcionários';
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
                    @php
                        Tools::montaAcoes([$var=>$employee]);
                    @endphp
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>


@endsection
