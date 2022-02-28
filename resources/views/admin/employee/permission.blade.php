@extends('layouts.admin')
@section('content')

    @php
        //ddd($menus_grid);
        $model = 'employees';
        $action_model = 'create';
        $action = "Perissões";
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

            <form action="{{route("admin.$model.permission.do")}}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="user_id" value="{{$user_id}}">
                @csrf
                @if($id!=null)
                    <input type="hidden" name="id" value="{{$id}}">
                @endif

                <table class="table">
                @foreach($menus_grid as $grid_menu)
                    <tr>
                        <td class="bg-black bg-opacity-10" colspan="2">
                            <h4>
                                <input type="checkbox" {{$grid_menu['menu_checked']}} name="menu_id[]" value="{{$grid_menu['menu_id']}}">  {{$grid_menu['menu_nome']}}
                            </h4>
                        </td>
                    </tr>
                    @foreach($grid_menu['submenus'] as $grid_submenu)
                        <tr>
                            <td>
                                <input type="checkbox" {{$grid_submenu['submenu_checked']}} name="submenu_id_{{$grid_menu['menu_id']}}[]" value="{{$grid_submenu['submenu_id']}}">  {{$grid_submenu['submenu_nome']}}
                            </td>
                            <td>
                                @foreach($grid_submenu['actions'] as $grid_actions)
                                    <div>
                                        <input type="checkbox" {{$grid_actions['action_checked']}} name="action_id_{{$grid_menu['menu_id']}}_{{$grid_submenu['submenu_id']}}[]" value="{{$grid_actions['action_id']}}"> {{$grid_actions['action_nome']}}
                                    </div>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                @endforeach
                </table>

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
