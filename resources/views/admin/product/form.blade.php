@extends('layouts.admin')
@section('content')
    @php
    $action = "Cadastrar"
    @endphp
    <div class="row-cols-md-1">
        <div class="container-md">
            @if(isset($product))
                @php
                  $action="Editar"
                @endphp
            @endif
            <h1 class="page-title">{{$action}} Produto</h1>

            <form action="{{route('admin.products.form.action')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nome*</label>
                    <input type="text" required name="name" class="form-control" id="name" aria-describedby="nameHelp" value="{{$product->name}}">
                </div>
                <div class="mb-3">
                    <label for="amount" class="form-label">Quantidade</label>
                    <input type="text" required name="amount" class="form-control" id="amount" aria-describedby="amountHelp" value="{{$product->amount}}">
                </div>
                <div class="mb-3">
                    <label for="amount_alert" class="form-label">Quantidade de alerta</label>
                    <input type="text" required name="amount_alert" class="form-control" id="amount_alert" aria-describedby="amount_alertHelp" value="{{$product->amount_alert}}">
                </div>

                <div class="row">
                    <div class="col-10">
                        <div class="mb-3">
                            <label for="amount_alert" class="form-label">Imagem</label>
                            <div class="input-group mb-3">
                                <input type="file" name="image" class="form-control" id="inputGroupFile02">
                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        @if(file_exists("images/products/$product->id.jpg"))
                            <img class="img-thumbnail" src="{{asset("images/products/$product->id.jpg")}}" alt="{{$product->name}}">
                        @else
                            <img class="img-thumbnail" src="{{asset("images/produto-sem-foto.jpg")}}" alt="{{$product->name}}">
                        @endif
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

@endsection
