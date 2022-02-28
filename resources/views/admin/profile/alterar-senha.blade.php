@extends('layouts.admin')

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')

    @php
        use Illuminate\Support\Facades\Session;
        //dd($data);
        $model = 'profiles';
        $action_model = 'password.alter.do';
        $name_plural = 'submenus';
        $name_singular = 'submenu';

        $image = false;

        $action = "Cadastrar";

        $id = null;
        $name = null;
        $asset = null;
        $divisor = null;

        $img_thumb = asset("images/produto-sem-foto.jpg");

    @endphp


    <div class="row-cols-md-1 pb-5">
        <div class="container-md">
            @php
              if(isset($data)){
                $action_model = 'update';
                $action="Editar";

                $id = $data->id;
                $name = $data->name;
                $asset = $data->asset;
                $divisor = $data->divisor;

                if(file_exists("images/$model/$id.jpg"))
                {
                    $img_thumb =  asset("images/$model/$id.jpg").'?'.mt_rand(111,999);
                } else {
                    $img_thumb = asset("images/produto-sem-foto.jpg");
                }
                }

            @endphp
            <h1 class="page-title">Alterar Senha</h1>

            <form id="form" action="{{route("admin.$model.$action_model")}}" method="post" enctype="multipart/form-data">
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
                        ['Senha Atual',true,'old-password',null,null,'password',''],
                        ['Nova Senha',true,'new-password',null,null,'password',''],
                        ['Repetir Nova Senha',true,'rep-new-password',null,null,'password','']

                    ];
                @endphp



                @foreach($fields as $field)
                    @if($field[5]=='text' || $field[5]=='password')
                        <div class="mb-3">
                            <label for="{{$field[2]}}" class="form-label">{{$field[0]}}@if($field[1]==true)*@endif</label>
                            <input type="{{$field[5]}}" @if($field[3]!=null)data-mask="{{$field[3]}}" @if($field[5]==true) data-mask-reverse="true" @endif @endif @if($field[1]==true) required @endif name="{{$field[2]}}" class="form-control" id="{{$field[2]}}" aria-describedby="{{$field[2]}}Help" value="{{$field[6]}}">
                        </div>

                    @elseif($field[5]=='hidden')
                        <input type="{{$field[5]}}" @if($field[3]!=null)data-mask="{{$field[3]}}" @if($field[5]==true) data-mask-reverse="true" @endif @endif name="{{$field[2]}}" class="form-control" id="{{$field[2]}}" aria-describedby="{{$field[2]}}Help" value="{{$field[6]}}">



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


                    @elseif($field[5]=='select-manual')
                        <div class="mb-3">
                            <label for="{{$field[2]}}" class="form-label">{{$field[0]}}@if($field[1]==true)*@endif</label>
                            <select @if($field[1]==true) required @endif id="{{$field[2]}}" name="{{$field[2]}}" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                                <option value="">Selecione</option>
                                @foreach($field[7] as $list_data[$field[2]])
                                    <option @if($field[6]==$list_data[$field[2]]) selected @endif
                                    value="{{$list_data[$field[2]][0]}}">{{$list_data[$field[2]]}}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                @endforeach



                @if($image==true)
                    @include('layouts.ImageSend.field')
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
        @include('layouts.ImageSend.modal')
    @endif


@endsection


@section('footer_js')
    @if($image==true)
        @include('layouts.ImageSend.js')
    @endif
    <script>
        $(function(){
            //EXCLUIR PRODUTO DA LISTA
            /*$(document).on("submit","#form",function ()
            {
                var cp_senha = $("#new-password").val();
                var cp_rep_senha = $("#rep-new-password").val();

                if(cp_senha != cp_rep_senha) {
                    alert('Os campos para a nova senha precisam ser iguais.');
                    return false;
                }
            });*/
        });
    </script>

@endsection
