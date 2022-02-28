@extends('layouts.admin')
@section('content')

    @php
        use App\Classes\Tools;
            //dd(\Illuminate\Support\Facades\Auth::user()->name);
            $model = 'products';
            $var = 'product';
    @endphp



<div class="container">
    <h1 class="pt-4 pb-4 text-center">Lista de Produtos</h1>
    @include('admin.includes.busca-por')
    <table class="table table-hover table-striped table-responsive">
        <thead class="bg-primary text-white">
            <tr >
                <th class="col text-center" style="width: 100px">Foto</th>
                <th class="col">Nome</th>
                <th class="col text-center">Qtd.</th>
                <th class="col text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @if(count($products) == 0)
                <tr>
                    <td colspan="4" class="text-center">
                        Nenhum produto cadastrado.
                    </td>
                </tr>
            @endif

            @foreach($products as $product)
            <tr class="align-middle">



                <td class="text-center">
                    @if(file_exists("images/$model/$product->id.jpg"))
                        <img class="img-thumbnail" src="{{asset("images/$model/$product->id.jpg")}}" alt="{{$product->name}}">
                    @endif
                </td>
                <td>{{$product->name}}</td>
                <td class="text-center @if($product->amount < $product->amount_alert) quantidade-baixa fw-bold @endif">{{$product->amount}}</th>
                <td class="text-center">
                    <!--a class="icon-action" style="margin-right: 1em" href="{{asset('admin/produtos/form')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Relatório de: {{$product->name}}">
                        <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                            <use xlink:href="{{asset('images/actions/bootstrap-icons.svg')}}#file-earmark-text"></use>
                        </svg>
                    </a>
                    <a class="icon-action" style="margin-right: 1em" href="{{route("admin.$model.form.edit",["$var"=>$product])}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar: {{$product->name}}">
                        <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                            <use xlink:href="{{asset('images/actions/bootstrap-icons.svg')}}#pencil-square"></use>
                        </svg>
                    </a>
                    <a onclick="return confirm('Tem certeza que deseja mover o produto {{$product->name}} para a lixeira?')" class="icon-action" style="margin-right: 0em" href="{{route("admin.$model.destroy",$product)}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir: {{$product->name}}">
                        <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                            <use xlink:href="{{asset('images/actions/bootstrap-icons.svg')}}#trash-fill"></use>
                        </svg>
                    </a-->

                @php
                    Tools::montaAcoes([$var=>$product]);
                @endphp

                </th>
            </tr>
            @endforeach
        </tbody>
    </table>


@endsection
