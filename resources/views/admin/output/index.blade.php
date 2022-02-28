@extends('layouts.admin')

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection


@section('content')

@php
    use App\Models\Employee;
    $rota = Route::currentRouteName();
    $model = 'outputs';
    $var = 'output';
    $base_uri = 'pedidos';
    $genre = 'o';
    $name_singular = 'pedido';
    $name_plural = 'pedidos';
    $image = false;
    $titulo_modal = '';
@endphp

@php
    /**
    *   Cabeçalho da lsitagem
    * 1 - Descrição da coluna
    * 2 - class
    * 3 - style
    * 4 - Align (class)
    */
    if ($rota=='admin.outputs.delivered'){
        $heads_table = [
            //['Foto','col text-center', 'width: 100px'],
            ['Data','col',null,'text-start'],
            ['Cliente','col',null,'text-start'],
            ['Responsável','col',null,'text-start'],
            ['Observações','col',null,'text-start'],
            ['Status','col',null,'text-start']
        ];
    } else {
        $heads_table = [
            //['Foto','col text-center', 'width: 100px'],
            ['Data','col',null,'text-start'],
            ['Cliente','col',null,'text-start'],
            ['Responsável','col',null,'text-start'],
            ['Status','col',null,'text-start']
        ];
    }
@endphp

<div class="container">
    <h1 class="pt-4 pb-4 text-center">Lista de {{ucfirst($name_plural)}} {{$titulo_pagina}}</h1>
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
                    if($rota=='admin.outputs.request' || $rota=='admin.outputs'){
                        $titulo_modal = 'Separar Produtos';
                        $responsavel = Employee::find($data->ordered_by)->name;
                    } elseif ($rota=='admin.outputs.separated'){
                        $titulo_modal = 'Enviar para rota de entrega';
                        $responsavel = Employee::find($data->selected_by)->name;
                    } elseif ($rota=='admin.outputs.route'){
                        $titulo_modal = 'Finalizar pedido';
                        $responsavel = Employee::find($data->sent_by)->name;
                    } elseif ($rota=='admin.outputs.delivered'){
                        $responsavel = ($data->received_by) ? Employee::find($data->received_by)->name : '';
                    }

                    if ($rota=='admin.outputs.delivered'){
                      $values = [
                                    date_format($data->{$campo_data},'d/m/y H:i'),
                                    $data->client->name,
                                    $responsavel,
                                    $data->received_notes,
                                    $data->status,
                                 ];
                    } else {
                        $values = [
                                    date_format($data->{$campo_data},'d/m/y H:i'),
                                    $data->client->name,
                                    $responsavel,
                                    $data->status,
                                 ];
                    }

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
                    <!--a class="icon-action" id="ver-produtos" id-output="{{$data->id}}" style="margin-right: 0em"  data-bs-toggle="tooltip" data-bs-placement="top" title="Separar produtos">
                        <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                            <use xlink:href="{{asset('images/actions/bootstrap-icons.svg')}}#boxes"></use>
                        </svg>
                    </a-->
                    @php
                        Tools::montaAcoes([$var=>$data]);
                    @endphp
                </th>
            </tr>
            @endforeach
        </tbody>
    </table>










    <div id="modal" class="modal fade bd-example-modal-lg" data-bs-backdrop="static" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content p-3">
                <h3 class="text-center text-info mb-3">{{$titulo_modal}}</h3>
                <form id="modal-form" action="{{route("admin.$model.action")}}" method="post">
                    @csrf
                    <div class="container mt-3 mb-3">
                        <input type="hidden" id="action-output" name="action_output" value="">
                        <input type="hidden" name="id" id="id">

                        @if(Session::get('submenu_id')==9)
                            <div class="mb-3">
                            <select style="width: 100%" name="recebido_por"  id="responsavel" class="form-select mb-3" aria-label=".form-select-lg example">
                                <option value="">Quem recebeu o pedido?</option>
                                @foreach($employees as $employee)
                                    <option
                                        value="{{$employee->id}}">{{$employee->name}}</option>
                                @endforeach
                            </select>
                            </div>
                            <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                  <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                </svg>
                            </span>
                                <input type="text" class="form-control" placeholder="Observações" name="recebido_anotacoes" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        @endif
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
                        <button id="modal-submit" type="submit" id-order="" class="btn btn-info">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




@endsection

@section('footer_js')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{ asset('js/jquery.mask.min.js')}}"></script>
        <script>
            $(function () {
                $("#responsavel").select2({
                    dropdownParent: $("#modal")
                });
                //ENVIA DADOS
                $(document).on("submit","#modal-form",function () {
                        fecha_modal();
                        return true;

                });

                //FECHA MODAL
                $(document).on("click","#modal-close",function () {
                    $("#modal-submit").attr('id-order',null);
                    var modal_products = $("#modal");
                    modal_products.modal('hide');
                });


               $(document).on('click','#ver-produtos',function () {

                   let _token   = $('meta[name="csrf-token"]').attr('content');
                   $("#action-output").val($(this).attr('data-extra'));
                   $("#lista-produtos-comprados").html("");
                   var id = $(this).attr('data-id');
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
