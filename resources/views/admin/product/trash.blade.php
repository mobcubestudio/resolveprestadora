@extends('layouts.admin')
@section('content')





<div class="container">
    <h1 class="pt-4 pb-4 text-center">Produtos Excluídos</h1>
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
                    @if(file_exists("images/products/$product->id.jpg"))
                        <img class="img-thumbnail" src="{{asset("images/products/$product->id.jpg")}}" alt="{{$product->name}}">
                    @endif
                </td>
                <td>{{$product->name}}</td>
                <td class="text-center @if($product->amount < $product->amount_alert) quantidade-baixa fw-bold @endif">{{$product->amount}}</th>
                <td class="text-center">
                    <a onclick="return confirm('Tem certeza que deseja restaurar o produto {{$product->name}}?')"
                       class="icon-action" style="margin-right: 0em"
                       href="{{route('admin.products.recycle',$product->id)}}"
                       data-bs-toggle="tooltip" data-bs-placement="top" title="Restaurar: {{$product->name}}">
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
