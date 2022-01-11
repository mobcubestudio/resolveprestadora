@extends('layouts.admin')
@section('content')
    <div class="row-cols-md-1">
        <div class="container-md">

            <h1>Cadastrar Produto</h1>

            <form action="{{route('admin.products.form.action')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nome*</label>
                    <input type="text" required name="name" class="form-control" id="name" aria-describedby="nameHelp">
                    <div id="nameHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="amount" class="form-label">Quantidade</label>
                    <input type="text" name="amount" class="form-control" id="amount" aria-describedby="amountHelp" value="0">
                    <div id="amountHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="amount_alert" class="form-label">Quantidade de alerta</label>
                    <input type="text" name="amount_alert" class="form-control" id="amount_alert" aria-describedby="amount_alertHelp" value="0">
                    <div id="amount_alertHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>

                <div class="input-group mb-3">
                    <input type="file" name="image" class="form-control" id="inputGroupFile02">
                    <label class="input-group-text" for="inputGroupFile02">Upload</label>
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
