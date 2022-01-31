@extends('layouts.admin')
@section('content')

@php
//dd($datas);
$model = 'clients';
$var = 'client';
$base_uri = 'clientes';
$genre = 'o';
$name_singular = 'patrimônio';
$name_plural = 'clientes';
$image = true;
@endphp

@php
    /**
    *   Cabeçalho da lsitagem
    * 1 - Descrição da coluna
    * 2 - class
    * 3 - style
    */
    $heads_table = [
        ['Foto','col text-center', 'width: 100px'],
        ['Nome','col',null],
        ['Marca','col',null],
        ['Observações','col',null]
    ];
@endphp

<div class="container">
    <h1 class="pt-4 pb-4 text-center">Patrimônio de {{ucfirst($client->name)}}</h1>
    <div class="row mb-2">
        <div class="col text-end">
            <button class="btn btn-secondary">Relatório</button>
            <button id="add-patrimonio" class="btn btn-info">Adicionar</button>
        </div>
    </div>
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
                    <td colspan="{{count($heads_table)+1}}" class="text-center">
                        Nenhum {{$name_singular}} cadastrado.
                    </td>
                </tr>
            @endif

            @foreach($datas as $data)

                @php
                  $values = [ $data->name, $data->brand, nl2br($data->comment) ];
                @endphp

            <tr class="align-middle">



                @if($image==true)
                <td class="text-center">
                    @if(file_exists("images/patrimonies/$data->id.jpg"))
                        <img class="img-thumbnail" src="{{asset("images/patrimonies/$data->id.jpg")}}" alt="{{$data->name}}">
                    @endif
                </td>
                @endif



                @foreach($values as $value)
                    <td>{!! $value !!}</td>
                @endforeach




                <td class="text-center">
                    <!-- a class="icon-action" style="margin-right: 1em" href="{{asset("admin/$base_uri/form")}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Relatório de: {{$data->name}}">
                        <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                            <use xlink:href="{{asset('images/actions/bootstrap-icons.svg')}}#file-earmark-text"></use>
                        </svg>
                    </a>
                    <a class="icon-action" style="margin-right: 1em" href="{{route("admin.$model.patrimony.list",["$var"=>$data])}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Patrimõnio de: {{$data->name}}">
                        <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                            <use xlink:href="{{asset('images/actions/bootstrap-icons.svg')}}#shield-shaded"></use>
                        </svg>
                    </a>
                    <a class="icon-action" style="margin-right: 1em" href="{{route("admin.$model.form.edit",["$var"=>$data])}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar: {{$data->name}}">
                        <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                            <use xlink:href="{{asset('images/actions/bootstrap-icons.svg')}}#pencil-square"></use>
                        </svg>
                    </a>
                    <a onclick="return confirm('Tem certeza que deseja mover {{$genre}} {{$name_singular}} {{$data->name}} para a lixeira?')" class="icon-action" style="margin-right: 0em" href="{{route("admin.$model.destroy",$data)}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir: {{$data->name}}">
                        <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                            <use xlink:href="{{asset('images/actions/bootstrap-icons.svg')}}#trash-fill"></use>
                        </svg>
                    </a -->

                </th>
            </tr>
            @endforeach
        </tbody>
    </table>


    <!-- ADICIONAR -->
    <div id="modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content p-3">
                <h3 class="text-center text-info mb-3">Adicionar Patrimônio</h3>


                    @php
                        /**
                        * 1 - Label
                        * 2 - Obrigatório
                        * 3 - name & id (input)
                        * 4 - mask
                        * 5 - type
                        */
                        $fields = [
                            ['client_id',true,'client_id',null,'hide',$client->id],
                            ['Nome',true,'name',null,'text',null],
                            ['Marca',false,'brand',null,'text',null],
                            ['Modelo',false,'model',null,'text',null],
                            ['Nº  de série',false,'serial_no',null,'text',null],
                            ['Observações',false,'comment',null,'textarea',null]
                        ];
                    @endphp


                <form action="{{route("admin.$model.patrimony.add",['client'=>$client])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @foreach($fields as $field)
                        @if($field[4]=='text')
                            <div class="mb-3">
                                <label for="{{$field[2]}}" class="form-label">{{$field[0]}}@if($field[1]==true)*@endif</label>
                                <input type="{{$field[4]}}" @if($field[3]!=null)data-mask="{{$field[3]}}"@endif @if($field[1]==true) required @endif name="{{$field[2]}}" class="form-control" id="{{$field[2]}}" aria-describedby="{{$field[2]}}Help" value="{{$field[5]}}">
                            </div>
                        @elseif($field[4]=='textarea')
                            <div class="mb-3">
                                <label for="{{$field[2]}}" class="form-label">{{$field[0]}}@if($field[1]==true)*@endif</label>
                                <textarea style="height: 130px" @if($field[1]==true) required @endif name="{{$field[2]}}" class="form-control" id="{{$field[2]}}" aria-describedby="{{$field[2]}}Help" value="{{$field[5]}}"></textarea>
                            </div>
                        @elseif($field[4]=='file')
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Default file input example</label>
                                <input class="form-control" type="file" id="formFile">
                            </div>
                        @elseif($field[4]=='hide')
                            <div class="mb-3">
                                <input class="form-control" type="hidden" id="formFile" name="client_id" value="{{$field[5]}}">
                            </div>
                        @endif
                    @endforeach





                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="amount_alert" class="form-label">Imagem</label>
                                <div class="input-group mb-3">
                                    <input type="hidden" id="image-crop" name="image-crop">
                                    <input  type="file" name="image" class="form-control image-crop" id="inputGroupFile02">
                                    <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                </div>
                            </div>
                        </div>
                        <div class="row pb-3">
                            <div id="img-thumbnail" class="img-thumbnail" style="background-image: url()"></div>
                        </div>
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
    </div>



    <!-- MODAL ADICIONAR -->
    <div class="modal fade" id="modal-image" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Cortar imagem</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-md-8">
                                <!--  default image where we will set the src via jquery-->
                                <img class="img-crop" id="image">
                            </div>
                            <div class="col-md-4">
                                <div class="preview-crop"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="crop">Cortar</button>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('footer_js')
    <script>
    $(function(){
        $(document).on('click','#add-patrimonio',function (){
            var modal_products = $("#modal");
            modal_products.modal('show');
        });
    });
    </script>
        <script src="{{ asset('js/cropper.js') }}"></script>
        <script>

            var bs_modal = $('#modal-image');
            var image = document.getElementById('image');
            var cropper,reader,file;


            $("body").on("change", ".image-crop", function(e) {
                var files = e.target.files;
                var done = function(url) {
                    image.src = url;
                    bs_modal.modal('show');
                };


                if (files && files.length > 0) {
                    file = files[0];

                    if (URL) {
                        done(URL.createObjectURL(file));
                    } else if (FileReader) {
                        reader = new FileReader();
                        reader.onload = function(e) {
                            done(reader.result);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });

            bs_modal.on('shown.bs.modal', function() {
                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 3,
                    preview: '.preview-crop'
                });
            }).on('hidden.bs.modal', function() {
                cropper.destroy();
                cropper = null;
            });

            $("#crop").click(function() {
                canvas = cropper.getCroppedCanvas({
                    width: 160,
                    height: 160,
                });

                canvas.toBlob(function(blob) {
                    url = URL.createObjectURL(blob);
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function() {
                        var base64data = reader.result;
                        $('#image-crop').val(base64data);
                        $('#img-thumbnail').attr("src","");
                        document.getElementById('img-thumbnail').style.background = "url("+base64data+")";
                        bs_modal.modal('hide')

                        /*$.ajax({
                            type: "POST",
                            dataType: "json",
                            url: "upload.php",
                            data: {image: base64data},
                            success: function(data) {
                                bs_modal.modal('hide');
                                alert("success upload image");
                            }
                        });*/
                    };
                });
            });

        </script>
@endsection


