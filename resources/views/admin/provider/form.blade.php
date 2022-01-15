@extends('layouts.admin')
@section('content')

    @php
        $model = 'providers';
        $action_model = 'create';
        $name_plural = 'fornecedores';
        $name_singular = 'fornecedor';

        $image = false;

        $action = "Cadastrar";

        $id = null;
        $cnpj = null;
        $name = null;
        $address = null;

        $img_thumb = asset("images/produto-sem-foto.jpg");

    @endphp


    <div class="row-cols-md-1 pb-5">
        <div class="container-md">
            @php
              if(isset($data)){
                $action_model = 'update';
                $action="Editar";

                $id = $data->id;
                $cnpj = $data->cnpj;
                $name = $data->name;
                $address = $data->address;

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
                    * 1 - Label
                    * 2 - Obrigatório
                    * 3 - name & id (input)
                    * 4 - mask
                    * 5 - type
                    */
                    $fields = [
                        ['CNPJ',true,'cnpj','00.000.000/0000-00','text',$cnpj],
                        ['Nome',true,'name',null,'text',$name],
                        ['Endereço',true,'address',null,'text',$address]

                    ];
                @endphp



                @foreach($fields as $field)
                    <div class="mb-3">
                        <label for="{{$field[2]}}" class="form-label">{{$field[0]}}@if($field[1]==true)*@endif</label>
                        <input type="{{$field[4]}}" @if($field[3]!=null)data-mask="{{$field[3]}}"@endif @if($field[1]==true) required @endif name="{{$field[2]}}" class="form-control" id="{{$field[2]}}" aria-describedby="{{$field[2]}}Help" value="{{$field[5]}}">
                    </div>
                @endforeach



                @if($image==true)
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
                            <div id="img-thumbnail" class="img-thumbnail" style="background-image: url({{$img_thumb}})"></div>
                        </div>
                    </div>
                @endif



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
        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
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
    @endif


@endsection


@section('footer_js')
    <script src="{{ asset('js/jquery.mask.min.js')}}"></script>
    @if($image==true)
        <script src="{{ asset('js/cropper.js') }}"></script>
        <script>

            var bs_modal = $('#modal');
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
    @endif
@endsection
