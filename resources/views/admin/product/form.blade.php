@extends('layouts.admin')
@section('content')

    @php
        $model = 'products';
        $action_model = 'create';
        $action = "Cadastrar";
        $id = null;
        $name = null;
        $amount = 0;
        $amount_alert = 0;


        $img_thumb = "public/images/produto-sem-foto.jpg";

    @endphp


    <div class="row-cols-md-1">
        <div class="container-md">
            @php
              if(isset($product)){
                $action_model = 'update';
                $id = $product->id;
                $name = $product->name;
                $amount = $product->amount;
                $amount_alert = $product->amount_alert;
                $action="Editar";

                if(file_exists("images/$model/$id.jpg"))
                {
                    $img_thumb =  asset("images/$model/$id.jpg").'?'.mt_rand(111,999);
                } else {
                    $img_thumb = "public/images/produto-sem-foto.jpg";
                }
                }

            @endphp
            <h1 class="page-title">{{$action}} Produtox</h1>

            <form action="{{route("admin.$model.action.$action_model")}}" method="post" enctype="multipart/form-data">
                @csrf
                @if($id!=null)
                    <input type="hidden" name="id" value="{{$id}}">
                @endif
                <div class="mb-3">
                    <label for="name" class="form-label">Nome*</label>
                    <input type="text" required name="name" class="form-control" id="name" aria-describedby="nameHelp" value="{{$name}}">
                </div>
                <div class="mb-3">
                    <label for="amount" class="form-label">Quantidade</label>
                    <input type="text" required name="amount" class="form-control" id="amount" aria-describedby="amountHelp" value="{{$amount}}">
                </div>
                <div class="mb-3">
                    <label for="amount_alert" class="form-label">Quantidade de alerta</label>
                    <input type="text" required name="amount_alert" class="form-control" id="amount_alert" aria-describedby="amount_alertHelp" value="{{$amount_alert}}">
                </div>

                <div class="row">
                    <div class="col-10">
                        <div class="mb-3">
                            <label for="amount_alert" class="form-label">Imagem</label>
                            <div class="input-group mb-3">
                                <input type="hidden" id="image-crop" name="image-crop">
                                <input  type="file" name="image" class="form-control image-crop" id="inputGroupFile02">
                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div id="img-thumbnail" class="img-thumbnail" style="background-image: url({{$img_thumb}})"></div>

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


    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Crop image</h5>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="crop">Crop</button>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('footer_js')
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
@endsection
