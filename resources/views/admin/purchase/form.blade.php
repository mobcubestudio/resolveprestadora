@extends('layouts.admin')

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')

    @php

        $model = 'purchases';
        $action_model = 'create';
        $name_plural = 'compras';
        $name_singular = 'compra';

        $image = false;

        $action = "Cadastrar";

        $id = null;
        $employee_id = null;
        $provider_id = null;
        $price = null;

        $img_thumb = asset("images/produto-sem-foto.jpg");

    @endphp


    <div class="row-cols-md-1 pb-5">
        <div class="container-md">
            @php
              if(isset($data)){
                $action_model = 'update';
                $action="Editar";

                $id = $data->id;
                $provider_id = $data->provider_id;
                $employe_id = $data->employee_id;
                $price = $data->price;

                if(file_exists("images/$model/$id.jpg"))
                {
                    $img_thumb =  asset("images/$model/$id.jpg").'?'.mt_rand(111,999);
                } else {
                    $img_thumb = asset("images/produto-sem-foto.jpg");
                }
                }

            @endphp
            <h1 class="page-title">{{$action}} {{ucfirst($name_singular)}}</h1>

            <form action="{{route("admin.$model.action.$action_model")}}" method="post" enctype="multipart/form-data">
                @csrf
                @if($id!=null)
                    <input type="hidden" name="id" value="{{$id}}">
                @endif

                @php
                    /**
                    * 0 - Label
                    * 1 - Obrigatório
                    * 2 - name & id (input)
                    * 3 - mask
                    * 4 - mask reverse {true or false}
                    * 5 - type
                    * 6 - Value
                    * 7 - lista de resultados possiveis em caso de (5= select)
                    */
                    $fields = [
                        ['Funcionário',true,'employee_id',null,null,'select',$employee_id,$list_employees],
                        ['Fornecedor',true,'provider_id',null,null,'select',$provider_id,$list_providers],
                        ['Valor da compra',true,'price','00.000,00',true,'text',$price]

                    ];
                @endphp



                @foreach($fields as $field)
                    @if($field[4]=='text')
                        <div class="mb-3">
                            <label for="{{$field[2]}}" class="form-label">{{$field[0]}}@if($field[1]==true)*@endif</label>
                            <input type="{{$field[4]}}" @if($field[3]!=null)data-mask="{{$field[3]}}" @if($field[5]==true) data-mask-reverse="true" @endif @endif @if($field[1]==true) required @endif name="{{$field[2]}}" class="form-control" id="{{$field[2]}}" aria-describedby="{{$field[2]}}Help" value="{{$field[6]}}">
                        </div>


                    @elseif($field[5]=='select')
                        <div class="mb-3">
                            <label for="{{$field[2]}}" class="form-label">{{$field[0]}}@if($field[1]==true)*@endif</label>
                            <select @if($field[1]==true) required @endif id="{{$field[2]}}" name="{{$field[2]}}" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                                <option value="">Selecione</option>
                                @foreach($field[7] as $list_data[$field[2]])
                                    <option @if($field[6]==$list_data[$field[2]]->id) selected @endif
                                    value="{{$list_data[$field[2]]->id}}">{{$list_data[$field[2]]->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                @endforeach



                @if($image==true)
                    @include('layouts.ImageSend.field')
                @endif

                <div class="card p-4 mt-5 mb-3 bg-opacity-10 shadow bg-dark rounded-3">
                    <div class="row-cols-12 h3 text-center">Adicionar Produtos</div>
                    <div class="row" style="height: 100px">
                        <div class="col-8">
                            <div class="">
                                <label class="form-label">Produto: </label>
                                <select style="height: 80px" id="product_id" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                                    <option value="">Selecione</option>
                                    @foreach($list_products as $product)
                                        <option
                                            value="{{$product->id}}">{{$product->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <label class="form-label">Quantidade: </label>
                            <input type="text" data-mask="0000"  class="form-control" id="amount" >
                        </div>
                        <div class="col-1  d-flex align-items-center">

                                <button type="button" id="add-produto" class="btn align-middle btn-info" style="font-size: 1em">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                        <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"></path>
                                    </svg>
                                </button>

                        </div>
                    </div>
                    <table class="table table-hover table-striped table-responsive">
                        <thead class="bg-primary text-white">
                            <th scope="col">Produto</th>
                            <th scope="col">Quantidade</th>
                            <th scope="col"></th>
                        </thead>
                        <tbody id="list-products" class="bg-white">
                        </tbody>
                    </table>

                </div>

                <button type="Salvar" class="btn btn-primary" style="font-size: 1.5em">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-save" viewBox="0 0 16 16">
                        <path d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z"/>
                    </svg>
                    Salvar
                </button>
            </form>
        </div>
    </div>



    @if($image==true)
        @include('layouts.ImageSend.modal')
    @endif


@endsection


@section('footer_js')
    @if($image==true)
        @include('layouts.ImageSend.js')
    @endif
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/jquery.mask.min.js')}}"></script>
    <script>
        $(function(){

            $("#product_id").select2();

            var lines = 0;

            $("#add-produto").click(function()
            {

                var erro = "";
                var pdt = $("#product_id").val();
                var pdt_name = $("#product_id option:selected").text();
                var qtd = $("#amount").val();
                if(pdt=="") erro += "Adicione um produto.";
                if(qtd==""){
                    if(erro!="") erro += "\n";
                    erro += "Informe a quantidade."
                }
                if(erro!=""){
                    alert(erro);
                } else {
                    lines++;
                    let body = $("#list-products");
                    let row = $('<tr id="line_'+lines+'"></tr>');
                    row.append('<td><input type="hidden" name="product_id[]" value="'+pdt+'"><input type="hidden" name="amount[]" value="'+qtd+'">'+pdt_name+'</td>');
                    row.append('<td>'+qtd+'</td>');
                    row.append('<td><a  class="icon-action del-product-list" product-id="'+pdt+'" line="'+lines+'" style="cursor:pointer;margin-right: 0em"  data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir Produto"><svg class="bi" width="1.2em" height="1.5em" fill="currentColor"><use xlink:href="{{asset("images/actions/bootstrap-icons.svg")}}#trash-fill"></use></svg></a></td>');
                    body.append(row);
                    //$("#list-products").append('</tr>');
                    //alert("Produto: "+pdt+"--- Qtd: "+qtd);
                    $("#product_id").val("");
                    $("#amount").val("");
                }

            });

            //EXCLUIR PRODUTO DA LISTA
            $(document).on("click",".del-product-list",function ()
            {
               if(confirm("Tem certeza que deseja excluir o produto?")){
                   $("#line_"+$(this).attr("line")).remove();
               }

            });
        });
    </script>

@endsection
