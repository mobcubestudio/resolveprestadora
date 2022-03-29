<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
    <title>PDF</title>
</head>
<body>
<table  width="100%">
    <tr>
        <td>
            <img src="{{asset('images/logo.jpg')}}" alt="" style="width: 100px">
        </td>
        <td class="align-middle" style="text-align: right">
            <i>
                Departamento de Patrimônio e Material<br />
                <b>Setor Almoxarifado</b><br />
                <b class="h3">#{{$pedido_numero}}</b>
            </i>
        </td>
    </tr>
</table>



<table class="table table-bordered mb-3 " style="font-size: 12px">
    <tr>
        <td>
            <b>AÇÃO</b>
        </td>
        <td>
            <b>RESPONSÁVEL</b>
        </td>
        <td>
            <b>DATA E HORA</b>
        </td>
    </tr>
    <tr>
        <td>
            PEDIDO
        </td>
        <td>
            {{ $pedido_responsavel }}
        </td>
        <td>
            {{ $data_pedido }}
        </td>
    </tr>
    <tr>
        <td>
            SEPARAÇÃO
        </td>
        <td>
            {{ $separacao_responsavel }}
        </td>
        <td>
            {{ $data_separacao }}
        </td>
    </tr>
    <tr>
        <td>
            ROTA
        </td>
        <td>
            {{ $rota_responsavel }}
        </td>
        <td>
            {{ $data_rota }}
        </td>
    </tr>
    <tr>
        <td>
            ENTREGA
        </td>
        <td>
            {{ $entrega_responsavel }}
            {{ $entrega_anotacao }}
        </td>
        <td>
            {{ $data_entrega }}
        </td>
    </tr>

</table>


<div class="h5 mt-4 pt-4" style="border-top: 3px solid #555; ">
    <b>{{$cliente}}</b>
</div>



<table class="table table-bordered mt-1 " style="font-size: 10px">
    <thead>
    <tr class="table-success">
        <th scope="col">Produto</th>
        <th scope="col" class="text-center">Quantidade</th>
    </tr>
    </thead>
    <tbody>
    @foreach($pedidos as $res)
        <tr>
            <td class="align-middle text-start"> {{$res->produto}} </td>
            <td class="align-middle text-center"> {{$res->amount}} </td>
        </tr>
    @endforeach
    </tbody>
</table>





</body>
</html>
