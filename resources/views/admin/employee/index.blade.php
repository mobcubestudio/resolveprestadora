@extends('layouts.admin')
@section('content')

@php
    $model = 'employees';
    $var = 'employee';
    $base_uri = 'funcionarios';
    $genre = 'o';
    $name_singular = 'funcionário';
    $name_plural = 'Funcionários';
@endphp



<div class="container">
    <h1 class="pt-4 pb-4 text-center">Lista de {{ucfirst($name_plural)}}</h1>
    @include('admin.includes.busca-por')
    <table class="table table-hover table-striped table-responsive">
        <thead class="bg-primary text-white">
            <tr >
                <th class="col text-center" style="width: 100px">Foto</th>
                <th class="col">Nome</th>
                <th class="col">Matrícula</th>
                <th class="col">Telefone</th>
                <th class="col text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @if(count($employees) == 0)
                <tr>
                    <td colspan="5" class="text-center">
                        Nenhum {{$name_singular}} cadastrado.
                    </td>
                </tr>
            @endif

            @foreach($employees as $employee)
            <tr class="align-middle">



                <td class="text-center">
                    @if(file_exists("images/$model/$employee->id.jpg"))
                        <img class="img-thumbnail" src="{{asset("images/$model/$employee->id.jpg")}}" alt="{{$employee->name}}">
                    @endif
                </td>
                <td>{{$employee->name}}</td>
                <td >{{$employee->registration}}</td>
                <td >{{$employee->phone}}</td>



                <td class="text-center">
                    <!--a class="icon-action" style="margin-right: 1em" href="{{asset("admin/$base_uri/form")}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Relatório de: {{$employee->name}}">
                        <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                            <use xlink:href="{{asset('images/actions/bootstrap-icons.svg')}}#file-earmark-text"></use>
                        </svg>
                    </a>
                    <a class="icon-action" style="margin-right: 1em" href="{{route("admin.$model.form.edit",["$var"=>$employee])}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar: {{$employee->name}}">
                        <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                            <use xlink:href="{{asset('images/actions/bootstrap-icons.svg')}}#pencil-square"></use>
                        </svg>
                    </a>
                    <a onclick="return confirm('Tem certeza que deseja mover {{$genre}} {{$name_singular}} {{$employee->name}} para a lixeira?')" class="icon-action" style="margin-right: 0em" href="{{route("admin.$model.destroy",$employee)}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir: {{$employee->name}}">
                        <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                            <use xlink:href="{{asset('images/actions/bootstrap-icons.svg')}}#trash-fill"></use>
                        </svg>
                    </a-->

                @php
                    Tools::montaAcoes([$var=>$employee]);
                @endphp

                </th>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- PAGINACAO -->
    {{$employees->links('layouts.pagination')}}











    <!-- MODAL -->
    <div id="modal" class="modal fade bd-example-modal-lg" data-bs-backdrop="static" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content p-3">
                <h3 class="text-center text-info mb-3">EPIS</h3>
                <form id="modal-form" action="{{route("admin.$model.action")}}" method="post">
                    @csrf
                    <textarea class="description" name="epis" id="epis" style="width: 100%"></textarea>
                    <input type="hidden" name="id" id="id">



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
        <script src="https://cdn.tiny.cloud/1/c0gypqbhocby1mgj3twaa7lastoqu5egw8ov80md4acaaail/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector:'textarea.description',
                height: 500,
                menubar: false
            });
        </script>
        <script>
            $(function () {

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


                $(document).on('click','#ver-epis',function () {

                    let _token   = $('meta[name="csrf-token"]').attr('content');
                    var id = $(this).attr('data-id');
                    var modal_products = $("#modal");
                    modal_products.modal('show');

                    $("#id").val(id);
                    $("#modal-submit").attr('id-order',id);

                    $.ajax({
                        url: "{{route('admin.ajax.funcionario.epis')}}",
                        cache: false,
                        type: 'POST',
                        data: {
                            id:id,
                            _token: _token
                        },
                        success: function (data) {
                            tinyMCE.activeEditor.setContent(data);
                            //$("#epis").text('data');
                            console.log(data);
                        }
                    });
                });
            });
        </script>
@endsection
