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
                Relatório de Pedidos<br />
                <b>{{$produto}}</b>
            </i>
        </td>
    </tr>
</table>




<table class="table table-bordered mb-5 " style="font-size: 10px">
    <thead>
    <tr class="table-success">
        <th scope="col" class="text-center">Data</th>
        <th scope="col">Cliente</th>
        <th scope="col">Status</th>
        <th scope="col" class="text-center">Quantidade</th>
        <th scope="col">Histórico</th>
    </tr>
    </thead>
    <tbody>
        @foreach($pedidos as $res)
        <tr>
            <td class="align-middle text-center"> {{ date_format(date_create($res->ordered_date_time),'d/m/Y')}} </td>
            <td class="align-middle text-start"> {{$res->cliente}} </td>
            <td  class="align-middle text-start"> {{ Tools::getStatusPedido($res->status) }} </td>
            <td class="align-middle text-center"> {{$res->amount}} </td>
            <td>
                <div class="border-bottom">
                    Pedido: ({{ date_format(date_create($res->ordered_date_time),'d/m H:i')}}) {{ Session::get('funcionario['.$res->ordered_by.']')}}
                </div>
                <div class="border-bottom">
                    Separado: @if($res->selected_date_time)({{ date_format(date_create($res->selected_date_time),'d/m H:i')}}) {{ Session::get('funcionario['.$res->selected_by.']')}}@endif
                </div>
                <div class="border-bottom">
                    Rota: @if($res->sent_date_time)({{ date_format(date_create($res->sent_date_time),'d/m H:i')}}) {{ Session::get('funcionario['.$res->sent_by.']')}}@endif
                </div>
                <div class="">
                    Entrega: @if($res->received_date_time)
                                ({{ date_format(date_create($res->received_date_time),'d/m H:i')}}) {{ Session::get('funcionario['.$res->received_by.']')}}
                        @if($res->received_notes)<div style="padding: 2px;background: #9ffa02"><i>Obs.: {{$res->received_notes}}</i></div>@endif
                            @endif
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
