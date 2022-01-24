@extends('layouts.admin')



@section('content')

@php
    //dd($employees);
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
    * 4 - Align (class)
    */
    $heads_table = [
        //['Foto','col text-center', 'width: 100px'],
        ['Data','col',null,'text-start'],
        ['Cliente','col',null,'text-start'],
        ['Status','col',null,'text-start']
    ];
@endphp

<div class="container">
    <h1 class="pt-4 pb-4 text-center">Lista de {{ucfirst($name_plural)}}</h1>
    <table class="table table-hover table-striped table-responsive">
        <thead class="bg-primary text-white">
            <tr >
                @foreach($heads_table as $head_table)
                    <th class="{{$head_table[1]}} {{$head_table[3]}}" style="{{$head_table[2]}}">{{$head_table[0]}}</th>
                @endforeach
                <th class="col text-center">Ações</th>
            </tr>
        </thead>


        <tbody>
            @if(count($datas) == 0)
                <tr>
                    <td colspan="{{count($heads_table)+1}}" class="text-center">
                        Nenhuma {{$name_singular}} cadastrado.
                    </td>
                </tr>
            @endif

            @foreach($datas as $data)

                @php
                  $values = [
                                date_format($data->created_at,'d/m/y'),
                                $data->client->name,
                                $data->status,
                             ];
                @endphp

            <tr class="align-middle">



                @if($image==true)
                <td class="text-center">
                    @if(file_exists("images/$model/$data->id.jpg"))
                        <img class="img-thumbnail" src="{{asset("images/$model/$data->id.jpg")}}" alt="{{$data->name}}">
                    @endif
                </td>
                @endif



                @php
                $l = 0;
                @endphp
                @foreach($values as $value)
                    <td class="{{$heads_table[$l][3]}}">{{$value}}</td>
                    @php $l++; @endphp
                @endforeach




                <td class="text-center">
                    <a class="icon-action" id="ver-produtos" id-output="{{$data->id}}" style="margin-right: 0em"  data-bs-toggle="tooltip" data-bs-placement="top" title="Separar produtos">
                        <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                            <use xlink:href="{{asset('images/actions/bootstrap-icons.svg')}}#boxes"></use>
                        </svg>
                    </a>
                </th>
            </tr>
            @endforeach
        </tbody>
    </table>










    <div id="modal" class="modal fade bd-example-modal-lg" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content p-3">
                <h3 class="text-center text-info mb-3">Separar Produtos</h3>
                <form id="modal-form" action="{{route("admin.$model.action.separate")}}" method="post">
                    @csrf
                    <div class="container mt-3 mb-3">
                        <input type="hidden" name="id" id="id">
                        <select name="employee"  id="responsavel" class="form-select mb-3" >
                            <option value="">Responsável por separar o pedido</option>
                            @foreach($employees as $employee)
                                <option
                                    value="{{$employee->id}}">{{$employee->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Produto</th>
                            <th scope="col" class="text-center">Quantidade</th>
                            <th scope="col" class="text-center">Checar</th>
                        </tr>
                        </thead>
                        <tbody id="lista-produtos-comprados">
                        </tbody>
                    </table>
                    <div class="container text-end">
                        <button id="modal-close" type="button" class="btn btn-secondary">Fechar</button>
                        <button id="modal-submit" type="submit" id-order="" class="btn btn-info">Pedido Separado</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




@endsection

@section('footer_js')

        <script>
            $(function () {


                //ENVIA DADOS
                $(document).on("submit","#modal-form",function () {
                    var responsavel = $("#responsavel").val();


                    if(responsavel==""){
                        alert("Escolha o responsável pela separação do pedido.");
                        return false;
                    } else {
                        fecha_modal();
                        return true;
                    }
                });

                //FECHA MODAL
                $(document).on("click","#modal-close",function () {
                    $("#modal-submit").attr('id-order',null);
                    var modal_products = $("#modal");
                    modal_products.modal('hide');
                });


               $(document).on('click','#ver-produtos',function () {
                   let _token   = $('meta[name="csrf-token"]').attr('content');
                   $("#lista-produtos-comprados").html("");
                   var id = $(this).attr('id-output');
                   var modal_products = $("#modal");
                   modal_products.modal('show');

                   $("#id").val(id);
                   $("#modal-submit").attr('id-order',id);


                   $.ajax({
                       url: "{{route('admin.ajax.separar_produtos.lista')}}",
                       cache: false,
                       type: 'POST',
                       data: {
                           id:id,
                           _token: _token
                       },
                       success: function (data) {
                           data.forEach(function(item,i){
                               $("#lista-produtos-comprados").append('<tr><th scope="row">'+(i+1)+'</th><td>'+item.product+'</td><td class="text-center">'+item.amount+'</td><td class="text-center"><input type="checkbox"></td></tr>');
                           });

                           console.log(data);
                       }
                   });


               });
            });
        </script>
@endsection
