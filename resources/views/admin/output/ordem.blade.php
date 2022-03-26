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
            <b>DATA DO PEDIDO:</b> {{ $data_pedido }}
        </td>
        <td>
            <b>DATA E HORA DA ENTREGA:</b>
        </td>
    </tr>
    <tr>
        <td>
            <b>DATA DE SEPARAÇÃO:</b> {{ $data_separacao }}
        </td>
        <td>
            <b>RECEBIDO POR:</b>
        </td>
    </tr>
    @if($funcionario)
    <tr>
        <td colspan="2">
            <b>EPI PARA:</b> {{ $funcionario }}
        </td>
    </tr>
    @endif
</table>


<div class="h5">
    <b>{{$cliente}}</b>
</div>

<div style="border-top: 3px solid #555; border-bottom: 1px dashed #555" class="mt-3 mb-3 p-3">
    Declaro, pelo presente documento de responsabilidade, que recebi os produtos da empresa Resolve Prestação de Serviços o(s) material(ais) relacionado(s) abaixo.
</div>

<table class="table table-bordered mt-5 " style="font-size: 10px">
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
