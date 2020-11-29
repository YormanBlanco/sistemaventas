<form action="{{url('ventas/cliente')}}" method="get" class="form-group">
    <div class="input-group">
        <input class="form-control" type="text" name="searchText" placeholder="Buscar..." value="{{ $searchText ?? ''}}" title="Busque por nombre o documento de identidad">
        <span class="input-group-btn">
            <button type="submit" class="btn btn-primary"> Buscar </button>
        </span>
    </div>
</form>

