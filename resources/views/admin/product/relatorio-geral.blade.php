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
                Relatório de Quantidade de Produtos<br />
            </i>
        </td>
    </tr>
</table>




<table class="table table-bordered mb-5 " style="font-size: 10px">
    <thead>
    <tr class="table-success">
        <th scope="col" class="text-center">ID</th>
        <th scope="col">Produto</th>
        <th scope="col" class="text-center">Quantidade</th>
    </tr>
    </thead>
    <tbody>
        @foreach($produtos as $res)
        <tr>
            <td class="align-middle text-center"> {{$res->id}} </td>
            <td class="align-middle text-start"> {{$res->name}} </td>
            <td class="align-middle text-center"> {{$res->amount}} </td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
