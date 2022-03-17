@extends('layouts.admin')
@section('content')


    @php
        $model = 'outputs';
        $var = 'output';
        $base_uri = 'pedidos';
        $genre = 'o';
        $name_singular = 'pedido';
        $name_plural = 'pedidos';
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
            ['#','col',null],
            ['Data','col',null],
            ['Cliente','col',null]
        ];
    @endphp


<div class="container">
    <h1 class="pt-4 pb-4 text-center">{{ucfirst($name_plural)}} Excluídos</h1>
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
                    <td colspan="5" class="text-center">
                        Lixeira vazia.
                    </td>
                </tr>
            @endif

            @foreach($datas as $data)
            <tr class="align-middle">

                @php
                    $values = [
                                $data->id,
                                date_format($data->ordered_date_time,'d/m/y'),
                                $data->client->name
                                ];
                @endphp

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
