@extends('layouts.admin')
@section('content')

@php
        //dd($datas);
        $model = 'purchases';
        $var = 'purchase';
        $base_uri = 'compras';
        $genre = 'a';
        $name_singular = 'compra';
        $name_plural = 'compras';
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
        ['Funcionário','col',null,'text-start'],
        ['Fornecedor','col',null,'text-start'],
        ['Valor','col',null,'text-end']
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
                                $data->employee->name,
                                $data->provider->name,
                                'R$ '.number_format($data->price,2,',','.')
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
                    <!--a class="icon-action" id="ver-produtos" id-purchase="{{$data->id}}" style="margin-right: 0em"  data-bs-toggle="tooltip" data-bs-placement="top" title="Ver produtos comprados">
                        <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                            <use xlink:href="{{asset('images/actions/bootstrap-icons.svg')}}#cart"></use>
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

    <!-- PAGINACAO -->
    {{$datas->links('layouts.pagination')}}



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
                   var id_purchase = $(this).attr('data-id');
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
