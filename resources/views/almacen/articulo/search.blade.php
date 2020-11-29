<form action="{{url('almacen/articulo')}}" method="get" class="form-group">
    <div class="input-group">
        <input class="form-control" type="text" name="searchText" placeholder="Buscar..." value="{{ $searchText ?? ''}}" title="Busque por nombre, id, codigo o categoria">
        <span class="input-group-btn">
            <button type="submit" class="btn btn-primary"> Buscar </button>
        </span>
    </div>
</form>