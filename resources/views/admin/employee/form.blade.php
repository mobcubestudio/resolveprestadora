@extends('layouts.admin')
@section('content')

    @php
        $model = 'employees';
        $action_model = 'create';
        $action = "Cadastrar";
        $id = null;
        $role_id = null;
        $registration = null;
        $name = null;
        $cpf = null;
        $rg = null;
        $address = null;
        $birth_date = null;
        $marital_status = 'S';
        $email = null;
        $phone = null;

        $img_thumb = asset("images/produto-sem-foto.jpg");

    @endphp


    <div class="row-cols-md-1 pb-5">
        <div class="container-md">
            @php
              if(isset($employee)){
                $action_model = 'update';
                $registration = $employee->registration;
                $id = $employee->id;
                $role_id = $employee->role_id;
                $name = $employee->name;
                $cpf = $employee->cpf;
                $rg = $employee->rg;
                $address = $employee->address;
                $birth_date = date_format(date_create($employee->birth_date),'d/m/Y');
                $marital_status = $employee->marital_status;
                $email = $employee->email;
                $phone = $employee->phone;
                $action="Editar";

                if(file_exists("images/$model/$id.jpg"))
                {
                    $img_thumb =  asset("images/$model/$id.jpg").'?'.mt_rand(111,999);
                } else {
                    $img_thumb = asset("images/produto-sem-foto.jpg");
                }
                }

            @endphp
            <h1 class="page-title">{{$action}} Funcionário</h1>

            <form action="{{route("admin.$model.action.$action_model")}}" method="post" enctype="multipart/form-data">
                @csrf
                @if($id!=null)
                    <input type="hidden" name="id" value="{{$id}}">
                @endif
                <div class="mb-3">
                    <label for="amount_alert" class="form-label">Função</label>
                    <select required id="role_id" name="role_id" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                        <option value="">Selecione</option>
                        <option @if($role_id==1) selected @endif value="1">Diretor</option>
                        <option @if($role_id==2) selected @endif value="2">RH</option>
                        <option @if($role_id==3) selected @endif value="3">Secretária</option>
                        <option @if($role_id==4) selected @endif value="4">Fiscal de posto</option>
                        <option @if($role_id==5) selected @endif value="5">Entregador</option>
                        <option @if($role_id==6) selected @endif value="6">Porteiro</option>
                        <option @if($role_id==7) selected @endif value="7">Jardineiro</option>
                        <option @if($role_id==8) selected @endif value="8">Serviços gerais</option>
                        <option @if($role_id==9) selected @endif value="9">Zelador</option>
                        <option @if($role_id==10) selected @endif value="10">Vigia</option>
                        <option @if($role_id==11) selected @endif value="11">Administrativo</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="amount" class="form-label">Matrícula*</label>
                    <input type="text" data-mask="0000000" required name="registration" class="form-control" id="registration" aria-describedby="registrationHelp" value="{{$registration}}">
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Nome Completo*</label>
                    <input type="text" required name="name" class="form-control" id="name" aria-describedby="nameHelp" value="{{$name}}">
                </div>

                <div class="mb-3">
                    <label for="amount_alert" class="form-label">CPF*</label>
                    <input type="text" required name="cpf" class="form-control " data-mask="000.000.000-00" id="cpf" aria-describedby="cpfHelp" value="{{$cpf}}">
                </div>

                <div class="mb-3">
                    <label for="amount_alert" class="form-label">RG*</label>
                    <input type="text" required name="rg" class="form-control" id="rg" aria-describedby="rgHelp" value="{{$rg}}">
                </div>

                <div class="mb-3">
                    <label for="amount_alert" class="form-label">Endereço*</label>
                    <input type="text" required name="address" class="form-control" id="address" aria-describedby="addressHelp" value="{{$address}}">
                </div>

                <div class="mb-3">
                    <label for="amount_alert" class="form-label">Data de Nascimento*</label>
                    <input type="text" required name="birth_date" data-mask="00/00/0000" class="form-control" id="birth_date" aria-describedby="birth_dateHelp" value="{{$birth_date}}">
                </div>

                <div class="mb-3">
                    <label for="amount_alert" class="form-label">Estado Civil</label>
                    <select id="marital_status" name="marital_status" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                        <option @if($marital_status=='S') selected @endif  value="S">Solteiro</option>
                        <option @if($marital_status=='C') selected @endif  value="C">Casado</option>
                        <option @if($marital_status=='V') selected @endif  value="V">Viúvo</option>
                        <option @if($marital_status=='D') selected @endif  value="D">Divorciado</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="amount_alert" class="form-label">E-mail*</label>
                    <input type="email" required name="email" class="form-control" id="email" aria-describedby="emailHelp" value="{{$email}}">
                </div>

                <div class="mb-3">
                    <label for="amount_alert" class="form-label">Telefone</label>
                    <input type="text" name="phone" class="form-control" data-mask="(00) 00000-0000" id="phone" aria-describedby="phoneHelp" value="{{$phone}}">
                </div>







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
    <script src="{{ asset('js/jquery.mask.min.js')}}"></script>
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
