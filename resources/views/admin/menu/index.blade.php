@extends('layouts.admin')
@section('content')

@php
    use App\Classes\Tools;
    //dd($datas);
    $model = 'menus';
    $var = 'menu';
    $base_uri = 'menus';
    $genre = 'o';
    $name_singular = 'menu';
    $name_plural = 'menus';
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
        ['Nome','col',null,'text-start'],
        ['Asset','col',null,'text-start'],
        ['Ordem','col',null,'text-start']
    ];
@endphp

<div class="container">
    <h1 class="pt-4 pb-4 text-center">Lista de {{ucfirst($name_plural)}}</h1>
    @include('admin.includes.busca-por')
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
                                $data->name,
                                $data->asset,
                                $data->order
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
                    <a href="{{route("admin.$model.form.edit",["$var"=>$data])}}"  class="icon-action" id="editar"  style="margin-right: 0em"  data-bs-toggle="tooltip" data-bs-placement="top" title="Editar: {{$data->name}}">
                        <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                            <use xlink:href="{{asset('images/actions/bootstrap-icons.svg')}}#pencil"></use>
                        </svg>
                    </a>
                </th>
            </tr>
            @endforeach
        </tbody>
    </table>



    <div id="modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content p-3">
                <h3 class="text-center text-info mb-3">Produtos Comprados</h3>

                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Produto</th>
                        <th scope="col" class="text-center">Quantidade</th>
                    </tr>
                    </thead>
                    <tbody id="lista-produtos-comprados">
                    </tbody>
                </table>
            </div>
        </div>
    </div>




@endsection

@section('footer_js')
        <script>
            $(function () {
               $(document).on('click','#ver-produtos',function () {
                   $("#lista-produtos-comprados").html("");
                   var id_purchase = $(this).attr('id-purchase');
                   var modal_products = $("#modal");
                   modal_products.modal('show');

                   let _token   = $('meta[name="csrf-token"]').attr('content');

                   $.ajax({
                       url: "{{route('admin.ajax.produtos_comprados')}}",
                       cache: false,
                       type: 'POST',
                       data: {
                           id_purchase:id_purchase,
                           _token: _token
                       },
                       success: function (data) {
                           data.forEach(function(item,i){
                               $("#lista-produtos-comprados").append('<tr><th scope="row">'+(i+1)+'</th><td>'+item.product+'</td><td class="text-center">'+item.amount+'</td></tr>');
                           });

                           console.log(data);
                       }
                   });


               });
            });
        </script>
@endsection
