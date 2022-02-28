@if(isset($busca_por))
    <div class="container list-group-item bg-info rounded-3 bg-opacity-10 mb-3">
        Busca por: <b><i>{{Session::get('busca_por')}}</i></b>
    </div>
@endif
